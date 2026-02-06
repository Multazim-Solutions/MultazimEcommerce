<?php

declare(strict_types=1);

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function show(): View
    {
        return view('storefront.checkout.show');
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $request->validated();

        return redirect()
            ->route('storefront.checkout.show')
            ->with('status', 'Checkout details saved');
    }
}
