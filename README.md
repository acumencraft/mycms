## Agency Platform — Agent Documentation

**Version:** 2.2 | **Updated:** April 2026 | **Environment:** DDEV Local + Hostinger Production

---

## 1. პროექტის მიმოხილვა

Laravel 12 / Filament 5 პლატფორმა სამი მიზნით:

- **Marketing Website** — საჯარო საიტი სერვისებით, პორტფოლიოთი, ბლოგით.
- **Client Portal** — კლიენტის dashboard პროექტებით, მესენჯერით, ფაილებით.
- **Admin CRM** — შეკვეთების, პროექტების, კონტენტის მართვა.

**White-label:** პროექტი სრულად შაბლონურია. ყველა კომპანიის სახელი, დომენი, ფერი `config/agency.php` + `.env`-ით იმართება.

---

## 2. ტექნოლოგიური სტეკი

| კომპონენტი   | ტექნოლოგია         | ვერსია | შენიშვნა                                          |
| ------------ | ------------------ | ------ | ------------------------------------------------- |
| Backend      | Laravel            | 12.x   | PHP 8.4-ის შესაძლებლობების გამოყენება             |
| Admin Panel  | Filament           | 5.x    | Livewire 4-ის მხარდაჭერა                          |
| PHP          | PHP                | 8.4    | JIT, Property Hooks                               |
| Database     | MariaDB            | 11.8   |                                                   |
| CSS          | TailwindCSS        | —      |                                                   |
| JS           | Alpine.js          | —      |                                                   |
| Build        | Vite               | 7.x    | მოითხოვს Node.js 20.19+                           |
| Email        | Resend             | 1.x    |                                                   |
| Roles        | Spatie Permission  | 7.2    |                                                   |
| Activity Log | Spatie Activitylog | 5.x    |                                                   |
| Images       | Intervention Image | 4.x    |                                                   |
| Payment      | srmklive/paypal    | 3.x    | **განახლება საჭირო:** v3 ბოლოა Laravel 12-ისთვის. |

---

## 3. DDEV ლოკალური გარემო

```
Project: mycms
URL: https://mycms.ddev.site:33001
Admin: https://mycms.ddev.site:33001/admin
DB: MariaDB 11.8 (user: db / pass: db)
PHP: 8.4
Node.js: 20.19+ (Vite 7-ის მოთხოვნა)
```

**გაშვება:**

```bash
cd ~/DDEV/mycms
ddev start
ddev exec php artisan optimize:clear
ddev exec npm run build
```

---

## 4. მონაცემთა ბაზა

**ძირითადი ცხრილები:**

```
users                    — ავთენტიფიკაცია, roles, avatar
clients                  — ბიზნეს მონაცემები (user_id FK)
orders                   — შეკვეთები სერვისებით
projects                 — აქტიური პროექტები (order_id FK)
project_messages         — ჩატი კლიენტ-ადმინ
project_files            — ატვირთული ფაილები
portfolio_projects       — საჯარო პორტფოლიო
publications             — ბლოგის პოსტები
comments                 — კომენტარები (parent_id, reply_to_user_id)
services / features      — სერვისები და ფუნქციები
guides / guide_categories — გიდები
faq / faq_categories     — FAQ
testimonials             — მოწმობები
pages                    — CMS გვერდები
menu_items               — ნავიგაცია (header/footer/bottom)
site_settings            — key-value კონფიგურაცია
newsletter_subscribers   — newsletter
visits                   — ვიზიტების ლოგი (საჭიროებს აგრეგაციას)
activity_log             — Spatie activity log
tags                     — (ახალი) ტეგები
taggables                — (ახალი) პოლიმორფული pivot ცხრილი
```

**მნიშვნელოვანი relations:**

- `users` → `clients` (hasOne, user_id)
- `orders` → `projects` (order_id FK — Order accepted → Project შეიქმნება)
- `projects` → `portfolio_projects` (completed → auto-create, is_published: false)
- `comments` → `comments` (parent_id self-reference, reply_to_user_id)
- `tags` → `users`, `publications`, etc. (morphToMany)

---

## 5. Roles & Permissions (RBAC)

| Role            | წვდომა                                                                                   |
| --------------- | ---------------------------------------------------------------------------------------- |
| **Super Admin** | ყველაფერი                                                                                |
| **Admin**       | CRM: Clients, Orders, Projects, Messages, Activity Log                                   |
| **Editor**      | Content: Portfolio, Services, Features, Publications, Comments, Newsletter, Testimonials |
| **Support**     | Comments, Guides, GuideCategories, FAQ, Messages, Activity Log, Users (read-only)        |
| **Client**      | Frontend Client Dashboard                                                                |

