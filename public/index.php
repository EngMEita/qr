<?php
$appTitle = 'مولد أكواد QR شامل مع شعار | QR Generator with Logo';
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $appTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet" integrity="sha384-GMZsXtJXlmxQn6Bs2t5ymXQZ0Fj53n2J2HXSBm1qSjYnoknQsZR2FVnGe1vzBIfp" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="app-body">
<header class="app-hero text-white py-4 py-lg-5 mb-4 mb-lg-5">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <p class="text-uppercase small mb-2 opacity-75">مدعوم بالمتصفح · Browser-based</p>
                <h1 class="fw-bold mb-3"><?= $appTitle ?></h1>
                <p class="lead mb-0">توليد أكواد QR احترافية لكل ما تحتاجه: روابط، اتصالات هاتفية، رسائل قصيرة وواتس أب، بريد إلكتروني، الموقع الحالي، بطاقات اتصال متوافقة مع أندرويد و iOS و ويندوز، مع إمكانية إضافة شعار في المنتصف وتحميل الكود. | Generate professional QR codes for links, calls, SMS, WhatsApp, email, geo location, and vCard, with a centered logo and easy downloads.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="badge rounded-pill px-3 py-2 shadow-sm text-wrap">
                    تصميم بسيط بواجهات Bootstrap 5 · Clean Bootstrap 5 UI
                </div>
            </div>
        </div>
    </div>
</header>

