# Visual QA Checklist

Quick human pass before release. Keep it boring, keep it sharp.

## Storefront

- [ ] `/products` shows real cards (no skeleton-only state), filters, and sort controls.
- [ ] Product cards keep image aspect ratio and do not jump while loading.
- [ ] `/products/{slug}` gallery swaps images without layout shift.
- [ ] Out-of-stock products show disabled action, not a broken submit path.
- [ ] `/cart` displays line totals and summary totals on mobile and desktop.
- [ ] `/checkout` shows contact + address + payment sections with inline errors.

## Admin

- [ ] `/admin/login` lands on login with admin hint visible.
- [ ] `/admin` stats cards render counts and links.
- [ ] `/admin/products` filter panel works and empty state is explicit.
- [ ] `/admin/products/{id}/edit` image preview appears before upload.
- [ ] Image upload errors render in-page (type/size violations).
- [ ] `/admin/orders` filter panel works and status badges are readable.
- [ ] `/admin/orders/{id}` status update feedback is visible.

## Accessibility + UX

- [ ] Keyboard can reach every interactive control in nav, forms, and tables.
- [ ] Focus rings are visible against background colors.
- [ ] Alerts and form errors are announced (`role` + `aria-live`).
- [ ] Reduced-motion mode suppresses transitions/animations.

## Command Snippets

- `php artisan test`
- `npx playwright test`
