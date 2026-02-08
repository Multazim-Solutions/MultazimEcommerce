<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class UiComponentsTest extends TestCase
{
    public function test_badge_renders_brand_variant(): void
    {
        $html = Blade::render('<x-ui.badge variant="brand">New</x-ui.badge>');

        $this->assertStringContainsString('data-ui="badge"', $html);
        $this->assertStringContainsString('bg-brand-100', $html);
    }

    public function test_badge_falls_back_for_unknown_variant(): void
    {
        $html = Blade::render('<x-ui.badge variant="unknown">New</x-ui.badge>');

        $this->assertStringContainsString('bg-sand-100', $html);
    }

    public function test_alert_without_title_does_not_render_heading(): void
    {
        $html = Blade::render('<x-ui.alert variant="danger">Check your details.</x-ui.alert>');

        $this->assertStringContainsString('data-ui="alert"', $html);
        $this->assertStringNotContainsString('font-semibold', $html);
    }
}
