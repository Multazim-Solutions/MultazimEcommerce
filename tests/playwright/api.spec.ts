import { expect, test } from '@playwright/test';

const shouldRun = Boolean(process.env.PLAYWRIGHT_BASE_URL);

test.describe('API E2E', () => {
  test('health endpoint responds with ok', async ({ request }) => {
    test.skip(!shouldRun, 'Set PLAYWRIGHT_BASE_URL to run API E2E tests.');

    const response = await request.get('/api/v1/health');
    expect(response.ok()).toBeTruthy();
    await expect(response.json()).resolves.toEqual({ status: 'ok' });
  });

  test('checkout endpoint redirects on empty cart', async ({ request }) => {
    test.skip(!shouldRun, 'Set PLAYWRIGHT_BASE_URL to run API E2E tests.');

    const response = await request.post('/checkout', {
      form: {
        full_name: 'Playwright Tester',
        email: 'tester@example.com',
        phone: '0123456789',
        address_line1: '123 Example Street',
        address_line2: 'Suite 2',
        city: 'Dhaka',
        postal_code: '1205',
      },
    });

    expect(response.status()).toBe(302);
    const location = response.headers()['location'] ?? '';
    expect(location).toContain('/checkout');
  });
});
