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

## Quick Start (Local, Docker)
1. Copy env file
- `cp .env.example .env`
2. Build and run
- `docker compose up --build`
3. App will be available at
- `http://localhost:8080` (expected)

## Environment
- Edit `.env` for runtime values
- Set Google OAuth keys (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`)
- Set SSLCommerz keys and callbacks (`SSLCOMMERZ_STORE_ID`, `SSLCOMMERZ_STORE_PASSWORD`, `SSLCOMMERZ_*_URL`)

## Local (Non-Docker)
1. Install PHP and Composer
2. Install dependencies
- `composer install`
3. Set up environment
- `cp .env.example .env`
- `php artisan key:generate`
4. Run migrations
- `php artisan migrate`
5. Start server
- `php artisan serve`

## Tests
- `php artisan test`

## Deployment
- Build containers in CI or on server
- Configure `.env` for production secrets and URLs
- Use `docker compose up -d --build`
- Ensure HTTPS termination (reverse proxy or load balancer)
- Mount persistent volumes for `storage/` and database file

## Deployment On cPanel
- Use cPanel File Manager or Git deployment to upload the project
- Set the web root to `public/`
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

## Commit Convention
- Format: `feat/refactor/fix[phase_id-task-id]: message, loong message`
- Optional: add a second line with further description if needed
- Example: `feat[P4-T03]: storefront list view, loong message`
- Branching: no new branches for now; all work happens on `master`
