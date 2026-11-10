<?php

namespace App\Http\Requests;

class UpdateBukuRequest extends StoreBukuRequest
{
    // Mewarisi authorize(), messages(), attributes() dari StoreBukuRequest.
    // Rule diambil dari parent lalu ditambah 'sometimes' agar update sebagian
    // (hanya kirim judul) tetap valid -> 200.
    public function rules(): array
    {
        $rules = [];

        foreach (parent::rules() as $field => $rule) {
            $rules[$field] = array_merge(['sometimes'], $rule);
        }

        return $rules;
    }
}