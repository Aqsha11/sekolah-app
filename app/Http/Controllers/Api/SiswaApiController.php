<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiswaApiController extends Controller
{
    protected function getAnakSiswa(Request $request)
    {
        $orangTua = OrangTua::where('email', $request->user()->email)->first();
        return $orangTua ? $orangTua->anakSiswa()->get() : collect();
    }

    /**
     * GET /api/v1/siswa
     */
    public function index(Request $request): JsonResponse
    {
        $siswas = $this->getAnakSiswa($request)->map(fn ($s) => [
            'id' => $s->id,
            'nama' => $s->nama,
            'nis' => $s->nis,
            'kelas' => $s->kelas,
            'rfid' => $s->rfid,
        ]);

        return response()->json([
            'success' => true,
            'data' => $siswas,
        ]);
    }
}
