<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class OrangTuaController extends Controller
{

    /**
     * Daftar semua orang tua
     */
    public function index(): View
    {
        $orangTuas = OrangTua::orderBy('nama')
            ->paginate(20);

        return view('admin.orang_tua.index', compact('orangTuas'));
    }



    /**
     * Form tambah akun orang tua
     */
    public function create(): View
    {
        $siswas = Siswa::orderBy('nama')->get();

        return view('admin.orang_tua.create', compact('siswas'));
    }




    /**
     * Simpan akun orang tua
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([

            'nama' => [
                'required',
                'string',
                'max:255'
            ],


            'email' => [
                'required',
                'email',
                'unique:orang_tua,email'
            ],


            'password' => [
                'required',
                'min:6'
            ],


            'phone' => [
                'nullable'
            ],


            'siswa_ids' => [
                'nullable',
                'array'
            ],


            'siswa_ids.*' => [
                'exists:siswas,id'
            ],

        ]);



        // simpan tabel orang_tua
        $orangTua = OrangTua::create([

            'nama' => $request->nama,

            'email' => $request->email,

            'phone' => $request->phone,

        ]);




        // buat akun login users
        $user = User::create([

            'name' => $request->nama,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'is_active' => true,

        ]);




        // kalau role tersedia
        if (method_exists($user, 'assignRole')) {

            $user->assignRole('orang_tua');

        }




        // hubungan anak
        $orangTua->anakSiswa()
            ->sync($request->siswa_ids ?? []);




        return redirect()
            ->route('admin.orang_tua.index')
            ->with(
                'success',
                'Akun orang tua berhasil dibuat'
            );

    }






    /**
     * Form atur anak
     */
    public function edit(OrangTua $orangTua): View
    {

        $siswas = Siswa::orderBy('nama')->get();


        $terpilih = $orangTua
            ->anakSiswa()
            ->pluck('siswa_id')
            ->toArray();



        return view(
            'admin.orang_tua.edit',
            compact(
                'orangTua',
                'siswas',
                'terpilih'
            )
        );

    }





    /**
     * Update relasi anak
     */
    public function update(
        Request $request,
        OrangTua $orangTua
    ): RedirectResponse
    {


        $request->validate([

            'siswa_ids'=>'nullable|array',

            'siswa_ids.*'=>'exists:siswas,id'

        ]);



        $orangTua
            ->anakSiswa()
            ->sync(
                $request->siswa_ids ?? []
            );



        return redirect()
            ->route('admin.orang_tua.index')
            ->with(
                'success',
                'Relasi anak berhasil diperbarui'
            );

    }

}