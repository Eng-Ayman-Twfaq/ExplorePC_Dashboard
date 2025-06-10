<p align="center">
  <a href="https://github.com/Eng-Ayman-Twfaq/ExplorePC_Dashboard.git" target="_blank">
    <img src="images/Explore.jpg" width="400" alt="ExplorePC Logo">
  </a>
  
  <p align="center">
    <a href="https://github.com/770883616/ExplorePC-Dashboard/actions">
      <img src="https://img.shields.io/github/workflow/status/770883616/ExplorePC-Dashboard/CI/CD?label=Build&style=flat-square" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/explorepc/admin">
      <img src="https://img.shields.io/packagist/v/explorepc/admin?color=blue&style=flat-square" alt="Version">
    </a>
    <a href="https://opensource.org/licenses/MIT">
      <img src="https://img.shields.io/badge/License-MIT-green.svg?style=flat-square" alt="License">
    </a>
  </p>
</p>

## 🌟 نظام إدارة ExplorePC

لوحة تحكم متكاملة لإدارة منصتي:
- 🛍️ **تطبيق العملاء** (واجهة شراء المنتجات)
- 🏪 **تطبيق التاجر** (إدارة المخزون والطلبات)
- ☁️ **الخدمات السحابية** (Firebase, MySQL)

---

## 🚀 الميزات الرئيسية

<div align="center">

| الواجهة | الميزات | 
|---------|---------|
| ![Dashboard](images/Home.png) | **لوحة التحكم الرئيسية**<br>- إحصاءات المبيعات الحية<br>- رسوم بيانية تفاعلية<br>- نظرة عامة على الأداء |
| ![Orders](images/order.png) | **إدارة الطلبات**<br>- تتبع حالات الطلبات<br>- فلترة متقدمة<br>- تحديث الحالة مباشرة |

</div>

---

## 📱 تطبيقات النظام

<div align="center">

| إدارة العملاء | إدارة التاجر |
|--------------|-------------|
| ![Customer App](images/user.png) | ![Merchant App](images/m.png) |
| تصفح المنتجات<br>إتمام عمليات الشراء<br>تتبع الطلبات | إدارة المخزون<br>معالجة الطلبات<br>تحليل الإحصائيات |

</div>

---

## 💻 التقنية المستخدمة

### 📱 Flutter Frontend
yaml
dependencies:
  flutter_bloc: ^8.1.3       # لإدارة الحالة
  firebase_core: ^2.18.0      # لربط Firebase
  cloud_firestore: ^4.9.0     # لقاعدة البيانات
  syncfusion_flutter_charts: ^23.1.40  # للرسوم البيانية
🖥️ Laravel Backend
json
"require": {
  "laravel/framework": "^10.0",
  "guzzlehttp/guzzle": "^7.0"  # للاتصال بالخدمات الخارجية
}
🛠️ تنصيب المشروع
1. استنساخ المستودع
bash
git clone https://github.com/Eng-Ayman-Twfaq/ExplorePC_Dashboard.git
cd ExplorePC-Dashboard
2. تنصيب Flutter
bash
flutter pub get
flutter run
3. تنصيب Laravel
bash
composer install
cp .env.example .env
php artisan key:generate
📞 الدعم والاتصال
<div align="center">
📧 البريد الإلكتروني: ayman.tawfaq.developers@gmail.com
📱 الواتساب: +967 770 883 615

https://img.shields.io/badge/GitHub-Profile-green?style=flat&logo=github

</div>
<div align="center"> <sub>تم التطوير بواسطة <a href="https://github.com/Eng-Ayman-Twfaq" style="color: #4CAF50;">أيمن توفيق</a> © 2025</sub> </div> 
✨ الميزات الإضافية:
أيقونات مرئية لكل قسم (📌، 💻، 🛠️، إلخ).

تنسيق الكود المميز بلون مختلف.

روابط نشطة للبريد الإلكتروني وجيت هاب.

تقسيم واضح باستخدام ---.

صور مدمجة مع حواف مستديرة.

درع (badge) لصفحة GitHub.