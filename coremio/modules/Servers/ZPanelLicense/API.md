# zPanel Lisans Otomasyon Modülü API Dokümantasyonu (WISECP)

zPanel Lisans modülü, resmi zPanel Partner REST API (`https://console.zepanel.com/partner-api/v1`) altyapısını kullanarak lisans havuzundan otomatik lisans tahsisi, IP güncellemesi ve iade işlemlerini gerçekleştirir.

---

## 1. Kimlik Doğrulama

WISECP ürün yapılandırmasında tanımlanan Partner API Anahtarı ile Bearer Token kimlik doğrulaması yapılır:

```http
Authorization: Bearer zp_partner_...
Content-Type: application/json
Accept: application/json
```

---

## 2. Desteklenen WISECP Metotları ve Partner API Uç Noktaları

| WISECP Metodu | HTTP Yöntemi | Partner API Uç Noktası | Açıklama |
|---|---|---|---|
| `TestConnection` / `test` | `GET` | `/orders/:orderId/licenses` | Havuz siparişine ve token'a erişim testi |
| `CreateAccount` / `create` | `POST` | `/orders/:orderId/licenses` | Havuzdan yeni lisans tahsis etme |
| `TerminateAccount` / `terminate` | `POST` | `/orders/:orderId/licenses/:licenseId/release` | Lisansı havuza iade ederek serbest bırakma |
| `ChangeIP` / `change_ip` | `POST` | `/orders/:orderId/licenses/:licenseId/info` | Lisans IP / Host güncelleme |
| `ClientArea` / `clientArea` | Dahili | `pages/clientArea.php` | Lisans anahtarı gösterimi ve tek tık kurulum kılavuzu |
