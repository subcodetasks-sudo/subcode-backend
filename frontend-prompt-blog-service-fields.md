# Frontend prompt — Blog author/dates + Service FAQs

Use this with the frontend repo after backend deploy on `panel.subcodeco.com`.

---

## Context

Backend now returns the fields below. Frontend must **read and render them** — do not invent fallbacks that hide missing structured data, except empty `faqs: []` which should hide the FAQ block.

Language still comes from `Accept-Language: ar | en | tr`.

---

## 1) Blog article page — `GET /api/blog/{slug}` → `data.blog`

### New / fixed fields

```ts
author: { name: string }        // never empty for published posts
published_at: string            // ISO 8601 UTC — use for visible date + JSON-LD datePublished
updated_at: string              // ISO 8601 UTC — use for "updated" UI + JSON-LD dateModified
created_at: string              // keep if needed for admin/debug; not the public publish date
time_publish?: string | null    // legacy; prefer published_at
```

### Required UI / SEO wiring

1. **Byline:** show `blog.author.name` (e.g. “SubCode” / admin name). Stop treating `author` as `{}`.
2. **Dates on page:**
   - Primary date = `published_at`
   - If `updated_at` is after `published_at`, show an “Updated …” line (optional but preferred).
3. **JSON-LD `Article`:**
   - `author` → `{ "@type": "Person" | "Organization", "name": blog.author.name }`
   - `datePublished` → `published_at`
   - `dateModified` → `updated_at`
4. Do **not** use `created_at` as the public publish date when `published_at` exists.

### Lists (same Blog shape)

Also present on each item in:

- `GET /api/all-blog`
- `GET /api/category-with-blogs` → `blogs[]`

Use `updated_at` as sitemap **`lastmod`** for blog URLs (not response generation time).

---

## 2) Service detail — `GET /api/services/{slug}`

### New field

```ts
faqs: Array<{ question: string; answer: string }>  // always an array; may be []
```

- Plain text, already localized for `Accept-Language`.
- No HTML.
- Order = display order.

### Required UI / SEO wiring

1. If `faqs.length === 0` → **hide** the FAQ section entirely (no empty accordion, no FAQ JSON-LD).
2. If `faqs.length > 0` → render Q&A in that order.
3. Add **FAQPage** JSON-LD from the same `faqs` array when non-empty.
4. List endpoint `GET /api/services` does **not** include `faqs` — only the detail page needs this.

### Admin note

FAQs are edited per service in Filament (Services → FAQs repeater, per locale). If a service has no FAQs yet, frontend correctly shows nothing until content is added in the panel.

---

## Acceptance checklist (frontend)

- [ ] Article page shows author name from API
- [ ] Article page uses `published_at` / `updated_at` in UI + Article schema
- [ ] Blog sitemap `lastmod` uses `updated_at` from list/detail API
- [ ] Service detail shows FAQ block only when `faqs.length > 0`
- [ ] FAQPage schema emitted only when FAQs exist
- [ ] No hardcoded FAQ copy on service pages (About-page static FAQs stay separate)

---

## Out of scope

- No change to About-page static FAQs
- No change to `/api/fqs` global FAQ resource
- Backend already shipped; this prompt is frontend-only consumption
