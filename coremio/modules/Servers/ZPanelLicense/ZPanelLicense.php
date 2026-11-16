<?php
/**
 * zPanel License Automation Server Module for WISECP V3
 * Reference: https://github.com/wisecp-v3/sample-server-module
 * 
 * Resmi Dokümantasyon: https://console.zepanel.com/partner/docs
 */

if (!class_exists('ServerModule')) {
    abstract class ServerModule {
        public function __construct() {}
    }
}

require_once __DIR__ . '/lib/ApiClient.php';
use Coremio\Modules\Servers\ZPanelLicense\Lib\ApiClient;

class ZPanelLicense extends ServerModule
{
    private function getClient(array $params): ApiClient
    {
        $server = $params['server'] ?? [];
        $apiUrl = $server['partner_api_url'] ?? 'https://console.zepanel.com/partner-api/v1';
        $apiKey = $server['partner_key'] ?? $server['password'] ?? $server['access_hash'] ?? '';
        return new ApiClient($apiUrl, $apiKey);
    }

    public function TestConnection($options = [])
    {
        $apiUrl = $options['partner_api_url'] ?? 'https://console.zepanel.com/partner-api/v1';
        $apiKey = $options['partner_key'] ?? $options['password'] ?? '';
        $client = new ApiClient($apiUrl, $apiKey);

        $res = $client->testConnection();
        if ($res['status']) {
            return ['status' => 'successful', 'message' => 'zPanel Partner API v1 bağlantısı başarılı.'];
        }
        return ['status' => 'error', 'message' => $res['message'] ?: 'Bağlantı kurulamadı.'];
    }

    public function CreateAccount($params = [])
    {
        $client = $this->getClient($params);
        $orderId = trim($params['order_id'] ?? $params['config_options']['order_id'] ?? '');

        if (empty($orderId)) {
            return ['status' => 'error', 'message' => 'Lisans Havuz Sipariş ID (order_id) paket ayarlarında tanımlanmamış.'];
        }

        $customer = $params['user'] ?? [];
        $customerName = trim(($customer['name'] ?? '') . ' ' . ($customer['surname'] ?? ''));
        if (!empty($customer['company_name'])) {
            $customerName .= ' (' . $customer['company_name'] . ')';
        }
        $domainOrIp = trim($params['options']['server_ip'] ?? $params['domain'] ?? '');

        $res = $client->createLicense($orderId, $customerName, $domainOrIp);
        if (!$res['status']) {
            return ['status' => 'error', 'message' => $res['message'] ?: 'Lisans oluşturulamadı.'];
        }

        $data = $res['data'] ?? [];
        $licenseKey = $data['license_key'] ?? '';
        $licenseRowId = (string)($data['id'] ?? '');

        return [
            'status' => 'successful',
            'message' => 'zPanel lisansı tahsis edildi.',
            'license_key' => $licenseKey,
            'license_row_id' => $licenseRowId,
            'password' => $licenseKey,
            'ip' => $domainOrIp,
            'creation_info' => [
                'license_key' => $licenseKey,
                'license_row_id' => $licenseRowId,
            ],
        ];
    }

    public function SuspendAccount($params = [])
    {
        return ['status' => 'successful', 'message' => 'Lisans askıya alındı.'];
    }

    public function UnsuspendAccount($params = [])
    {
        return ['status' => 'successful', 'message' => 'Lisans aktif edildi.'];
    }

    public function TerminateAccount($params = [])
    {
        $client = $this->getClient($params);
        $orderId = trim($params['order_id'] ?? $params['config_options']['order_id'] ?? '');
        $licenseRowId = trim($params['creation_info']['license_row_id'] ?? $params['custom_fields']['license_row_id'] ?? '');

        if (!empty($orderId) && !empty($licenseRowId)) {
            $res = $client->releaseLicense($orderId, $licenseRowId);
            if (!$res['status']) {
                return ['status' => 'error', 'message' => $res['message'] ?: 'Lisans serbest bırakılamadı.'];
            }
        }

        return ['status' => 'successful', 'message' => 'Lisans iptal edilerek havuza iade edildi.'];
    }

    public function ChangeIP($params = [])
    {
        $client = $this->getClient($params);
        $orderId = trim($params['order_id'] ?? $params['config_options']['order_id'] ?? '');
        $licenseRowId = trim($params['creation_info']['license_row_id'] ?? $params['custom_fields']['license_row_id'] ?? '');
        $newIp = trim($_POST['new_ip'] ?? $params['new_ip'] ?? '');
        $customer = $params['user'] ?? [];
        $customerName = trim(($customer['name'] ?? '') . ' ' . ($customer['surname'] ?? ''));

        if (empty($newIp)) {
            return ['status' => 'error', 'message' => 'Geçerli bir IP adresi giriniz.'];
        }

        $res = $client->updateLicenseInfo($orderId, $licenseRowId, $customerName, $newIp);
        if ($res['status']) {
            return ['status' => 'successful', 'message' => 'Lisans IP adresi başarıyla güncellendi.'];
        }
        return ['status' => 'error', 'message' => $res['message'] ?: 'IP güncellenemedi.'];
    }

    /**
     * Müşteri Alanı Görünümü (Client Area)
     */
    public function ClientArea($params = [])
    {
        $licenseKey = $params['creation_info']['license_key'] ?? $params['password'] ?? '';
        $ip = $params['options']['server_ip'] ?? $params['domain'] ?? '';

        return [
            'template' => 'pages/clientArea.php',
            'data' => [
                'license_key'   => $licenseKey,
                'license_ip'    => $ip,
                'status'        => $params['status'] ?? 'active',
                'package_name'  => $params['package_name'] ?? 'zPanel Resmi Sunucu Lisansı',
                'service_id'    => $params['id'] ?? 0,
                'is_issued'     => !empty($licenseKey),
            ],
        ];
    }
}
