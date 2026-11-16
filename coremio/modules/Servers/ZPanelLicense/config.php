<?php
/**
 * zPanel Lisans Satış Modülü - WISECP v3 Konfigürasyonu
 * Partner API v1 Mimarisiyle %100 Uyumlu
 */
return [
    'type-version'      => '3.0',
    'name'              => 'ZPanelLicense',
    'readable-name'     => 'zPanel Lisans Satış & Dağıtım Modülü',
    'status'            => true,
    'authors'           => 'zPanel Team',
    'version'           => '1.0.0',

    // Admin Partner API Bağlantı Bilgileri
    'server-fields'     => [
        'partner_api_url' => [
            'name'        => 'Partner API Uç Noktası',
            'type'        => 'text',
            'default'     => 'https://console.zepanel.com/partner/v1',
            'description' => 'zPanel resmi lisanslama API adresi',
        ],
        'partner_key'   => [
            'name'        => 'Partner API Anahtarı',
            'type'        => 'password',
            'description' => 'console.zepanel.com üzerinden aldığınız Partner API Key',
        ],
        'partner_secret'=> [
            'name'        => 'Partner Gizli Kodu (Secret)',
            'type'        => 'password',
            'description' => 'Partner API Secret imzası',
        ],
    ],

    // Ürün / Paket Lisans Seçenekleri
    'options'           => [
        'license_type'  => [
            'name'        => 'Lisans Tipi',
            'type'        => 'select',
            'options'     => [
                'community'   => 'Community (Ücretsiz Açık Kaynak)',
                'pro'         => 'Pro Edition ($9/ay)',
                'enterprise'  => 'Enterprise Edition ($29/ay)',
            ],
            'default'     => 'pro',
            'description' => 'Bu paketi satın alan müşteriye atanacak lisans sınıfı',
        ],
        'auto_ip_bind'  => [
            'name'        => 'Sipariş Sırasında IP İste',
            'type'        => 'approval',
            'checked'     => true,
            'description' => 'Müşteri satın alırken sunucu IP adresini girmek zorunda olsun',
        ],
    ],
];

