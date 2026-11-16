<?php

namespace Coremio\Modules\Servers\ZPanelLicense\Lib;

/**
 * zPanel Partner API İstemcisi (WISECP V3)
 * Resmi Dokümantasyon: https://console.zepanel.com/partner/docs
 */
class ApiClient
{
    private string $apiUrl;
    private string $apiToken;

    public function __construct(string $apiUrl, string $apiToken)
    {
        $this->apiUrl = !empty($apiUrl) ? rtrim($apiUrl, '/') : 'https://console.zepanel.com/partner-api/v1';
        $this->apiToken = trim($apiToken);
    }

    public function request(string $method, string $path, array $data = []): array
    {
        if (empty($this->apiToken)) {
            return [
                'status' => false,
                'http_code' => 401,
                'message' => 'Partner API Anahtarı (API Token) eksik.',
                'data' => null,
            ];
        }

        $url = $this->apiUrl . '/' . ltrim($path, '/');
        $ch = curl_init();

        $headers = [
            'Authorization: Bearer ' . $this->apiToken,
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: WISECP-zPanel-License/1.0',
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 25);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        $method = strtoupper($method);
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method !== 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if (!empty($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }

        $res = curl_exec($ch);
        $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($res === false) {
            return [
                'status' => false,
                'http_code' => 0,
                'message' => 'Bağlantı hatası: ' . $error,
                'data' => null,
            ];
        }

        $json = json_decode((string)$res, true);
        $isSuccess = ($code >= 200 && $code < 300);

        return [
            'status' => $isSuccess,
            'http_code' => $code,
            'data' => $json,
            'message' => $json['error'] ?? ($json['message'] ?? ($isSuccess ? 'İşlem başarılı' : "HTTP Hata {$code}")),
        ];
    }

    public function testConnection(): array
    {
        return $this->request('GET', 'packages');
    }

    public function createLicense(string $orderId, string $customerName, string $customerDomain): array
    {
        return $this->request('POST', "orders/{$orderId}/licenses", [
            'customer_name' => $customerName,
            'customer_domain' => $customerDomain ?: null,
        ]);
    }

    public function updateLicenseInfo(string $orderId, string $licenseRowId, string $customerName, string $customerDomain): array
    {
        return $this->request('POST', "orders/{$orderId}/licenses/{$licenseRowId}/info", [
            'customer_name' => $customerName,
            'customer_domain' => $customerDomain,
        ]);
    }

    public function releaseLicense(string $orderId, string $licenseRowId): array
    {
        return $this->request('POST', "orders/{$orderId}/licenses/{$licenseRowId}/release");
    }
}
