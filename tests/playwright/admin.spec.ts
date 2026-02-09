import { expect, test, Page } from '@playwright/test';

const baseUrlSet = Boolean(process.env.PLAYWRIGHT_BASE_URL);
const adminEmail = process.env.E2E_ADMIN_EMAIL;
const adminPassword = process.env.E2E_ADMIN_PASSWORD;

const shouldRun = baseUrlSet && Boolean(adminEmail) && Boolean(adminPassword);

async function signInAsAdmin(page: Page) {
  await page.goto('/admin/login');
  await page.getByLabel('Email').fill(adminEmail as string);
  await page.getByLabel('Password').fill(adminPassword as string);
  await page.getByRole('button', { name: 'Log in' }).click();
}

test.describe('Admin UI', () => {
  test('admin dashboard and catalog flow', async ({ page }) => {
    test.skip(!shouldRun, 'Set PLAYWRIGHT_BASE_URL, E2E_ADMIN_EMAIL, and E2E_ADMIN_PASSWORD.');

    await signInAsAdmin(page);

    await page.goto('/admin');
    await expect(page.getByRole('heading', { name: 'Admin Dashboard' })).toBeVisible();
    await expect(page.getByText('Total products')).toBeVisible();

    await page.goto('/admin/products/create');
    await expect(page.getByRole('heading', { name: 'New Product' })).toBeVisible();

    const slug = `e2e-product-${Date.now()}`;

    await page.getByLabel('Name').fill('E2E Product');
    await page.getByLabel('Slug').fill(slug);
    await page.getByLabel('Description').fill('Created by Playwright');
    await page.getByLabel('Price').fill('199.99');
    await page.getByLabel('Currency').fill('BDT');
    await page.getByLabel('Stock').fill('15');
    await page.getByLabel('Active').selectOption('1');

    await page.getByRole('button', { name: 'Create' }).click();

    await expect(page.getByText('Product created')).toBeVisible();
    await expect(page.getByRole('heading', { name: 'Edit Product' })).toBeVisible();

    await page.goto('/admin/products');
    await page.getByLabel('Search').fill(slug);
    await page.getByRole('button', { name: 'Apply' }).click();

    await expect(page.getByText('E2E Product')).toBeVisible();

    await page.goto('/admin/orders');
    await expect(page.getByRole('heading', { name: 'Orders' })).toBeVisible();
    await expect(page.getByText('Filter orders')).toBeVisible();
  });
});
