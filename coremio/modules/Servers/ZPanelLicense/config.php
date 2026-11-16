<?php
/**
 * zPanel Lisans Dağıtım Modülü - WISECP v3 & v5 Konfigürasyonu
 * Resmi Partner API: https://console.zepanel.com/partner-api/v1
 */
return [
    'name'                        => 'ZPanelLicense',
    'readable-name'               => 'zPanel Lisans Dağıtım Modülü',
    'type'                        => 'license',
    'type-version'                => '3.0',
    'status'                      => true,
    'authors'                     => 'zPanel Team',
    'version'                     => '1.1.0',

    // WISECP 3 & 5 Çift Uyumluluk Anahtarları
    'access-hash'                 => true,
    'use-access-hash'             => true,
    'require-access-hash'         => true,
    'server-info-checker'         => true,
    'use-test-connection'         => true,
    'server-info-port'            => false,
    'use-port'                    => false,
    'use-ssl'                     => true,

    // Desteklenen Yetenekler (Supported Capabilities)
    'supported'                   => [
        'change-ip',
    ],

    // Sunucu Ekleme / Bağlama Ekranında Admin'den İstenen Alanlar
    'server-fields'               => [
        'partner_api_url' => [
            'name'        => 'Partner API Uç Noktası',
            'type'        => 'text',
            'default'     => 'https://console.zepanel.com/partner-api/v1',
            'description' => 'zPanel Resmi Partner Konsol API URL adresi',
        ],
        'partner_key' => [
            'name'        => 'Partner Gizli API Anahtarı',
            'type'        => 'password',
            'description' => 'console.zepanel.com/partner adresinden aldığınız PARTNER_API_KEY anahtarı',
        ],
    ],

    // Paket Tanımlama / Ürün Özellikleri Ekranında Admin'den İstenen Alanlar
    'options'                     => [
        'order_id' => [
            'name'        => 'Lisans Havuz Sipariş ID (order_id)',
            'type'        => 'text',
            'description' => 'Partner konsolundaki toplu lisans havuz sipariş ID numarası',
        ],
        'package_type' => [
            'name'        => 'Lisans Paket Türü',
            'type'        => 'select',
            'options'     => [
                'standard'   => 'zPanel Standart Lisans',
                'pro'        => 'zPanel Profesyonel Lisans',
                'datacenter' => 'zPanel Veri Merkezi / Sınırsız Lisans',
            ],
            'default'     => 'standard',
        ],
    ],
];
