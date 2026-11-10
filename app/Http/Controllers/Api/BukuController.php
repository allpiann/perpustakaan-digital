<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    private function rules(bool $partial = false): array
    {
        $rules = [
            'kategori_id'  => ['bail', 'required', 'exists:kategoris,id'],
            'judul'        => ['bail', 'required', 'string', 'min:3', 'max:150'],
            'penulis'      => ['bail', 'required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['bail', 'required', 'integer', 'min:1900', 'max:' . date('Y')],
        ];

        if ($partial) {
            foreach ($rules as $field => $rule) {
                $rules[$field] = array_merge(['sometimes'], $rule);
            }
        }

        return $rules;
    }

    private function messages(): array
    {
        $tahun = date('Y');

        return [
            'required'             => ':attribute wajib diisi.',
            'kategori_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'judul.string'         => 'Judul buku harus berupa teks.',
            'judul.min'            => 'Judul buku minimal :min karakter',
            'judul.max'            => 'Judul buku maksimal :max karakter.',
            'penulis.string'       => 'Penulis harus berupa teks.',
            'penulis.min'          => 'Penulis minimal :min karakter.',
            'penulis.max'          => 'Penulis maksimal :max karakter.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa bilangan bulat.',
            'tahun_terbit.min'     => "Tahun terbit harus antara 1900 sampai $tahun",
            'tahun_terbit.max'     => "Tahun terbit harus antara 1900 sampai $tahun",
        ];
    }

    private function attributes(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'judul'        => 'judul',
            'penulis'      => 'penulis',
            'tahun_terbit' => 'tahun terbit',
        ];
    }

    /** GET /api/buku */
    public function index(Request $request)
    {
        $bukus = Buku::with('kategori')
            ->withCount('peminjamans')
            ->when($request->filled('cari'), function ($q) use ($request) {
                $cari = $request->cari;
                $q->where(function ($q) use ($cari) {
                    $q->where('judul', 'like', "%{$cari}%")
                      ->orWhere('penulis', 'like', "%{$cari}%");
                });
            })
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori_id', $request->kategori))
            ->when($request->filled('tahun'), fn ($q) => $q->where('tahun_terbit', $request->tahun))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return BukuResource::collection($bukus)
            ->additional(['message' => 'Daftar buku berhasil diambil']);
    }

    /** POST /api/buku */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules(), $this->messages(), $this->attributes());

        $buku = Buku::create($data);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data'    => new BukuResource($buku->load('kategori')),
        ], 201);
    }

    /** GET /api/buku/{id} */
    public function show(string $id): JsonResponse
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        return response()->json(['data' => new BukuResource($buku)], 200);
    }

    /** PUT /api/buku/{id} */
    public function update(Request $request, string $id): JsonResponse
    {
        $buku = Buku::find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $data = $request->validate($this->rules(true), $this->messages(), $this->attributes());

        $buku->update($data);

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'data'    => new BukuResource($buku->fresh('kategori')),
        ], 200);
    }

    /** DELETE /api/buku/{id} */
    public function destroy(string $id): JsonResponse
    {
        $buku = Buku::find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        try {
            $buku->delete();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Buku tidak dapat dihapus karena masih memiliki data peminjaman',
            ], 409);
        }

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }
        public function kelola()
    {
        return view('buku.index');
    }
}