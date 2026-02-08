@props(['title' => null])

<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid gap-6 lg:grid-cols-[240px,1fr]">
                <aside class="hidden lg:block">
                    <div class="sticky top-24 rounded-2xl border border-sand-200 bg-white/80 p-4 shadow-elev-1">
                        <p class="text-xs uppercase tracking-[0.25em] text-muted">Admin</p>
                        <nav class="mt-4 space-y-1 text-sm font-medium">
                            <a class="{{ request()->routeIs('admin.dashboard') ? 'rounded-lg bg-sand-100 px-3 py-2 text-ink-900' : 'rounded-lg px-3 py-2 text-muted hover:bg-sand-100 hover:text-ink-900' }}" href="{{ route('admin.dashboard') }}">Overview</a>
                            <a class="{{ request()->routeIs('admin.products.*') ? 'rounded-lg bg-sand-100 px-3 py-2 text-ink-900' : 'rounded-lg px-3 py-2 text-muted hover:bg-sand-100 hover:text-ink-900' }}" href="{{ route('admin.products.index') }}">Products</a>
                            <a class="{{ request()->routeIs('admin.orders.*') ? 'rounded-lg bg-sand-100 px-3 py-2 text-ink-900' : 'rounded-lg px-3 py-2 text-muted hover:bg-sand-100 hover:text-ink-900' }}" href="{{ route('admin.orders.index') }}">Orders</a>
                        </nav>
                    </div>
                </aside>

                <div class="space-y-6">
                    <nav class="flex flex-wrap gap-2 lg:hidden">
                        <a class="{{ request()->routeIs('admin.dashboard') ? 'rounded-full bg-sand-100 px-3 py-1.5 text-sm font-medium text-ink-900' : 'rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-muted' }}" href="{{ route('admin.dashboard') }}">Overview</a>
                        <a class="{{ request()->routeIs('admin.products.*') ? 'rounded-full bg-sand-100 px-3 py-1.5 text-sm font-medium text-ink-900' : 'rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-muted' }}" href="{{ route('admin.products.index') }}">Products</a>
                        <a class="{{ request()->routeIs('admin.orders.*') ? 'rounded-full bg-sand-100 px-3 py-1.5 text-sm font-medium text-ink-900' : 'rounded-full border border-sand-200 px-3 py-1.5 text-sm font-medium text-muted' }}" href="{{ route('admin.orders.index') }}">Orders</a>
                    </nav>

                    @if ($title)
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-muted">Admin</p>
                            <h2 class="font-display text-2xl text-ink-900">{{ $title }}</h2>
                        </div>
                    @endif

                    @if (session('status'))
                        <x-ui.alert variant="success" title="Success">
                            {{ session('status') }}
                        </x-ui.alert>
                    @endif

                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