**იმპლემენტაცია:** თითოეულ Filament Resource-ს აქვს `canViewAny()` მეთოდი. UserResource-ს აქვს ასევე `canCreate()`, `canEdit()`, `canDelete()`.

---

## 6. White-label კონფიგურაცია

**`config/agency.php`:**

```php
'name'           => env('AGENCY_NAME', 'Archvadze'),
'full_name'      => env('AGENCY_FULL_NAME', 'Archvadze Web Agency'),
'email'          => env('AGENCY_EMAIL', 'info@archvadze.com'),
'admin_email'    => env('ADMIN_EMAIL', 'admin@archvadze.com'),
'url'            => env('APP_URL'),
'team_signature' => env('AGENCY_TEAM_SIGNATURE'),
'seo.title_suffix' => env('AGENCY_SEO_SUFFIX'),
```

**ახალი კლიენტისთვის:** `.env`-ში შეცვალე `AGENCY_*` ცვლადები. Blade-ებში ყველგან `config('agency.*')` გამოიყენება.

---

## 7. Site Settings (DB key-value)

`/admin/settings` გვერდზე იმართება:

| Key                                          | აღწერა                                         |
| -------------------------------------------- | ---------------------------------------------- |
| `site_name`                                  | საიტის სახელი                                  |
| `site_logo`                                  | ლოგო (storage/logo/)                           |
| `site_email`                                 | კონტაქტ ემეილი                                 |
| `color_primary`                              | Primary ფერი HSL ფორმატით (მაგ: `221 83% 53%`) |
| `module_portfolio`                           | Portfolio მოდული ჩართული/გამორთული             |
| `module_portfolio_label`                     | Portfolio მენიუს სახელი                        |
| `module_portfolio_slug`                      | Portfolio URL slug (მაგ: `gallery`)            |
| `module_services`                            | Services მოდული                                |
| `module_blog`                                | Blog მოდული                                    |
| `module_guides`                              | Guides მოდული                                  |
| `module_testimonials`                        | Testimonials მოდული                            |
| `module_blog_slug_enabled`                   | Custom URL slugs ჩართული                       |
| `social_facebook/twitter/instagram/linkedin` | სოციალური ბმულები                              |
| `google_analytics`                           | GA script კოდი                                 |
| `head_scripts`                               | Head-ში scripts                                |

---

## 8. Module System

**ჩართვა/გამორთვა:** `/admin/settings` → Modules section

- Toggle → MenuItems-ში `is_active` განახლდება + route 404 middleware
- Label → MenuItem-ის label + გვერდის hero title განახლდება
- Slug → URL შეიცვლება (custom slugs enabled-ზე)

**Middleware:** `CheckModuleEnabled` — route-ზე `middleware('module:module_blog')`

---

## 9. Client Flow

```
1. Register → Email Verification
2. /order ფორმა → Order შეიქმნება (status: pending)
3. /order/success/{id} → Pay with PayPal ან Go to Dashboard
4. Admin: Order → accepted → Project ავტომატურად შეიქმნება (OrderObserver)
5. Client Dashboard → Project detail → Messages, Files, Progress
6. Admin: Project → completed → PortfolioProject ავტომატურად შეიქმნება (is_published: false)
7. Admin: Portfolio → review → is_published: true → საჯარო საიტზე გამოჩნდება
```

---

## 10. Comments System

**სტრუქტურა:**

- 2-level: Parent Comment → Replies (max 1 level)
- `parent_id` — reply-ისთვის
- `reply_to_user_id` — @mention-ისთვის (კონკრეტულ პიროვნებაზე პასუხი)

**Frontend:** Disqus სტილი — @mention badge, quote box (რომელ reply-ს გაეცა პასუხი), avatars, "წევრია X წლიდან"

**Moderation:** `is_approved` field — BlogCommentResource-ში Approve/Reject actions

**Rate limiting:** 5 კომენტარი/წუთში per user

---

## 11. Image Processing

**WebP auto-conversion:** სურათის ატვირთვისას Observer-ები ავტომატურად კონვერტირებენ WebP-ად:

- `PublicationObserver` → cover_image
- `PortfolioProjectObserver` → cover_image
- `GuideObserver` → cover_image

**Service:** `App\Services\ImageService::convertToWebP()`

---

## 12. Caching Strategy

```php
Cache::remember('home.services', 3600, ...)      // Services
Cache::remember('home.projects', 3600, ...)      // Portfolio
Cache::remember('home.publications', 1800, ...)  // Blog posts
Cache::remember('home.testimonials', 3600, ...)  // Testimonials
Cache::remember('site.settings', 3600, ...)      // Site Settings
Cache::remember('menu.items', 3600, ...)         // Menu Items
```

**Auto-invalidation:** Model Observer-ები (saved/deleted) ასუფთავებს შესაბამის cache-ს.

