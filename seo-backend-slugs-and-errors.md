# إصلاحات Backend — Slugs / 500 / Sitemap — subcodeco.com

**تاريخ:** 5 أكتوبر 2026  
**إلى:** فريق الـ Backend (`panel.subcodeco.com`)  
**من:** Frontend / SEO  
**الأولوية:** عالية — تؤثر مباشرة على Search Console (`noindex` + 5xx متقطعة)

---

## المشكلة باختصار

1. صفحات سليمة على الموقع ترجع أحيانًا فاضية + `noindex` بحالة HTTP 200 (مثال: `/works/refada` تحت الضغط، `/works/nesem` دائمًا).
2. الـ sitemap والـ hreflang يستخدمون **نفس الـ slug** للغات الثلاث → ~28% من روابط الـ sitemap ترجع `noindex`.
3. السبب الجذري من الـ API: استجابات `500` عند فشل الترجمة/الـ slug، و`/all-slugs` لا يُرجع slug حقيقي لكل لغة.

الفرونت حاليًا ينادي `notFound()` لما الـ API لا يرجع `200` — لذلك أي `500` من الباك يظهر كصفحة فاضية + `noindex` بدل خطأ سيرفر واضح. إصلاح الباك أدناه يمنع المصدر؛ إصلاح تمييز 404/500 على الفرونت منفصل.

---

## 1) `GET /all-slugs` — نفس الـ slug لكل اللغات (حرج)

### الوضع الحالي (مُتحقَّق 2026-10-05)

| Endpoint | النتيجة |
|---|---|
| `GET /api/all-slugs/ar` | 200 |
| `GET /api/all-slugs/en` | 200 — **نفس قائمة `ar` حرفيًا** |
| `GET /api/all-slugs/tr` | 200 — **نفس قائمة `ar` حرفيًا** |
| `GET /api/all-slugs?all_locales=1` | 200 — لكل عنصر: `slug.ar === slug.en === slug.tr` |

أعداد متطابقة: blogs=17، projects=22، services=4 — ولا فرق بين اللغات.

### المطلوب

#### أ) `GET /api/all-slugs/{locale}` و `GET /api/all-slugs?locale={locale}`

ارجع **فقط** الـ slugs الخاصة بتلك اللغة (القيمة المخزَّنة في ترجمة `locale`):

```json
{
  "status": true,
  "data": {
    "blogs": ["نظام-crm-عقاري-…", "تكلفة-برمجة-تطبيق-جوال-…"],
    "projects": ["refada", "nesem"],
    "services": ["خدمات-البرمجة-…"],
    "products": []
  }
}
```

- لا تُرجع slug إنجليزي داخل قائمة `ar`.
- لا تُرجع slug عربي داخل قائمة `en` إلا إذا كانت الترجمة الإنجليزية تستخدمه فعلًا.

#### ب) `GET /api/all-slugs?all_locales=1`

مصدر الحقيقة للـ sitemap / hreflang:

```json
{
  "status": true,
  "data": {
    "blogs": [
      {
        "id": 123,
        "slug": {
          "ar": "نظام-crm-عقاري-دليلك-الشامل-لإدارة-العملاء-وزيادة-مبيعات-شركتك-العقارية",
          "en": "real-estate-crm-system-the-complete-guide-to-managing-leads-and-growing-your-property-business",
          "tr": "…"
        }
      }
    ],
    "projects": [
      {
        "id": 8,
        "slug": { "ar": "refada", "en": "refada", "tr": "refada" }
      }
    ],
    "services": [],
    "products": []
  }
}
```

قواعد:
- `slug.ar` / `slug.en` / `slug.tr` يجب أن تكون القيم **الفعلية** لكل ترجمة.
- لو لغة ليس لها slug صالح: **احذف المفتاح** أو أرسل `null` — لا تنسخ slug لغة أخرى.
- نفس `id` يربط النسخ الثلاث (مهم للـ hreflang).

### مثال CRM (دليل التحقق)

| مصدر | slug |
|---|---|
| `GET /api/category-with-blogs` + `Accept-Language: ar` | `نظام-crm-عقاري-دليلك-الشامل-لإدارة-العملاء-وزيادة-مبيعات-شركتك-العقارية` ✅ |
| `GET /api/category-with-blogs` + `Accept-Language: en` | `real-estate-crm-system-the-complete-guide-to-managing-leads-and-growing-your-property-business` ✅ |
| `GET /api/all-slugs?all_locales=1` حاليًا | الإنجليزي مكرر على `ar` و`en` و`tr` ❌ |

الـ slug العربي **موجود ويحلّ بـ 200**. المشكلة أن `all-slugs` لا يُظهره للعربية ويسجّل الرابط الإنجليزي مكانه في الـ sitemap.

---

## 2) تفصيل الصفحات يرجع `500` بدل محتوى أو `404` (حرج)

### قاعدة الحالات المطلوبة

| الحالة | HTTP | Body |
|---|---|---|
| السجل غير موجود | **404** | رسالة واضحة |
| السجل موجود، الترجمة ناقصة/مكسورة | **200** بمحتوى fallback، أو **404** لو اللغة غير منشورة — **ممنوع 500** | — |
| خطأ سيرفر حقيقي فقط | **500** | — |

### أعطال مُتحقَّقة

#### أ) مشروع `nesem`

| طلب | النتيجة |
|---|---|
| `GET /api/projects/nesem` + `Accept-Language: ar` | **500** `{"message":"Server Error"}` — دائمًا |
| `GET /api/projects/nesem` + `Accept-Language: en` | **200** — يعمل |

← هذا يفسّر أن `/works/nesem` على العربية فاضي دائمًا.

#### ب) مقالات بـ slug إنجليزي + لغة `ar` / `tr`

