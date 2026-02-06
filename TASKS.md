# TASKS

**Phase 0 - Project Setup**

- [x] P0-T01 Initialize Laravel project skeleton
- [x] P0-T02 Add `.env.example` and local `.env` guidance
- [x] P0-T03 Define base `.gitignore` and repo hygiene
- [x] P0-T04 Confirm `AGENTS.md` rules are current
- [x] P0-T05 Confirm `README.md` is aligned with stakeholders
- [x] P0-T06 Add commit convention section to docs

**Phase 1 - Architecture & Routing**

- [x] P1-T01 Define web and API route groups
- [x] P1-T02 Add API version prefix (`/api/v1`)
- [x] P1-T03 Add request ID middleware
- [x] P1-T04 Add rate limiting rules (auth, checkout)
- [x] P1-T05 Create base controllers for storefront, admin, and API

**Phase 2 - Database & Models**

- [x] P2-T01 Create migrations for users
- [x] P2-T02 Create migrations for products
- [x] P2-T03 Create migrations for product_images
- [x] P2-T04 Create migrations for orders
- [x] P2-T05 Create migrations for order_items
- [x] P2-T06 Create migrations for carts (optional)
- [x] P2-T07 Create migrations for cart_items (optional)
- [x] P2-T08 Create Eloquent models with relationships
- [x] P2-T09 Add factories and seeders for test data

**Phase 3 - Authentication & Authorization**

- [x] P3-T01 Install Laravel auth scaffolding
- [x] P3-T02 Add Google OAuth via Socialite
- [x] P3-T03 Implement account linking with `google_id`
- [x] P3-T04 Add roles (`admin`, `customer`) to users
- [x] P3-T05 Add policies and gates for admin actions
- [x] P3-T06 Protect admin routes with `auth` and role middleware
- [x] P3-T07 Add Sanctum for API token auth

**Phase 4 - Storefront (Web + API)**

- [x] P4-T01 Product listing API endpoint
- [x] P4-T02 Product details API endpoint
- [x] P4-T03 Storefront list page
- [x] P4-T04 Storefront details page
- [x] P4-T05 Cart add/remove/update endpoints
- [x] P4-T06 Cart UI components
- [x] P4-T07 Checkout form validation

**Phase 5 - Orders & Checkout**

- [x] P5-T01 Create order from cart
- [x] P5-T02 Calculate totals (subtotal, tax, shipping)
- [x] P5-T03 Persist order items with snapshots
- [x] P5-T04 Update stock on order placement

**Phase 6 - Admin Dashboard**

- [x] P6-T01 Admin auth-protected layout
- [x] P6-T02 Product CRUD endpoints
- [x] P6-T03 Product CRUD UI
- [x] P6-T04 Order list and detail views
- [x] P6-T05 Order status update flow
- [x] P6-T06 Image upload and management UI

**Phase 7 - Payments (SSLCommerz)**

- [ ] P7-T01 Add payment service interface
- [ ] P7-T02 Implement SSLCommerz gateway client
- [ ] P7-T03 Initiate payment from checkout
- [ ] P7-T04 Handle success callback
- [ ] P7-T05 Handle failure callback
- [ ] P7-T06 Handle cancel callback
- [ ] P7-T07 Validate payment status with gateway
- [ ] P7-T08 Ensure idempotent callbacks

**Phase 8 - Image Storage**

- [ ] P8-T01 Configure filesystem disk for products
- [ ] P8-T02 Store images under product directory
- [ ] P8-T03 Generate thumbnails and resized variants
- [ ] P8-T04 Persist image metadata
- [ ] P8-T05 Serve images via `public/storage`

**Phase 9 - Logging**

- [ ] P9-T01 Configure JSON log formatter
- [ ] P9-T02 Add `app`, `payments`, `auth` log channels
- [ ] P9-T03 Enrich logs with request/user/order context

**Phase 10 - Docker & Deployment**

- [ ] P10-T01 Create Dockerfile for app
- [ ] P10-T02 Create Nginx config
- [ ] P10-T03 Create `docker-compose.yml`
- [ ] P10-T04 Add volume mounts for `storage/` and SQLite
- [ ] P10-T05 Document cPanel deployment path and web root

**Phase 11 - Security & Hardening**

- [ ] P11-T01 Enforce Form Request validation on inputs
- [ ] P11-T02 Configure CSRF protection for web
- [ ] P11-T03 Add file upload MIME and size limits
- [ ] P11-T04 Harden session and cookie settings

**Phase 12 - Testing**

- [ ] P12-T01 Feature tests for storefront list and details
- [ ] P12-T02 Feature tests for cart add/remove/update
- [ ] P12-T03 Feature tests for checkout validation
- [ ] P12-T04 Feature tests for admin auth guard
- [ ] P12-T05 Feature tests for product CRUD
- [ ] P12-T06 Feature tests for order management
- [ ] P12-T07 Feature tests for image upload
- [ ] P12-T08 Feature tests for SSLCommerz success/fail/cancel
- [ ] P12-T09 Unit tests for totals calculation
- [ ] P12-T10 Unit tests for order status transitions
- [ ] P12-T11 Playwright E2E for storefront and cart flows
- [ ] P12-T12 Playwright E2E for admin workflows
- [ ] P12-T13 Playwright API tests for health and checkout endpoints

**Phase 13 - Documentation**

- [ ] P13-T01 Update README with run/test/deploy steps
- [ ] P13-T02 Add minimal API usage notes
- [ ] P13-T03 Keep AGENTS rules current
