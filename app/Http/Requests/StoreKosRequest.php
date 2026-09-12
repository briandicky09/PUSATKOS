<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreKosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->can('create', \App\Models\Kos::class);
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('title') && !$this->filled('slug')) {
            $baseSlug = Str::slug($this->input('title'));
            $slug = $baseSlug;
            $counter = 1;
            while (\App\Models\Kos::withTrashed()->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $this->merge([
                'slug' => $slug,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:kos,slug'],
            'type' => ['required', 'string', Rule::in(['Putra', 'Putri', 'Campur', 'Eksklusif'])],
            'city' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'address' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'nama kos',
            'type' => 'tipe kos',
            'city' => 'kota',
            'price' => 'harga sewa',
            'address' => 'alamat',
            'description' => 'deskripsi kos',
            'thumbnail' => 'foto kos',
        ];
    }

    /**
     * Get custom error messages for validation failures.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'slug.unique' => 'Nama kos atau slug ini sudah digunakan, silakan gunakan nama lain.',
            'type.in' => 'Tipe kos yang dipilih harus salah satu dari: Putra, Putri, Campur, atau Eksklusif.',
        ];
    }
}
