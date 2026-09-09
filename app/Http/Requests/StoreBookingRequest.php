<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isCustomer();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tenant_name' => ['required', 'string', 'max:100'],
            'tenant_email' => ['required', 'email', 'max:150'],
            'tenant_phone' => ['required', 'string', 'min:9', 'max:30', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'duration' => ['required', 'integer', 'min:1', 'max:12'],
            'notes' => ['nullable', 'string', 'max:500'],
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
            'tenant_name' => 'nama lengkap penyewa',
            'tenant_email' => 'alamat email',
            'tenant_phone' => 'nomor telepon / WhatsApp',
            'check_in' => 'tanggal mulai sewa',
            'duration' => 'durasi sewa',
            'notes' => 'catatan',
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
            'check_in.after_or_equal' => 'Tanggal mulai sewa tidak boleh di masa lalu.',
            'duration.min' => 'Durasi sewa minimal 1 bulan.',
            'duration.max' => 'Durasi sewa maksimal 12 bulan.',
            'tenant_phone.regex' => 'Format nomor telepon / WhatsApp tidak valid.',
        ];
    }
}
