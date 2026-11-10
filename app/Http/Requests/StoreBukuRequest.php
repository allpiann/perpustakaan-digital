<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'   => ['bail', 'required', 'string', 'min:3', 'max:150'],
            'penulis' => ['bail', 'required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
        ];
    }

    public function messages(): array
    {
        $tahun = date('Y');

        return [
            'required' => ':attribute wajib diisi.',

            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',

            'judul.string' => 'Judul buku harus berupa teks.',
            'judul.min'    => 'Judul buku minimal :min karakter',
            'judul.max'    => 'Judul buku maksimal :max karakter.',

            'penulis.string' => 'Penulis harus berupa teks.',
            'penulis.min'    => 'Penulis minimal :min karakter.',
            'penulis.max'    => 'Penulis maksimal :max karakter.',

            'tahun_terbit.integer' => 'Tahun terbit harus berupa bilangan bulat.',
            'tahun_terbit.min'     => "Tahun terbit harus antara 1900 sampai $tahun",
            'tahun_terbit.max'     => "Tahun terbit harus antara 1900 sampai $tahun",
        ];
    }

    public function attributes(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'judul'        => 'judul',
            'penulis'      => 'penulis',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}