<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Tentukan apakah user memiliki otorisasi untuk membuat request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk request ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'handphone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'role' => ['required', 'string', 'in:owner,member,customer'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'agree' => ['accepted'],
        ];
    }

    /**
     * Dapatkan pesan kesalahan khusus untuk aturan validasi yang ditentukan.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama lengkap maksimal 100 karakter.',
            'handphone.required' => 'Nomor handphone wajib diisi.',
            'handphone.max' => 'Nomor handphone maksimal 30 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk.',
            'role.required' => 'Pilihan peran akun wajib dipilih.',
            'role.in' => 'Pilihan peran akun tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'agree.accepted' => 'Anda harus menyetujui Syarat & Ketentuan serta Kebijakan Privasi.',
        ];
    }
}
