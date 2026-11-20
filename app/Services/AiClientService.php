<?php

namespace App\Services;

use App\Models\UserAiSetting;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Throwable;

class AiClientService
{
    /**
     * Send chat completion request to the OpenAI-compatible endpoint.
     *
     * @param  array<int, array{role: string, content: string}>  $messages
     * @return array{success: bool, content: ?string, reply: ?string, message: string, latency_ms: int, status_code: ?int, raw: ?array}
     */
    public function chat(
        UserAiSetting $setting,
        array $messages,
        float $temperature = 0.7,
        int $maxTokens = 800
    ): array {
        $result = $this->sendRequest(
            baseUrl: $setting->base_url,
            apiKey: $setting->api_key,
            modelName: $setting->model_name,
            messages: $messages,
            temperature: $temperature,
            maxTokens: $maxTokens,
            timeout: 30
        );

        return [
            'success' => $result['success'],
            'content' => $result['reply'],
            'reply' => $result['reply'],
            'message' => $result['message'],
            'latency_ms' => $result['latency_ms'],
            'status_code' => $result['status_code'],
            'raw' => $result['raw'],
        ];
    }

    /**
     * Test connection to an OpenAI-compatible endpoint.
     *
     * @return array{success: bool, message: string, latency_ms: int, reply: ?string}
     */
    public function testConnection(string $baseUrl, ?string $apiKey, string $modelName): array
    {
        $testMessages = [
            [
                'role' => 'user',
                'content' => 'Balas dengan satu kata: OK',
            ],
        ];

        $result = $this->sendRequest(
            baseUrl: $baseUrl,
            apiKey: $apiKey,
            modelName: $modelName,
            messages: $testMessages,
            temperature: 0.1,
            maxTokens: 10,
            timeout: 30
        );

        return [
            'success' => $result['success'],
            'message' => $result['message'],
            'latency_ms' => $result['latency_ms'],
            'reply' => $result['reply'],
        ];
    }

    /**
     * Core internal dispatcher for OpenAI-compatible chat completions.
     *
     * @param  array<int, array{role: string, content: string}>  $messages
     * @return array{success: bool, reply: ?string, latency_ms: int, message: string, status_code: ?int, raw: ?array}
     */
    protected function sendRequest(
        string $baseUrl,
        ?string $apiKey,
        string $modelName,
        array $messages,
        float $temperature = 0.7,
        int $maxTokens = 800,
        int $timeout = 30
    ): array {
        $cleanBaseUrl = rtrim(trim($baseUrl), '/');

        if (empty($cleanBaseUrl)) {
            return [
                'success' => false,
                'reply' => null,
                'latency_ms' => 0,
                'message' => 'Base URL tidak boleh kosong.',
                'status_code' => null,
                'raw' => null,
            ];
        }

        // Avoid double /chat/completions if user entered full path
        if (str_ends_with($cleanBaseUrl, '/chat/completions')) {
            $endpointUrl = $cleanBaseUrl;
        } else {
            $endpointUrl = $cleanBaseUrl . '/chat/completions';
        }

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $trimmedKey = trim($apiKey ?? '');
        if (! empty($trimmedKey)) {
            $headers['Authorization'] = 'Bearer ' . $trimmedKey;
        }

        $payload = [
            'model' => trim($modelName),
            'messages' => $messages,
            'temperature' => $temperature,
            'max_tokens' => $maxTokens,
        ];

        $startTime = microtime(true);

        try {
            $response = Http::withHeaders($headers)
                ->timeout($timeout)
                ->post($endpointUrl, $payload);

            $latencyMs = (int) round((microtime(true) - $startTime) * 1000);
            $statusCode = $response->status();

            if ($response->successful()) {
                $json = $response->json();

                if (! is_array($json)) {
                    return [
                        'success' => false,
                        'reply' => null,
                        'latency_ms' => $latencyMs,
                        'message' => 'Format respons dari server bukan format JSON yang valid.',
                        'status_code' => $statusCode,
                        'raw' => null,
                    ];
                }

                $content = $json['choices'][0]['message']['content'] ?? null;

                if ($content === null && isset($json['error'])) {
                    $errDesc = is_array($json['error']) ? ($json['error']['message'] ?? json_encode($json['error'])) : (string) $json['error'];
                    return [
                        'success' => false,
                        'reply' => null,
                        'latency_ms' => $latencyMs,
                        'message' => 'Penyedia AI mengembalikan error: ' . $errDesc,
                        'status_code' => $statusCode,
                        'raw' => $json,
                    ];
                }

                return [
                    'success' => true,
                    'reply' => is_string($content) ? trim($content) : json_encode($content),
                    'latency_ms' => $latencyMs,
                    'message' => "Koneksi berhasil! Model merespons dalam {$latencyMs} ms.",
                    'status_code' => $statusCode,
                    'raw' => $json,
                ];
            }

            // Handle non-2xx status codes
            $errorJson = $response->json();
            $serverErrorMsg = null;
            if (is_array($errorJson) && isset($errorJson['error'])) {
                $serverErrorMsg = is_array($errorJson['error']) ? ($errorJson['error']['message'] ?? null) : (string) $errorJson['error'];
            }

            $readableMessage = match ($statusCode) {
                401 => 'Autentikasi gagal (HTTP 401). API Key salah, kedaluwarsa, atau tidak memiliki izin akses.',
                403 => 'Akses ditolak (HTTP 403). Kredensial tidak diizinkan mengakses model ini.',
                404 => 'Endpoint tidak ditemukan (HTTP 404). Pastikan Base URL benar (contoh: http://domain.com/v1).',
                429 => 'Batas kuota/rate limit terlampaui (HTTP 429). Silakan periksa limit akun Anda.',
                500, 502, 503, 504 => "Server provider AI mengalami gangguan (HTTP {$statusCode}). Silakan coba beberapa saat lagi.",
                default => "Server AI mengembalikan kode HTTP {$statusCode}.",
            };

            if ($serverErrorMsg) {
                $readableMessage .= ' Keterangan: ' . $serverErrorMsg;
            }

            return [
                'success' => false,
                'reply' => null,
                'latency_ms' => $latencyMs,
                'message' => $readableMessage,
                'status_code' => $statusCode,
                'raw' => $errorJson,
            ];

        } catch (ConnectionException $e) {
            $latencyMs = (int) round((microtime(true) - $startTime) * 1000);
            return [
                'success' => false,
                'reply' => null,
                'latency_ms' => $latencyMs,
                'message' => 'Gagal terhubung ke server endpoint (' . $endpointUrl . '). Pastikan IP/Domain aktif dan dapat diakses dari server.',
                'status_code' => null,
                'raw' => null,
            ];
        } catch (Throwable $e) {
            $latencyMs = (int) round((microtime(true) - $startTime) * 1000);
            return [
                'success' => false,
                'reply' => null,
                'latency_ms' => $latencyMs,
                'message' => 'Terjadi kesalahan sistem saat menghubungi AI: ' . $e->getMessage(),
                'status_code' => null,
                'raw' => null,
            ];
        }
    }
}
