import { expect, test } from '@playwright/test';

const shouldRun = Boolean(process.env.PLAYWRIGHT_BASE_URL);

test.describe('Storefront UI', () => {
  test('catalog to checkout surface flow', async ({ page }) => {
    test.skip(!shouldRun, 'Set PLAYWRIGHT_BASE_URL to run UI E2E tests.');

    await page.goto('/products');
    await expect(page.getByRole('heading', { name: 'Products' })).toBeVisible();

    await page.getByLabel('Search').fill('a');
    await page.getByLabel('Sort').selectOption('name_asc');
    await page.getByRole('button', { name: 'Apply' }).click();

    await expect(page).toHaveURL(/products\?/);

    const addToCartButton = page.getByRole('button', { name: 'Add to cart' }).first();
    if ((await addToCartButton.count()) === 0) {
      test.skip(true, 'No in-stock products available. Seed data before running this test.');
    }

    await addToCartButton.click();

    await expect(page.getByRole('heading', { name: 'Your Cart' })).toBeVisible();
    await expect(page.getByText('Order summary')).toBeVisible();

    await page.getByRole('link', { name: 'Proceed to checkout' }).click();

    await expect(page.getByRole('heading', { name: 'Checkout' })).toBeVisible();
    await expect(page.locator('input[name="payment_method"][value="sslcommerz"]')).toBeChecked();
  });
});
