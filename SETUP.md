# Creator Academy — WordPress Theme Setup Guide

## 1. WordPress Installation

Install WordPress in `D:\Krubi\WebV1` (or your server root).  
Recommended: use [Local by Flywheel](https://localwp.com/) for local dev.

## 2. Activate the Theme

1. Copy `wp-content/themes/creator-academy/` to your WordPress install.
2. Go to **Appearance → Themes** → Activate **Creator Academy**.

## 3. Create Pages

Go to **Pages → Add New** and create these pages:

| Page Title | Template (Page Attributes) | Slug |
|---|---|---|
| Home | Default | `home` |
| Freebies | Default | `freebies` (auto = CPT archive) |
| Shop | Default | `shop` (auto = CPT archive) |
| Blog | Default | `blog` |
| About | About | `about` |
| Contact | Contact | `contact` |

4. Go to **Settings → Reading** → set "Your homepage displays" to **A static page** → Homepage = `Home`, Posts page = `Blog`.

## 4. Set Up Navigation Menu

1. **Appearance → Menus** → Create a menu called "Primary"
2. Add: Home, Freebies, Shop, Blog, About, Contact
3. Assign to **Primary Menu** location

## 5. Customize the Homepage (Hero)

**Appearance → Customize → Hero Section → Hero Content**

Fill in:
- Tagline, Headlines (3 lines), Subtext
- CTA button texts and URLs
- Social proof text
- Upload Hero Image
- Stat values

## 6. Add Freebies

**Freebies → Add New**

Fill in:
- Title, content (Gutenberg editor)
- Featured Image
- Excerpt (shown as card description)
- **Freebie Details** meta box:
  - Download URL (Google Drive, Dropbox, etc.)
  - File Type
  - Badge (e.g. "FREE", "NEW")
- **Featured on Homepage** → check "Show on homepage"

## 7. Add Shop Products

**Shop → Add New**

Fill in:
- Title, content, Featured Image, Excerpt
- **Product Details** meta box:
  - Price (฿)
  - Original Price (฿) — for showing discount
  - Buy / Checkout URL (Gumroad, Payhip, etc.)
  - Product Type
  - Star Rating & Review Count
  - Badge (e.g. "BEST SELLER")
- **Featured on Homepage** → check if you want it on homepage

## 8. Add Blog Posts

Standard WordPress posts — works out of the box.

## 9. Newsletter Integration

- If using **Mailchimp / ConvertKit**: install their plugin and paste the form shortcode in  
  **Appearance → Customize → Newsletter Section → Contact Form 7 Shortcode**
- Or use **Contact Form 7** plugin — the built-in form handler in `functions.php` works without plugins.

## 10. Recommended Plugins

| Plugin | Purpose |
|---|---|
| Yoast SEO | SEO optimization |
| WP Super Cache | Caching |
| Smush | Image optimization |
| Contact Form 7 | Contact forms |
| UpdraftPlus | Backups |

## 11. Taxonomy Categories

Create categories for Freebies and Products:
- **Freebies → Freebie Categories**: Prompt, Template, Guide, E-book
- **Shop → Product Categories**: Coloring Book, Planner, Worksheet, Canva Template, KDP Books, etc.

These appear as filter buttons on the archive pages automatically.

## 12. Social Links

**Appearance → Customize → Site Tagline / Footer**  
Enter Facebook, Instagram, YouTube, TikTok URLs.

---

## File Structure

```
wp-content/themes/creator-academy/
├── style.css                    ← Theme declaration
├── functions.php                ← CPTs, meta boxes, customizer
├── front-page.php               ← Homepage
├── header.php                   ← Site header & nav
├── footer.php                   ← Footer + newsletter CTA
├── index.php                    ← Blog / archive fallback
├── single.php                   ← Blog post
├── archive.php                  ← Generic archive
├── single-freebie.php           ← Single freebie
├── single-digital_product.php  ← Single product
├── archive-freebie.php          ← Freebies listing
├── archive-digital_product.php ← Shop listing
├── page-about.php               ← About page template
├── page-contact.php             ← Contact page template
├── page.php                     ← Generic page
├── 404.php                      ← 404 page
├── template-parts/
│   ├── freebie-card.php         ← Freebie card component
│   ├── product-card.php         ← Product card component
│   └── post-card.php            ← Blog post card component
└── assets/
    ├── css/main.css             ← All styles
    └── js/main.js               ← Interactions
```
