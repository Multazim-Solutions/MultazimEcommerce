**Progress**
- Phase 0 - Project Setup [done]
- Phase 1 - Architecture & Routing [done]
- Phase 2 - Database & Models [done]

**High-Level Architecture**
- Laravel monolith with clear separation between Web UI and API endpoints
- API-first design: storefront and admin consume shared JSON APIs; Blade (or lightweight JS) renders UI
- Storefront module with modern, simple, lightweight UI for product listing, product details, cart, and checkout
- Admin dashboard module with authentication-protected product CRUD, order management, and image management
- SQLite for initial persistence, with database abstraction kept behind Eloquent and repository/service layers
- Local filesystem storage for product images using Laravel Filesystem
- Containerized runtime with Docker and `docker-compose`
- Structured application logging with JSON output for easy parsing

**Directory Structure And Key Laravel Components**
- `app/Http/Controllers` for storefront, admin, and API controllers
- `app/Http/Middleware` for auth, role checks, rate limiting, and request logging
- `app/Models` for Product, Order, OrderItem, User, ProductImage
- `app/Services` for payment, checkout, image handling, and order processing
- `app/Policies` for authorization (admin vs customer)
- `app/Providers` for binding interfaces (payment gateway, storage, repositories)
- `routes/web.php` for storefront and admin UI routes
- `routes/api.php` for API-first endpoints used by web and future mobile
- `resources/views` for storefront and admin templates
- `database/migrations` for schema (SQLite compatible)
- `storage/app/public` for product images (served via `public/storage` symlink)

**Database Schema (SQLite)**
- `users`
- `users.id` (PK), `name`, `email` (unique), `password_hash`, `google_id` (nullable), `role` (admin|customer), `created_at`, `updated_at`
- `products`
- `products.id`, `name`, `slug` (unique), `description`, `price`, `currency`, `stock_qty`, `is_active`, `created_at`, `updated_at`
- `product_images`
- `product_images.id`, `product_id` (FK), `path`, `alt_text`, `sort_order`, `created_at`, `updated_at`
- `orders`
- `orders.id`, `user_id` (FK), `status` (pending|paid|failed|shipped|cancelled), `subtotal`, `shipping`, `tax`, `total`, `currency`, `payment_provider`, `payment_ref`, `created_at`, `updated_at`
- `order_items`
- `order_items.id`, `order_id` (FK), `product_id` (FK), `name_snapshot`, `price_snapshot`, `qty`, `line_total`, `created_at`, `updated_at`
- `carts` (optional for persistence; otherwise session-based)
- `carts.id`, `user_id` (nullable), `session_id`, `created_at`, `updated_at`
- `cart_items`
- `cart_items.id`, `cart_id` (FK), `product_id` (FK), `qty`, `created_at`, `updated_at`

**Docker Setup (Services, Volumes, Env Strategy)**
- Services
- `app` container for Laravel PHP-FPM or Octane
- `web` container for Nginx (reverse proxy + static assets)
- Optional `queue` worker container for async jobs
- Optional `scheduler` container for cron-like tasks
- Volumes
- Bind mount for app source code in development
- Named volume for `storage/` to persist uploads
- Named volume for SQLite database file
- Env strategy
- `.env` for local development; `.env.example` for defaults
- Separate `docker-compose.override.yml` for dev overrides
- Centralized configuration via Laravel config files; no hardcoded secrets

**Authentication And Authorization Flow**
- Email & password authentication via Laravel auth scaffolding
- Google Sign-In via OAuth2 with Socialite
- Unified user table with `google_id` for account linking
- Role-based access control with policies and gates
- Admin routes guarded by `auth` and `role:admin` middleware
- API endpoints protected with tokens (Laravel Sanctum) for future mobile clients

**Payment Flow With SSLCommerz**
- Checkout creates `orders` record in `pending` status
- Redirect to SSLCommerz payment gateway with signed request
- Handle success, fail, and cancel callbacks via dedicated endpoints
- On success callback, verify payment with SSLCommerz validation endpoint
- Update order status to `paid` and store `payment_ref`
- On failure or cancel, update order status to `failed` or `cancelled`
- Idempotent callback handling to avoid duplicate updates

**Image Upload And Storage Strategy**
- Store images under `storage/app/public/products/<product_id>/`
- Generate optimized sizes (thumbnail, medium, large) on upload
- Save image metadata in `product_images` table
- Serve via `public/storage` symlink and Nginx static rules
- Enforce file type, size limits, and virus scan hook (future)

**Logging Approach**
- Structured JSON logs using Laravel Monolog configuration
- Separate channels for `app`, `payments`, and `auth`
- Include request ID, user ID, and order ID in log context
- Log to stdout in containers for easy collection by Docker

**Security Considerations**
- Input validation on all endpoints using Form Requests
- CSRF protection for web forms
- Rate limiting on auth and checkout endpoints
- Secure password hashing (bcrypt/argon2)
- Strict file upload validation and storage outside web root
- Environment secrets managed via `.env` and Docker secrets in production
- Use HTTPS in production; secure cookies and same-site policy

**Future Extensibility Notes**
- API versioning (`/api/v1`) to support mobile clients
- Swap SQLite with MySQL/PostgreSQL by keeping Eloquent and migrations database-agnostic
- Introduce queue workers for email, image processing, and payment reconciliation
- Add caching layer (Redis) for catalog and session data
- Prepare for CDN by abstracting storage disk configuration
- Horizontal scaling by separating web and worker containers

**Testing Strategy**
- PHPUnit for unit and feature tests within Laravel
- Playwright for API and UI end-to-end tests
