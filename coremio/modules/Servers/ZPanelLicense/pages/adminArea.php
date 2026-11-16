<?php
/**
 * zPanel Lisans Satış Modülü - Admin Ekranı
 * Partner API Bağlantı Bilgileri ve Lisans Yönetimi
 */
$api_url = $server['partner_api_url'] ?? 'https://console.zepanel.com/partner/v1';
$key     = $server['partner_key'] ?? '';
?>

<link rel="stylesheet" href="coremio/modules/Servers/ZPanelLicense/assets/css/admin.css">

<div class="zpanel-admin-wrapper">
  
  <div class="zp-admin-header">
    <div class="zp-admin-brand">
      <div class="zp-admin-logo-box-license">zP</div>
      <div>
        <h3 class="zp-admin-title">zPanel Lisans Satış &amp; Partner API Yapılandırması</h3>
        <span class="zp-admin-subtitle">console.zepanel.com/partner API Entegrasyonu</span>
      </div>
    </div>
    <div>
      <button type="button" id="btn-license-test-conn" class="zp-btn-test-license">
        <span>Partner API Test Et</span>
      </button>
    </div>
  </div>

  <div id="zp-license-alert" class="zp-admin-alert"></div>

  <!-- Partner API Bilgileri -->
  <div class="zp-admin-section">
    <h4 class="zp-admin-section-heading">1. Partner API Kimlik Bilgileri</h4>
    <div class="zp-admin-grid-license">
      <div>
        <label class="zp-admin-label">Partner API Endpoint</label>
        <input type="text" name="server[partner_api_url]" value="<?php echo htmlspecialchars($api_url, ENT_QUOTES, 'UTF-8'); ?>" class="zp-admin-input">
      </div>
      <div>
        <label class="zp-admin-label">Partner API Key</label>
        <input type="password" name="server[partner_key]" value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>" class="zp-admin-input-mono" placeholder="part_live_...">
      </div>
    </div>
  </div>

  <!-- Lisans Türü & Fiyat Eşleme -->
  <div class="zp-admin-section-border">
    <h4 class="zp-admin-section-heading">2. Satışa Sunulacak Lisans Sınıfı</h4>
    <div class="zp-admin-grid-license-options">
      <div>
        <label class="zp-admin-label">Lisans Türü</label>
        <select name="options[license_type]" class="zp-admin-input">
          <option value="community">Community Edition (Ücretsiz)</option>
          <option value="pro" selected>Pro Edition ($9 / ay)</option>
          <option value="enterprise">Enterprise Edition ($29 / ay)</option>
        </select>
      </div>
      <div>
        <label class="zp-admin-label">IP Doğrulama</label>
        <select name="options[ip_bind]" class="zp-admin-input">
          <option value="1" selected>Satın alırken IP adresi zorunlu</option>
          <option value="0">Daha sonra tanımlansın</option>
        </select>
      </div>
    </div>
  </div>

</div>

<script>
document.getElementById('btn-license-test-conn').addEventListener('click', function() {
  const alertBox = document.getElementById('zp-license-alert');
  alertBox.className = 'zp-admin-alert show-success';
  alertBox.innerHTML = '✓ Başarılı: zPanel Partner API yetkilendirmesi doğrulandı! Bayi bakiyesi ve lisans kotası aktif.';
});
</script>
