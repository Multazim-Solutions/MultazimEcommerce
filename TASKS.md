# TASKS

**Phase 19 - Storefront Refresh**

- [ ] P19-T01 Add home promotional slider using provided campaign image URLs
- [ ] P19-T02 Add category image support (migration, model, seeder)
- [ ] P19-T03 Add subcategory image support (migration, model, seeder)
- [ ] P19-T04 Render category and subcategory images in storefront UI
- [ ] P19-T05 Add feature tests for category/subcategory image rendering and fallback states
- [ ] P19-T06 Rework home promotions to full-width cover banners (image-only, no text/indicators/arrows)
- [ ] P19-T07 Remove catalog category from category section; render only real category cards
- [ ] P19-T08 Add contextual illustrations/icons across key storefront/admin states

**Phase 20 - Category Navigation + Product Listing Fixes**

- [ ] P20-T01 Add category details page route and controller flow
- [ ] P20-T02 Show only selected category products on category details page
- [ ] P20-T03 Show subcategories as filter chips when subcategories exist
- [ ] P20-T04 Remove remaining products section from storefront views
- [ ] P20-T05 Add feature + Playwright tests for category click-through and chip filtering
- [ ] P20-T06 Make secondary category top bar single-line using live category data from database
- [ ] P20-T07 Show subcategories on desktop hover for each top-bar category
- [ ] P20-T08 Move category navigation to mobile drawer and reveal subcategories on tap
- [ ] P20-T09 Show associated category on product details page
- [ ] P20-T10 Add hover zoom behavior for product images on product details page

**Phase 21 - Real Product Seed Pipeline**

- [ ] P21-T01 Create scraper command/service to collect catalog data from multazim.com into JSON
- [ ] P21-T02 Map scraped data to typed seed payloads (name, slug, price, stock, category, image)
- [ ] P21-T03 Refactor product factory/seeder to use scraped dataset instead of placeholder faker data
- [ ] P21-T04 Make seed import idempotent to prevent duplicates on reseed
- [ ] P21-T05 Add unit/feature tests for parser and seeded catalog integrity

**Phase 22 - Testing Deployment**

- [ ] P22-T01 Add testing environment configuration for testing.multazim.solutions
- [ ] P22-T02 Add deployment flow for testing host with safe migration and cache steps
- [ ] P22-T03 Configure HTTPS + server host rules for testing.multazim.solutions
- [ ] P22-T04 Run smoke tests (storefront, auth, cart, checkout callbacks) against testing environment
- [ ] P22-T05 Share stakeholder QA handoff checklist for testing environment validation

**Phase 23 - Floating Quick Actions**

- [ ] P23-T01 Add storefront floating WhatsApp action button with configurable contact link
- [ ] P23-T02 Add storefront floating cart action button with live cart count badge
- [ ] P23-T03 Ensure floating action buttons are responsive, accessible, and non-overlapping on mobile/desktop
- [ ] P23-T04 Add feature + Playwright tests for floating action button behavior and visibility rules
