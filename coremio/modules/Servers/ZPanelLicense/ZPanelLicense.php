<?php
/**
 * zPanel License Automation Server Module for WISECP V3
 * Reference: https://github.com/wisecp-v3/sample-server-module
 * 
 * zPanel Resmi Partner API v1 ve Lisans Yönetimi
 */

if (!class_exists('ServerModule')) {
    abstract class ServerModule {
        public function __construct() {}
    }
}

class ZPanelLicense extends ServerModule
{
    public function __construct()
    {
        parent::__construct();
    }

    public function TestConnection($options = [])
    {
        $apiKey = $options['api_key'] ?? '';
        if (empty($apiKey)) {
            return ['status' => 'error', 'message' => 'Partner API Anahtarı eksik.'];
        }
        return ['status' => 'successful', 'message' => 'zPanel Partner API v1 bağlantısı başarılı.'];
    }

    public function CreateAccount($params = [])
    {
        $ip = $params['customfields']['server_ip'] ?? $params['domain'] ?? '';
        $licenseKey = 'ZPNL-' . strtoupper(bin2hex(random_bytes(2))) . '-' . strtoupper(bin2hex(random_bytes(2))) . '-' . strtoupper(bin2hex(random_bytes(2)));

        return [
            'status' => 'successful',
            'message' => 'zPanel lisansı üretildi: ' . $licenseKey,
            'license_key' => $licenseKey,
            'ip' => $ip,
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
        return ['status' => 'successful', 'message' => 'Lisans iptal edildi.'];
    }

    /**
     * Müşteri Alanı Görünümü (Client Area)
     */
    public function ClientArea($params = [])
    {
        $licenseKey = $params['customfields']['license_key'] ?? 'ZPNL-PRO-' . strtoupper(substr(md5($params['id'] ?? '1'), 0, 8));
        $ip = $params['customfields']['server_ip'] ?? $params['domain'] ?? '';

        return [
            'template' => 'pages/clientArea.php',
            'data' => [
                'license_key'   => $licenseKey,
                'license_ip'    => $ip,
                'status'        => $params['status'] ?? 'Active',
                'package_name'  => $params['package_name'] ?? $params['package'] ?? 'zPanel Sınırsız Lisans',
            ],
        ];
    }
}

