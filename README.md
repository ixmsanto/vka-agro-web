# VKA Agro Exports

Marketing site + content-managed admin for VKA Agro, a Pollachi coco-peat
exporter. Built on **Laravel 13** with **SQLite**, rendered with **Blade** —
**no Node build step**, so it deploys to plain shared hosting over FTP.

- **Public site** (`/`) — hero, facility video, products, gallery, testimonials,
  blog, contact form. One request, server-rendered, progressively enhanced.
- **Admin** (`/admin`) — sign in to edit every section. Text autosaves as you
  type; images upload by drag-and-drop. Contact-form submissions are stored and
  listed under *Inquiries*.

---

## Requirements

- PHP **8.3+** with `pdo_sqlite`, `mbstring`, `fileinfo`, `gd` (or `imagick`)
- Composer
- A web server whose document root is the `public/` directory (locally) or
  `public_html` (on the host — see Deployment)

No database server is needed; content lives in a single SQLite file.

## Local development

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

Open http://127.0.0.1:8000. The seeder loads the default content and one admin:

| Username | Password  |
| -------- | --------- |
| `admin`  | `vka@2026` |

**Change the password before going live** (see below). Using [Laravel Herd]?
The site is served automatically at `http://vka-agro-web.test`.

### Tests

```bash
php artisan test
```

Feature tests cover the public page, the contact form (validation + honeypot),
authentication, autosave field-whitelisting, reordering, and image uploads.

---

## How the content model works

| Area | Storage | Edited under |
| ---- | ------- | ------------ |
| Hero, facility video copy, contact details | `settings` (key/value JSON) | Hero / Facility video / Contact details |
| Products + spec sheets | `products`, `product_specs` | Products |
| Blog posts | `posts` | Blog & insights |
| Gallery tiles (with bento spans) | `gallery_items` | Gallery |
| Testimonials | `testimonials` | Testimonials |
| Logo, hero slides, about photo, video + poster, map | `media` (named slots) | Images & video |
| Contact-form submissions | `inquiries` | Inquiries |

Uploaded files are written to `public/uploads/` and served directly — there is
**no `storage:link` symlink**, which shared hosting and FTP often break.

Images left empty fall back to a labelled placeholder on the site, so the page
always renders even before any media is uploaded.

---

## Deployment — GoViralHost (shared hosting, FTP)

The domain's document root is a fixed `public_html`, so the app is split in two
sibling folders in your account's home directory:

```
~/vka-app/        the Laravel application (NOT web-reachable)
~/public_html/    document root: css/ js/ uploads/ + index.php + .htaccess
```

`public_html/index.php` boots the app from `../vka-app`. That patched front
controller and a hardened `.htaccess` live in [`hosting/public_html/`](hosting/public_html/)
and are copied into place automatically by the deploy workflow.

### 1. One-time server setup

Do this once, using cPanel File Manager or an FTP client:

1. **Create the two folders** `vka-app` and (if missing) `public_html` in your
   home directory.
2. **Create `~/vka-app/.env`** — copy `.env.example` and set at least:
   ```dotenv
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=            # generate one: see step 3
   APP_URL=https://your-domain.com

   DB_CONNECTION=sqlite
   DB_DATABASE=/home/YOUR_CPANEL_USER/vka-app/database/database.sqlite

   ADMIN_USERNAME=admin
   ADMIN_EMAIL=export@vkaagro.com
   ADMIN_PASSWORD=choose-a-strong-password

   INQUIRY_NOTIFY_EMAIL=you@your-domain.com   # optional
   DEPLOY_TOKEN=paste-a-long-random-string    # see step 4
   ```
   Use an **absolute** `DB_DATABASE` path — relative paths are unreliable when
   the app runs from a different working directory.
3. **Generate an APP_KEY.** Run `php artisan key:generate --show` locally and
   paste the `base64:...` value into `APP_KEY`, or use any 32-byte base64 string.
4. **Pick a DEPLOY_TOKEN** — any long random string. It authorises the
   post-deploy migration hook. Put the same value in the GitHub secret below.
5. **Point the domain** at `public_html` if it isn't already (Addon/Primary
   domain document root in cPanel).

The empty `database.sqlite` file and `storage/` folders are created by the
first deploy; you don't need to make them by hand.

### 2. GitHub repository configuration

Add these under **Settings → Secrets and variables → Actions**.

**Secrets:**

| Name | Value |
| ---- | ----- |
| `FTP_SERVER` | your FTP host, e.g. `ftp.your-domain.com` |
| `FTP_USERNAME` | FTP / cPanel username |
| `FTP_PASSWORD` | FTP / cPanel password |
| `DEPLOY_TOKEN` | same random string as in `.env` |

**Variables** (all optional — sensible defaults shown):

| Name | Default | Notes |
| ---- | ------- | ----- |
| `APP_URL` | — | `https://your-domain.com`. Set it so migrations run automatically after deploy. |
| `APP_DIR` | `vka-app/` | Where the app is uploaded, relative to the FTP login dir. |
| `PUBLIC_DIR` | `public_html/` | The document root, relative to the FTP login dir. |
| `FTP_PROTOCOL` | `ftps` | Use `ftp` if your host has no FTPS. |
| `FTP_PORT` | `21` | |

> If your FTP account logs straight into the home directory, the defaults are
> correct. If it logs into `public_html`, set `APP_DIR` to `../vka-app/` and
> `PUBLIC_DIR` to `./`.

### 3. Deploy

Push to `main` (or run the **Deploy to GoViralHost** workflow manually). The
workflow, defined in [`.github/workflows/deploy.yml`](.github/workflows/deploy.yml):

1. installs Composer dependencies (`--no-dev`, optimized autoloader),
2. FTPs the app to `~/vka-app` and the assets + front controller to
   `~/public_html`,
3. calls `POST /__deploy` so the server runs `migrate --force`, seeds on the
   very first deploy, and warms the config/route/view caches.

The FTP step only manages files it uploads, so your **live SQLite database,
uploaded media, sessions and `.env` are never overwritten or deleted**.

If you leave `APP_URL` unset, step 3 is skipped — run migrations yourself via
cPanel Terminal / cron: `php /home/YOUR_USER/vka-app/artisan migrate --force`.

### Changing the admin password

- **Before first deploy:** set `ADMIN_PASSWORD` in the server `.env`; the first
  deploy's seed uses it.
- **Later:** from cPanel Terminal,
  ```bash
  php /home/YOUR_USER/vka-app/artisan tinker --execute="\
    \$u = App\Models\User::first(); \$u->password = 'new-password'; \$u->save();"
  ```
  (the model hashes it automatically), or re-run the seeder after updating
  `ADMIN_PASSWORD` — it updates the existing admin in place.

---

## Project layout

```
app/
  Http/Controllers/          public: Home, Inquiry, Deploy
    Admin/                   auth, dashboard, settings, collections, specs, media, inquiries
  Models/                    Setting, Medium, Product, ProductSpec, GalleryItem, Testimonial, Post, Inquiry
  Support/                   SiteContent, MediaStore, AdminResources, Assets
resources/views/
  layouts/                   site + admin shells
  site/partials/             one file per page section
  admin/                     dashboard + one editor per section
  components/                img-slot (public), admin/slot (upload widget)
public/
  css/ js/                   hand-written, no build step
  uploads/                   user-uploaded media (runtime)
hosting/public_html/         production front controller + .htaccess
database/
  migrations/  seeders/      schema + default content
```