| slug | `ar` | `en` | `tr` |
|---|---|---|---|
| `real-estate-crm-system-the-complete-guide-to-managing-leads-and-growing-your-property-business` | **500** | 200 | **500** |
| `mobile-app-development-cost-in-saudi-arabia-2026-how-is-the-cost-determined` | **500** | 200 | **500** |
| `real-estate-platform-programming-the-complete-subcode-guide-2026` | **500** | 200 | **500** |

نفس المقالات بالـ slug العربي الصحيح ترجع **200** مع `Accept-Language: ar`:

| slug العربي | `ar` |
|---|---|
| `نظام-crm-عقاري-دليلك-الشامل-لإدارة-العملاء-وزيادة-مبيعات-شركتك-العقارية` | 200 |
| `تكلفة-برمجة-تطبيق-جوال-في-السعودية-2026-كيف-يتم-تحديد-تكلفة-التطبيق` | 200 |
| `برمجة-منصة-عقارية-احترافية-دليل-subcode-الشامل-2026` | 200 |

### المطلوب على endpoints التفصيل

`GET /api/projects/{slug}` · `GET /api/blog/{slug}` · `GET /api/services/{slug}` · `GET /api/websites/{slug}`

1. أصلِحوا الـ exception الذي يكسر ترجمة `ar`/`tr` (خصوصًا `nesem` والمقالات أعلاه) — راجعوا Laravel log عند طلب `Accept-Language: ar`.
2. ابحثوا عن السجل بـ slug **أي** لغة، ثم رجّعوا الحقول حسب `Accept-Language`.
3. لا ترموا `500` لنقص حقل ترجمة أو علاقة null — استخدموا null-safe / fallback.
4. `404` فقط إذا لم يوجد السجل نهائيًا.

---

## 3) بيانات slug متسخة / ترجمات ناقصة

### أ) مسافة في أول الـ slug (مقال العقود)

من `category-with-blogs` + `en`:

```
" contract-documentation-and-real-estate-brokerage"
```

(لاحظ المسافة في البداية)

| طلب | النتيجة |
|---|---|
| slug **مع** المسافة + `en` | 200 |
| slug **بدون** مسافة + `en` | **500** |
| slug العربي `توثيق-العقود-والوساطة-العقارية` + `ar` | 200 |

**المطلوب:** `trim()` على كل slugs عند الحفظ والاستجابة؛ أصلِحوا القيمة في DB؛ تأكدوا أن البحث يعمل بالشكل المنظف.

### ب) قائمة الإنجليزية ترجع مقالات عربية

أول 4 عناصر في `GET /api/category-with-blogs` + `Accept-Language: en` ما زالت بـ slug وعنوان عربي (الترجمة الإنجليزية غير مكتملة أو غير مربوطة).

**المطلوب:** لكل blog/project/service أكملوا ترجمات `ar` / `en` / `tr` (على الأقل `slug` + `title`)، واربطوها بنفس `id`.

---

## 4) استقرار تحت الضغط + Cache

- `GET /api/projects/refada` نجح 20/20 من جهة الـ API في اختبار متزامن واحد، لكن على الموقع تظهر صفحات فاضية متقطعة تحت الضغط → أي `timeout` / `5xx` عابر من الباك يتحول عند الفرونت إلى صفحة `noindex`.
- **المطلوب:**
  - Cache لاستجابات `GET` العامة: `/projects/{slug}`، `/blog/{slug}`، `/all-slugs*`, `/category-with-blogs` (TTL مناسب، مثل 5–60 دقيقة).
  - تقليل استثناءات N+1 / علاقات ثقيلة على صفحة المشروع الواحد.
  - لا تُرجعوا `500` عابرة بسبب race أو lock على الترجمة.

---

## 5) Acceptance checklist (قبل إغلاق التذكرة)

- [ ] `GET /all-slugs/ar` ≠ `GET /all-slugs/en` حيث تختلف الـ slugs فعليًا (مثال CRM أعلاه).
- [ ] `GET /all-slugs?all_locales=1` → لمقال CRM: `slug.ar` عربي و`slug.en` إنجليزي ومختلفان.
- [ ] `GET /projects/nesem` + `Accept-Language: ar` → **200** (أو 404 منطقي) — **ليس 500**.
- [ ] `GET /blog/{english-crm-slug}` + `Accept-Language: ar` → ليس 500 (resolve أو 404).
- [ ] `GET /blog/{arabic-crm-slug}` + `Accept-Language: ar` → 200.
- [ ] لا يوجد leading/trailing whitespace في أي slug في DB أو الاستجابة.
- [ ] مقال العقود بالإنجليزي يعمل بدون مسافة في الـ slug.
- [ ] صفر `Server Error` على طلبات detail بـ slug صحيح + `Accept-Language` مطابق للغة الـ slug.

---

## ملخص تنفيذي لفريق الباك

| # | المهمة | نوعها |
|---|---|---|
| 1 | إصلاح `/all-slugs` و`all_locales=1` لإرجاع slug حقيقي لكل لغة | API contract + query |
| 2 | إصلاح `500` على `projects/nesem?lang=ar` والمقالات الإنجليزية مع `ar`/`tr` | Bugfix |
| 3 | Lookup بالـ slug من أي لغة + استجابة حسب `Accept-Language` | Behavior |
| 4 | `404` للمفقود، `500` لخطأ سيرفر فقط | HTTP semantics |
| 5 | تنظيف slugs (trim) وإكمال الترجمات الناقصة | Data |
| 6 | Cache على endpoints القراءة العامة | Performance |

**لا حاجة لتغيير شكل `meta` أو seeding العناوين هنا** — ذلك ملف منفصل: `docs/seo-backend-seed.md`.