---

## 13. User Profile

**Users ცხრილი:** `avatar`, `tags` (JSON) - **შენიშვნა: `tags` ველი გადასაკეთებელია ცალკე ცხრილებზე (იხ. Roadmap).**

**Avatars:** `/public/avatars/avatar1.svg` ... `avatar12.svg` + `default.svg`

- კლიენტი ირჩევს 12 SVG ავატარიდან Profile-ზე

**Tags/Interests:** Checkbox სიით Profile-ზე, JSON-ად ინახება.

**Profile page:** `/client-dashboard/profile` — avatar, name, email, phone, country, company, website, social links, birthday, interests

---

## 14. Admin Panel Structure

**Navigation Groups:**

- **Operations:** Clients, Orders, Projects, Team Members, Messages, Newsletter, Activity Log
- **Content:** Portfolio, Services, Features, Publications, Comments, Guides, Guide Categories, FAQ, Testimonials
- **System:** Users, Pages, Menu Items, Site Settings

**Custom Pages:**

- `ManageSettings` — Site Settings
- `Analytics` — ვიზიტების სტატისტიკა (visits ცხრილი)

---

## 15. Production (Hostinger) - განახლებული

```
Server: Hostinger VPS
URL: https://archvadze.com
PHP: 8.4
Node.js: 20.19+
Composer: /usr/local/bin/composer
Public: public_html/ → Laravel-ის public/
Storage symlink: ხელით (PHP symlink() disabled)
```

**Deploy commands (ავტომატიზაციამდე):**

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

**რეკომენდაცია:** ამ ბრძანებების ავტომატიზაცია GitHub Actions-ის მეშვეობით (იხ. Roadmap).

---

## 16. გასაკეთებელი (Roadmap) - განახლებული

### **მაღალი პრიორიტეტი**

- [ ] **Email Queue ინტეგრაცია:**
  - **ამოცანა:** ყველა იმეილის გაგზავნა `Mail::queue()`-ს გამოყენებით, რათა გაუმჯობესდეს პერფორმანსი.
  - **ფაილები:** `OrderObserver`, `CommentObserver` და სხვა ადგილები, სადაც `Mail::send()` გამოიყენება.
  - **შედეგი:** მომენტალური პასუხი მომხმარებლისთვის, იმეილის გაგზავნის პროცესი გადავა ფონურ რეჟიმში.
- [ ] **Production Deploy ავტომატიზაცია:**
  - **ამოცანა:** GitHub Actions workflow-ს შექმნა Hostinger-ზე ავტომატური დეპლოისთვის.
  - **ნაბიჯები:**
    1. `deploy.yml` ფაილის შექმნა `.github/workflows/` დირექტორიაში.
    2. Workflow-ში SSH კავშირის დაყენება Hostinger-ის `secrets`-ების გამოყენებით.
    3. Deploy ბრძანებების (`git pull`, `composer install`, `artisan` commands, `npm run build`) გაწერა სკრიპტში.
- [ ] **ტეგების სისტემის რეფაქტორინგი:**
  - **ამოცანა:** `users.tags` JSON ველის ჩანაცვლება პოლიმორფული `tags` და `taggables` ცხრილებით.
  - **ნაბიჯები:**
    1. `create_tags_table` და `create_taggables_table` migration-ების შექმნა.
    2. `Tag` მოდელის შექმნა.
    3. `User` მოდელში `morphToMany` კავშირის დამატება.
    4. მონაცემთა მიგრაციის სკრიპტის დაწერა (`artisan command`), რომელიც `users.tags`-დან მონაცემებს ახალ ცხრილებში გადაიტანს.
    5. პროფილის რედაქტირების გვერდის (`profile/edit.blade.php`) განახლება.

### **საშუალო პრიორიტეტი**

- [ ] **ანალიტიკის Dashboard და ოპტიმიზაცია:**
  - **ამოცანა:** `visits` ცხრილის მონაცემების აგრეგაცია და Filament-ში გამოტანა.
  - **ნაბიჯები:**
    1. `daily_visits_summary` ცხრილის შექმნა.
    2. Scheduled Command-ის შექმნა, რომელიც ყოველდღიურად დააჯამებს `visits` მონაცემებს და შეინახავს ახალ ცხრილში.
    3. Filament-ის `Analytics` გვერდის გადაკეთება, რათა იმუშაოს აგრეგირებულ მონაცემებზე.
- [ ] **Invoice PDF გენერაცია:**
  - **ამოცანა:** `barryvdh/laravel-dompdf`-ის გამოყენებით ინვოისების გენერაცია.
  - **ნაბიჯები:**
    1. `InvoiceService`-ის შექმნა.
    2. ინვოისის Blade შაბლონის შექმნა.
    3. `OrderObserver`-ში ან კონტროლერში ლოგიკის დამატება, რომელიც გადახდის შემდეგ დააგენერირებს PDF-ს, შეინახავს storage-ში და გაუგზავნის კლიენტს.
