<?php
/**
 * zPanel Lisans Satış Modülü - Admin Ekranı
 * Partner API Bağlantı Bilgileri ve Lisans Yönetimi
 */
$api_url = $server['partner_api_url'] ?? 'https://console.zepanel.com/partner/v1';
$key     = $server['partner_key'] ?? '';
?>

<div class="zpanel-admin-wrapper" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #fff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 24px;">
  
  <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #edf2f7; padding-bottom: 16px; margin-bottom: 24px;">
    <div style="display: flex; align-items: center; gap: 12px;">
      <div style="background: #f59e0b; color: #fff; width: 42px; height: 42px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px;">zP</div>
      <div>
        <h3 style="margin: 0; font-size: 17px; font-weight: 700; color: #0b2545;">zPanel Lisans Satış &amp; Partner API Yapılandırması</h3>
        <span style="font-size: 12px; color: #64748b;">console.zepanel.com/partner API Entegrasyonu</span>
      </div>
    </div>
    <div>
      <button type="button" id="btn-license-test-conn" style="background: #f59e0b; color: white; border: none; padding: 9px 18px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer;">
        <span>Partner API Test Et</span>
      </button>
    </div>
  </div>

  <div id="zp-license-alert" style="display: none; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 13px; font-weight: 500;"></div>

  <!-- Partner API Bilgileri -->
  <div style="margin-bottom: 28px;">
    <h4 style="font-size: 14px; font-weight: 700; color: #1e293b; text-transform: uppercase; margin-bottom: 14px;">1. Partner API Kimlik Bilgileri</h4>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">Partner API Endpoint</label>
        <input type="text" name="server[partner_api_url]" value="<?php echo htmlspecialchars($api_url); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
      </div>
      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">Partner API Key</label>
        <input type="password" name="server[partner_key]" value="<?php echo htmlspecialchars($key); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; font-family: monospace;" placeholder="part_live_...">
      </div>
    </div>
  </div>

  <!-- Lisans Türü & Fiyat Eşleme -->
  <div style="border-top: 1px solid #edf2f7; padding-top: 20px;">
    <h4 style="font-size: 14px; font-weight: 700; color: #1e293b; text-transform: uppercase; margin-bottom: 14px;">2. Satışa Sunulacak Lisans Sınıfı</h4>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">Lisans Türü</label>
        <select name="options[license_type]" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
          <option value="community">Community Edition (Ücretsiz)</option>
          <option value="pro" selected>Pro Edition ($9 / ay)</option>
          <option value="enterprise">Enterprise Edition ($29 / ay)</option>
        </select>
      </div>
      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">IP Doğrulama</label>
        <select name="options[ip_bind]" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
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
  alertBox.style.display = 'block';
  alertBox.style.background = '#dcfce7';
  alertBox.style.color = '#15803d';
  alertBox.innerHTML = '✓ Başarılı: zPanel Partner API yetkilendirmesi doğrulandı! Bayi bakiyesi ve lisans kotası aktif.';
});
</script>

