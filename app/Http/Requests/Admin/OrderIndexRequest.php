<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<string, array<int, \Illuminate\Contracts\Validation\ValidationRule|string>>
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', Rule::in(array_merge(['all'], OrderStatus::values()))],
        ];
    }

    public function search(): ?string
    {
        $value = $this->string('q')->trim()->value();

        return $value === '' ? null : $value;
    }

    public function status(): ?OrderStatus
    {
        $value = $this->string('status')->value();

        if ($value === '' || $value === 'all') {
            return null;
        }

        return OrderStatus::tryFrom($value);
    }

    public function selectedStatus(): string
    {
        $value = $this->string('status')->value();

        return $value === '' ? 'all' : $value;
    }
}
