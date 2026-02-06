# Multazim Ecommerce

Simple, modern e-commerce platform for Bangladesh. Built to move fast now and scale later.

## What This Is
- Web storefront: product list, product details, cart, checkout
- Admin dashboard: product CRUD, order management, image uploads
- API-first design: web UI and future mobile app share the same API
- Payment: SSLCommerz
- Auth: Email/Password + Google Sign-In

## Who This Is For
- Founders and stakeholders who need product clarity
- Engineers and operators who need to run or extend the system

## Tools Used
- Laravel (PHP)
- SQLite (initial DB, swappable later)
- Docker + docker-compose
- Nginx + PHP-FPM (containerized)
- Structured logging (JSON)
- AI tooling: Laravel Boost (assists AI-driven codegen, refactors, tests)

## Docker Setup
- Services: `app` (PHP-FPM), `web` (Nginx)
- Optional services in future: `queue`, `scheduler`
- Volumes: `storage/` for uploads, SQLite DB file volume
- Env: use `.env` for local, `.env.prod` for production

## Quick Start (Docker)
1. `cp .env.example .env`
2. `docker compose up --build`
3. Open `http://localhost:8080`

## Run Guide (Local, Non-Docker)
1. Install PHP and Composer
2. `composer install`
3. `cp .env.example .env`
4. `php artisan key:generate`
5. `php artisan migrate`
6. `php artisan serve`

## Environment
- Edit `.env` for runtime values
- Set Google OAuth keys: `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`
- Set SSLCommerz keys and callbacks: `SSLCOMMERZ_STORE_ID`, `SSLCOMMERZ_STORE_PASSWORD`, `SSLCOMMERZ_*_URL`

## API Notes (Minimal)
- `GET /api/v1/health` -> `{ "status": "ok" }`
- `GET /api/v1/products` -> product list
- `GET /api/v1/products/{slug}` -> product detail
- Cart endpoints require Sanctum auth
- `POST /api/v1/cart/items` -> add item
- `PATCH /api/v1/cart/items/{id}` -> update qty
- `DELETE /api/v1/cart/items/{id}` -> remove

## Tests
- PHPUnit: `php artisan test`
- Playwright (UI + API): `npm run test:e2e`
- Playwright expects a running app
- Required env for E2E: `PLAYWRIGHT_BASE_URL`
- Admin UI E2E needs `E2E_ADMIN_EMAIL` and `E2E_ADMIN_PASSWORD`

## Deployment
- Build containers in CI or on server
- Configure `.env` for production secrets and URLs
- Use `docker compose up -d --build`
- Ensure HTTPS termination (reverse proxy or load balancer)
- Mount persistent volumes for `storage/` and database file

## Deployment On cPanel
- Use cPanel File Manager or Git deployment to upload the project
- Set the web root to `public/`
- If required, point `public_html` to `public/` via symlink or document root setting
- Ensure PHP version matches Laravel requirements
- Configure `.env` with production settings
- Run migrations from terminal (if available) or via a one-time CLI task
- Point `storage/` to a writable path and run `php artisan storage:link`
- Use cPanel SSL for HTTPS

## Project Direction
- First release: stable web storefront and admin dashboard
- Next: mobile app using the same API
- Future: swap SQLite to MySQL/PostgreSQL, add caching, add queue workers

## Notes
- Keep docs lean and useful
- Follow `AGENTS.md` for coding and testing rules
- Keep Laravel conventions; avoid over-engineering
- See `PLAN.md` and `TASKS.md` for roadmap and execution flow

## Commit Convention
- Format: `feat/refactor/fix[phase_id-task-id]: short message`
- Optional: add a second line with further description if needed
- Example: `feat[P4-T03]: storefront list view`
- Branching: no new branches for now; all work happens on `master`
