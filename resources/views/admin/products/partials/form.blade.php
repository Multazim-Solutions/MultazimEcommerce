<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product?->name)" required />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label for="slug" :value="__('Slug')" />
    <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug', $product?->slug)" required />
    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
</div>

<div>
    <x-input-label for="description" :value="__('Description')" />
    <textarea id="description" name="description" class="mt-1 w-full rounded border-gray-300" rows="4">{{ old('description', $product?->description) }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <x-input-label for="price" :value="__('Price')" />
        <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price', $product?->price)" required />
        <x-input-error :messages="$errors->get('price')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="currency" :value="__('Currency')" />
        <x-text-input id="currency" class="block mt-1 w-full" type="text" name="currency" :value="old('currency', $product?->currency ?? 'BDT')" required />
        <x-input-error :messages="$errors->get('currency')" class="mt-2" />
    </div>
</div>

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <x-input-label for="stock_qty" :value="__('Stock')" />
        <x-text-input id="stock_qty" class="block mt-1 w-full" type="number" name="stock_qty" :value="old('stock_qty', $product?->stock_qty ?? 0)" required />
        <x-input-error :messages="$errors->get('stock_qty')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="is_active" :value="__('Active')" />
        <select id="is_active" name="is_active" class="mt-1 w-full rounded border-gray-300">
            <option value="1" @selected(old('is_active', $product?->is_active ?? true))>Yes</option>
            <option value="0" @selected(! old('is_active', $product?->is_active ?? true))>No</option>
        </select>
        <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
    </div>
</div>