- [ ] **PayPal პაკეტის განახლების დაგეგმვა:**
  - **ამოცანა:** `srmklive/paypal` v3-ის ჩანაცვლება `blendbyte/laravel-paypal` ფორკით.
  - **შენიშვნა:** ეს სამუშაო უნდა შესრულდეს Laravel-ის შემდეგ ვერსიაზე (v13+) გადასვლამდე.

### **დაბალი პრიორიტეტი**

- [ ] **Digital Shop მოდული:** ციფრული პროდუქტების გაყიდვის ფუნქციონალი.
- [ ] **Subscription Model:** რეკურენტული გადახდების სისტემა (PayPal-ის გამოყენებით).
- [ ] **Social Share Buttons:** `guides/show.blade.php`-ზე გაზიარების ღილაკების დამატება.

---

## 17. მნიშვნელოვანი ფაილები

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ClientDashboardController.php   — Client Portal logic
│   │   ├── OrderController.php             — Order + session auth
│   │   ├── ProfileController.php           — User + Client sync
│   │   └── CommentController.php           — Rate limiting, @mention
│   ├── Middleware/
│   │   ├── CheckClientRole.php             — status + role check
│   │   └── CheckModuleEnabled.php          — module on/off
├── Models/
│   ├── User.php                            — avatar, memberSince
│   ├── Client.php                          — business data
│   ├── Project.php                         — order_id FK
│   └── Comment.php                         — parent_id, reply_to_user_id
├── Observers/
│   ├── OrderObserver.php                   — email + project creation (გადასაყვანია Queue-ზე)
│   ├── ProjectObserver.php                 — portfolio auto-creation
│   ├── PublicationObserver.php             — cache + WebP + Google ping
│   └── PortfolioProjectObserver.php        — cache + WebP
├── Services/
│   ├── OrderService.php                    — DB transaction, price calc
│   └── ImageService.php                    — WebP conversion
├── Providers/
│   └── AppServiceProvider.php             — Observers, Cache, View::composer
config/
└── agency.php                              — White-label config
resources/views/
├── layouts/main.blade.php                  — Header/Footer, dynamic menu
├── client-dashboard/
│   ├── index.blade.php                     — Dashboard stats, projects
│   └── project.blade.php                   — Project detail + Order info + Chat
├── blog/show.blade.php                     — Comments + @mention + replies
└── profile/edit.blade.php                  — Avatar gallery, interests (განახლებადია ტეგების სისტემის შემდეგ)
routes/web.php                              — Dynamic module slugs
bootstrap/app.php                           — Middleware aliases
```

---

## 18. გარემოს ცვლადები (.env)

```env
# App
APP_NAME=Archvadze
APP_URL=https://mycms.ddev.site:33001  # local
APP_DEBUG=true                          # local

# DB (DDEV)
DB_HOST=db
DB_DATABASE=db
DB_USERNAME=db
DB_PASSWORD=db

# Queue Driver
QUEUE_CONNECTION=database # რეკომენდებულია database ან redis

# Agency White-label
AGENCY_NAME=Archvadze
AGENCY_FULL_NAME="Archvadze Web Agency"
AGENCY_EMAIL=info@archvadze.com
ADMIN_EMAIL=admin@archvadze.com
AGENCY_TEAM_SIGNATURE="Archvadze Web Agency Team"
AGENCY_SEO_SUFFIX=Archvadze

# Email
MAIL_MAILER=log  # local (Mailpit)
RESEND_API_KEY=xxx  # production

# Social OAuth
GOOGLE_CLIENT_ID=xxx
FACEBOOK_CLIENT_ID=xxx
TWITTER_CLIENT_ID=xxx

# PayPal
PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=xxx
```

---

## 19. Test Users (DDEV)

```
Super Admin: admin@archvadze.com / [production password]
Admin:       admin@test.com / password123
Editor:      editor@test.com / password123
Support:     support@test.com / password123
```

---

## 20. სწრაფი კომანდები

```bash
# DDEV
ddev start / ddev stop
ddev exec php artisan optimize:clear
ddev exec php artisan migrate
ddev exec npm run build
ddev exec php artisan storage:link

# Queue (ახალი)
ddev exec php artisan queue:work
ddev exec php artisan queue:failed
ddev exec php artisan queue:retry all

# DB
ddev import-db --file=dump.sql
ddev export-db --file=dump.sql

# Cache
ddev exec php artisan config:clear
ddev exec php artisan route:clear
ddev exec php artisan view:clear
ddev exec php artisan cache:clear
```
