<?php

declare(strict_types=1);

namespace Prestiter\Logger\Driver;

use Prestiter\Logger\DriverInterface;
use Prestiter\Logger\LogEntry;
use Throwable;

/**
 * Driver for sending logs to New Relic Log API.
 */
final class NewRelicDriver implements DriverInterface
{
    private const ENDPOINT = 'https://log-api.newrelic.com/log/v1';

    private const TIMEOUT_SECONDS = 3;

    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function send(LogEntry $entry): void
    {
        try {
            $payload = json_encode([
                [
                    'common' => [
                        'attributes' => [
                            'logtype' => 'prestiter-logger',
                            'environment' => $entry->getEnvironment(),
                        ],
                    ],
                    'logs' => [
                        $entry->toArray(),
                    ],
                ],
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            $ch = curl_init(self::ENDPOINT);

            if ($ch === false) {
                error_log('[PrestiterLogger] Failed to initialize cURL');

                return;
            }

            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => self::TIMEOUT_SECONDS,
                CURLOPT_CONNECTTIMEOUT => self::TIMEOUT_SECONDS,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Api-Key: ' . $this->apiKey,
                ],
            ]);

            $response = curl_exec($ch);
            /** @var int $httpCode */
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);

            curl_close($ch);

            if ($response === false || $curlError !== '') {
                error_log('[PrestiterLogger] cURL error: ' . $curlError);

                return;
            }

            if ($httpCode !== 202) {
                error_log('[PrestiterLogger] New Relic API returned HTTP ' . (string) $httpCode . ': ' . $response);
            }
        } catch (Throwable $e) {
            error_log('[PrestiterLogger] Exception: ' . $e->getMessage());
        }
    }
}
