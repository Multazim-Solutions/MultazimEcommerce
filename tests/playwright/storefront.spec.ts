import { expect, test } from '@playwright/test';

const shouldRun = Boolean(process.env.PLAYWRIGHT_BASE_URL);

test.describe('Storefront UI', () => {
  test('browse products and add to cart', async ({ page }) => {
    test.skip(!shouldRun, 'Set PLAYWRIGHT_BASE_URL to run UI E2E tests.');

    await page.goto('/products');
    await expect(page.getByRole('heading', { name: 'Products' })).toBeVisible();

    const emptyState = page.getByText('No products available.');
    if (await emptyState.count()) {
      test.skip(true, 'No products available. Seed data before running this test.');
    }

    const addButtons = page.getByRole('button', { name: '+' });
    await addButtons.first().click();

    await expect(page.getByRole('heading', { name: 'Your Cart' })).toBeVisible();
    await expect(page.getByText('Added to cart')).toBeVisible();
  });
});
