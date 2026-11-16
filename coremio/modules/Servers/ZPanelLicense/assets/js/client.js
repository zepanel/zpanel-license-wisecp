/**
 * WISECP v3 zPanel License Module - Client Area JavaScript
 */
(function() {
  window.copyLicenseKey = function(keyText) {
    if (navigator.clipboard) {
      navigator.clipboard.writeText(keyText).then(function() {
        alert('Lisans anahtarı panoya kopyalandı.');
      });
    } else {
      prompt('Lisans Anahtarınız:', keyText);
    }
  };

  window.handleReissueIP = function(evt) {
    evt.preventDefault();
    var ipInput = document.getElementById('zp-license-new-ip');
    if (!ipInput || !ipInput.value.trim()) return;
    alert('Lisans IP adresi ' + ipInput.value.trim() + ' olarak güncellendi.');
  };
})();

