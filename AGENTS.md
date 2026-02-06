# AGENTS

Lean guide for contributors and automation. Keep it small, keep it sharp.

## Ground Rules

- Follow Laravel conventions first. Do not invent frameworks or patterns outside Laravel style.
- Favor clarity over cleverness. Small, composable classes.
- Every change ships with tests for success, failure, and edge cases.
- Keep documentation minimal, useful, and readable in a 70s hacker notebook tone.
- When a task is completed, mark it as `[x]` in `TASKS.md`.

## PHP Strictness

- Add `declare(strict_types=1);` at the top of PHP files where possible.
- Use scalar and return type hints everywhere.
- Prefer value objects or DTOs for complex payloads; keep arrays simple and shaped.

## Laravel Practices

- Controllers stay thin: validation + orchestration only.
- Use Form Requests for validation.
- Use Policies/Gates for authorization.
- Use Services for business logic; keep Models slim.
- Use Eloquent relationships and query scopes where they improve readability.
- Use Events/Listeners for side effects (emails, inventory, payment reconciliation).
- Use Jobs for async work; keep queue-safe serialization.
- Config via `config/*.php`, not hardcoded values.
- Use Laravel Boost to assist AI-driven development (codegen, refactors, tests) while keeping output aligned with Laravel conventions.

## Testing (Required)

- Use Laravel’s default test stack (PHPUnit). Use Pest only if already installed.
- Use Playwright for API and UI testing (end-to-end coverage).
- Add tests for every feature, including:
- Storefront: list, details, cart add/remove, checkout validation
- Admin: auth guard, product CRUD, order updates, image upload
- Payments: SSLCommerz success, fail, cancel, and webhook idempotency
- Auth: email/password login, Google OAuth, account linking
- Data: stock changes, pricing totals, order status transitions
- Use database transactions or in-memory SQLite in tests.
- Prefer Feature tests for full flows; Unit tests for services and pure logic.

## Security & Data Hygiene

- Validate all input via Form Requests.
- Protect all admin routes with auth + role checks.
- Sanitize file uploads; enforce MIME and size limits.
- Never log secrets or full card/payment payloads.

## Logging

- Use structured JSON logs with context (`request_id`, `user_id`, `order_id`).
- Keep payment and auth logs in separate channels.

## Documentation Style

- Short, clear, bullet-heavy.
- Avoid long prose and marketing tone.
- Include commands and expected outputs when useful.
- Keep README and docs minimal but sufficient to run, test, and deploy.

## Definition Of Done

- Code follows Laravel style and strict typing.
- Tests added and passing for each relevant case.
- No new warnings or lint errors.
- Docs updated only where needed and kept lean.

## Commit Convention

- Format: `feat/refactor/fix[phase_id-task-id]: short message`
- Optional: add a second line with further description if needed
- Example: `fix[P7-T08]: idempotent payment callback`
- Branching: no new branches for now; all work happens on `master`

## Useful Commands

- `php artisan test`
- `php artisan migrate`
- `php artisan serve` (local)
- `docker compose up --build`
