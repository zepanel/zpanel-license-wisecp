<?php

namespace Coremio\Modules\Servers\ZPanelLicense\Lib;

/**
 * zPanel License Partner API Client for WISECP
 * Reference: https://github.com/mediacontrolpanel/wisecp-onpremise
 */
class ApiClient
{
    private string $host;
    private string $apiKey;

    public function __construct(string $host, string $apiKey)
    {
        $this->host = trim($host, '/');
        $this->apiKey = trim($apiKey);
    }

    public function request(string $method, string $uri, array $data = []): array
    {
        $url = "https://{$this->host}:8056/api/v1/" . ltrim($uri, '/');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        $method = strtoupper($method);
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $res = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = json_decode($res, true);
        return [
            'status' => ($code >= 200 && $code < 300),
            'http_code' => $code,
            'data' => $json['data'] ?? $json,
            'message' => $json['message'] ?? '',
        ];
    }
}

