<?php
/**
 * zPanel Lisans Satış Modülü - WISECP v3 Konfigürasyonu
 * Resmi Dokümantasyon: https://console.zepanel.com/partner/docs
 */
return [
    'type-version'      => '3.0',
    'name'              => 'ZPanelLicense',
    'readable-name'     => 'zPanel Lisans Otomasyon Modülü',
    'status'            => true,
    'authors'           => 'zPanel Team',
    'version'           => '1.1.0',

    // Sunucu / API Ayarları
    'server-fields'     => [
        'partner_api_url' => [
            'name'        => 'Partner API Adresi',
            'type'        => 'text',
            'default'     => 'https://console.zepanel.com/partner-api/v1',
            'description' => 'Varsayılan: https://console.zepanel.com/partner-api/v1',
        ],
        'partner_key'     => [
            'name'        => 'Partner API Token (Bearer)',
            'type'        => 'password',
            'description' => 'console.zepanel.com/partner/api üzerinden üretilen zp_partner_... anahtarı',
        ],
    ],

    // Ürün / Paket Ayarları
    'options'           => [
        'order_id'        => [
            'name'        => 'Lisans Havuz Sipariş ID',
            'type'        => 'text',
            'description' => 'Partner Konsolundaki lisans havuzu sipariş numarası (Örn: 1042)',
        ],
    ],
];