<main class="container pb-5 pt-2 pt-lg-3 app-main">
    <div class="row g-4 g-lg-5">
        <section class="col-lg-7 app-panel">
            <div class="card app-card">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h2 class="h5 mb-1">أدخل بيانات الكود</h2>
                            <p class="text-muted small mb-0">اختر النوع ثم املأ الحقول المطلوبة. يدعم التطبيق جميع الاحتمالات الشائعة.</p>
                        </div>
                        <span class="badge text-bg-primary rounded-pill">يدعم الشعار</span>
                    </div>

                    <form id="qrForm" class="row g-3 g-lg-4 needs-validation" novalidate>
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="type">نوع المحتوى</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="url" selected>رابط أو فتح صفحة ويب | URL</option>
                                <option value="text">نص حر | Plain text</option>
                                <option value="phone">إجراء اتصال هاتفي | Phone call</option>
                                <option value="sms">إرسال رسالة نصية SMS | SMS</option>
                                <option value="whatsapp">إرسال رسالة واتس أب | WhatsApp</option>
                                <option value="email">إرسال بريد إلكتروني | Email</option>
                                <option value="location">مشاركة الموقع الحالي | Location</option>
                                <option value="contact">تكوين جهة اتصال (vCard)</option>
                            </select>
                        </div>

                        <div class="col-12 data-group" data-group="url text">
                            <label class="form-label" for="data">رابط الموقع | Website URL</label>
                            <input type="text" class="form-control" id="data" name="data" placeholder="https://example.com" required data-required="true">
                        </div>

                        <div class="col-md-6 data-group d-none" data-group="phone sms whatsapp">
                            <label class="form-label" for="phone">رقم الهاتف | Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="+201234567890" data-required="true">
                        </div>
                        <div class="col-md-6 data-group d-none" data-group="sms">
                            <label class="form-label" for="smsBody">نص الرسالة (SMS) | Message</label>
                            <input type="text" class="form-control" id="smsBody" name="smsBody" placeholder="محتوى الرسالة">
                        </div>
                        <div class="col-md-6 data-group d-none" data-group="whatsapp">
                            <label class="form-label" for="waMessage">نص رسالة واتس أب | WhatsApp text</label>
                            <input type="text" class="form-control" id="waMessage" name="waMessage" placeholder="الرسالة أو الدعوة">
                        </div>

                        <div class="col-md-6 data-group d-none" data-group="email">
                            <label class="form-label" for="emailAddress">عنوان البريد | Email</label>
                            <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="name@example.com" data-required="true">
                        </div>
                        <div class="col-md-6 data-group d-none" data-group="email">
                            <label class="form-label" for="emailSubject">عنوان الرسالة | Subject</label>
                            <input type="text" class="form-control" id="emailSubject" name="emailSubject" placeholder="موضوع قصير">
                        </div>
                        <div class="col-12 data-group d-none" data-group="email">
                            <label class="form-label" for="emailBody">نص البريد | Body</label>
                            <textarea class="form-control" id="emailBody" name="emailBody" rows="2" placeholder="نص الرسالة"></textarea>
                        </div>

                        <div class="col-md-6 data-group d-none" data-group="location">
                            <label class="form-label" for="latitude">خط العرض | Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="مثال: 30.12345" data-required="true">
                        </div>
                        <div class="col-md-6 data-group d-none" data-group="location">
                            <label class="form-label" for="longitude">خط الطول | Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" placeholder="مثال: 31.12345" data-required="true">
                        </div>
                        <div class="col-12 data-group d-none" data-group="location">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="detectLocation">استخدام موقعي الحالي | Use my location</button>
                            <small class="text-muted ms-2">يستخدم المتصفح لتحديد الإحداثيات بدقة · Browser geolocation.</small>
                        </div>

                        <div class="col-md-6 data-group d-none" data-group="contact">
                            <label class="form-label" for="fullName">الاسم الكامل | Full name</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" placeholder="الاسم كما سيظهر في جهات الاتصال" data-required="true">
                        </div>
                        <div class="col-md-6 data-group d-none" data-group="contact">
                            <label class="form-label" for="contactPhone">هاتف التواصل | Contact phone</label>
                            <input type="tel" class="form-control" id="contactPhone" name="contactPhone" placeholder="+201234567890">
                        </div>
                        <div class="col-md-6 data-group d-none" data-group="contact">
                            <label class="form-label" for="contactEmail">البريد الإلكتروني | Contact email</label>
                            <input type="email" class="form-control" id="contactEmail" name="contactEmail" placeholder="contact@example.com">
                        </div>
                        <div class="col-md-6 data-group d-none" data-group="contact">
                            <label class="form-label" for="org">الشركة أو المنظمة | Organization</label>
                            <input type="text" class="form-control" id="org" name="org" placeholder="المؤسسة">
                        </div>
                        <div class="col-md-6 data-group d-none" data-group="contact">
                            <label class="form-label" for="title">المسمى الوظيفي | Job title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="الوظيفة">
                        </div>
                        <div class="col-md-6 data-group d-none" data-group="contact">
                            <label class="form-label" for="website">موقع إلكتروني | Website</label>
                            <input type="text" class="form-control" id="website" name="website" placeholder="https://example.com">
                        </div>
                        <div class="col-12 data-group d-none" data-group="contact">
                            <label class="form-label" for="address">العنوان | Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="العنوان الكامل">
                        </div>
                        <div class="col-12 data-group d-none" data-group="contact">
                            <label class="form-label" for="note">ملاحظات | Notes</label>
                            <textarea class="form-control" id="note" name="note" rows="2" placeholder="معلومات إضافية"></textarea>
                        </div>

                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="size">المقاس (بالبكسل) | Size (px)</label>
                                    <input type="range" class="form-range" min="180" max="640" step="20" id="size" name="size" value="320">
                                    <div class="d-flex justify-content-between text-muted small">
                                        <span>180</span>
                                        <span id="sizeValue">320px</span>
                                        <span>640</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="ecc">مستوى التصحيح | Error correction</label>
                                    <select class="form-select" id="ecc" name="ecc">
                                        <option value="L">منخفض (L) | Low</option>
                                        <option value="M" selected>متوسط (M) | Medium</option>
                                        <option value="Q">مرتفع (Q) | Quartile</option>
                                        <option value="H">عالي (H) | High</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="color">لون النقاط | Dots color</label>
                                    <input type="color" class="form-control form-control-color w-100" id="color" name="color" value="#0d6efd" title="اختر اللون">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="bgColor">لون الخلفية | Background</label>
                                    <input type="color" class="form-control form-control-color w-100" id="bgColor" name="bgColor" value="#ffffff" title="اختر الخلفية">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="margin">الحافة الصامتة | Quiet zone</label>
                                    <input type="range" class="form-range" min="0" max="24" step="2" id="margin" name="margin" value="12">
                                    <div class="d-flex justify-content-between text-muted small">
                                        <span>0</span>
                                        <span id="marginValue">12px</span>
                                        <span>24</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="dotsType">شكل النقاط | Dots style</label>
                                    <select class="form-select" id="dotsType" name="dotsType">
                                        <option value="rounded" selected>دائري | Rounded</option>
                                        <option value="square">مربع | Square</option>
                                        <option value="dots">نقطي | Dots</option>
                                        <option value="classy">Classy</option>
                                        <option value="classy-rounded">Classy Rounded</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="cornerSquare">إطار الزوايا | Corner squares</label>
                                    <select class="form-select" id="cornerSquare" name="cornerSquare">
                                        <option value="extra-rounded" selected>مستدير جدًا | Extra rounded</option>
                                        <option value="square">مربع | Square</option>
                                        <option value="dot">نقطي | Dot</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="cornerDot">نقطة الزاوية | Corner dot</label>
                                    <select class="form-select" id="cornerDot" name="cornerDot">
                                        <option value="dot" selected>نقطة | Dot</option>
                                        <option value="square">مربع | Square</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="border rounded-3 p-3 p-lg-4 bg-light-subtle app-subcard">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                    <div>
                                        <div class="fw-semibold mb-1">الشعار في المنتصف | Center logo</div>
                                        <p class="text-muted small mb-0">حمّل شعارك (PNG أو SVG فقط) أو استخدم الشعار الافتراضي، مع الحفاظ على جودة الكود. | Upload PNG or SVG logo, or keep the default.</p>
                                    </div>
                                    <div class="d-flex gap-2 align-items-center flex-wrap justify-content-end">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="resetLogo">إعادة الشعار الافتراضي</button>
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" role="switch" id="enableLogo" checked>
                                            <label class="form-check-label small" for="enableLogo">تفعيل الشعار | Enable logo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <input class="form-control" type="file" id="logoInput" accept=".png,.svg,image/png,image/svg+xml">
                                        <small class="text-muted">PNG أو SVG فقط · مربع أو دائري يوصى به.</small>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        <span class="badge text-bg-light text-wrap" id="logoStatus">يستخدم الشعار الافتراضي</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex flex-wrap gap-2 mt-2">
                            <button class="btn btn-primary" type="submit">توليد الكود | Generate</button>
                            <button class="btn btn-outline-secondary" type="button" id="copyPayload">نسخ البيانات | Copy payload</button>
                            <button class="btn btn-outline-danger" type="reset">تفريغ الحقول | Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="col-lg-5 app-panel">
            <div class="card app-card">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <div>
                            <h2 class="h5 mb-1">المعاينة والتحميل | Preview & download</h2>
                            <p class="text-muted small mb-0">حافظ على مستوى تصحيح مرتفع عند إضافة شعار لضمان القابلية للقراءة. | Use higher error correction when adding a logo.</p>
                        </div>
                        <span class="badge text-bg-success">مباشر</span>
                    </div>
                    <div class="qr-wrapper p-3 p-lg-4 text-center position-relative overflow-hidden" id="qrWrapper">
                        <div id="qrCanvas" class="mx-auto"></div>
                        <div class="placeholder-text text-muted" id="placeholderText">سيتم إنشاء الكود هنا | The QR will appear here</div>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button class="btn btn-outline-primary" id="downloadPng" type="button">تحميل PNG (افتراضي) | Download PNG</button>
                        <button class="btn btn-outline-primary" id="downloadSvg" type="button">تحميل SVG | Download SVG</button>
                    </div>
                    <div class="alert alert-info mt-4 mb-0 small">
                        <div class="fw-semibold">تلميحات سريعة | Tips:</div>
                        <ul class="mb-0 ps-3">
                            <li>لإجراء اتصال هاتفي استخدم نوع "إجراء اتصال هاتفي" مع رقم دولي. | Use international format for phone calls.</li>
                            <li>لرسالة واتس أب يتم تكوين رابط wa.me تلقائياً. | wa.me link is built automatically.</li>
                            <li>بطاقة الاتصال vCard متوافقة مع أندرويد و iOS و ويندوز. | vCard works on Android, iOS, and Windows.</li>
                            <li>فعّل خيار الموقع لاستخدام الإحداثيات الحالية بسرعة. | Use geo button to fill current coordinates.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/qr-code-styling@1.6.0/lib/qr-code-styling.js"></script>
<script src="assets/app.js"></script>
</body>
</html>
