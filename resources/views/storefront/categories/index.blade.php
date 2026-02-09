<x-storefront-layout>
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 sm:py-10">
        <section class="rounded-2xl border border-sand-200 bg-white/90 p-5 shadow-elev-1 sm:p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-muted">Catalog</p>
                    <h1 class="font-display text-2xl text-ink-900">All Categories</h1>
                </div>
                <a href="{{ route('storefront.home') }}" class="text-sm font-semibold text-accent-700 hover:text-accent-800">
                    Back to home
                </a>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-2">
            @forelse ($rootCategories as $rootCategory)
                <article id="category-{{ $rootCategory->id }}" class="rounded-xl border border-sand-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-ink-900">{{ $rootCategory->name }}</h2>
                    <p class="mt-1 text-sm text-muted">{{ $rootCategory->children_count }} subcategories</p>

                    @if ($rootCategory->children->isNotEmpty())
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach ($rootCategory->children as $subcategory)
                                <a
                                    href="{{ route('storefront.products.index', ['q' => $subcategory->name]) }}"
                                    class="rounded-full border border-sand-200 bg-white px-3 py-1.5 text-sm text-ink-700 transition hover:border-accent-400 hover:text-ink-900"
                                >
                                    {{ $subcategory->name }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4 text-sm text-muted">No subcategories added yet.</p>
                    @endif
                </article>
            @empty
                <div class="lg:col-span-2">
                    <x-ui.empty-state title="No categories found" description="Run seeders to generate storefront categories." />
                </div>
            @endforelse
        </section>
    </div>
</x-storefront-layout>
