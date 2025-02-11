<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data dari 3 tabel akun 1,2,3
        $akun1 = DB::table('akun_1')->get();
        $akun2 = DB::table('akun_2')->get();
        $akun3 = DB::table('akun_3')->get();

        // Gabungkan data dari 3 tabel
        $akun = $akun1->merge($akun2)->merge($akun3);
        // $akun = $akun1->union($akun2)->union($akun3)->paginate(5);

        // ubah menjadi paginate
        // $akun = $akun->paginate(5);

        return view('pages.akun.index', compact('akun'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.akun.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debugging
        // dd($request->all());

        // Validasi data input
        $validator = Validator::make($request->all(), [
            'kode' => 'required|numeric|min:1',
            'nama' => 'required|string|max:255',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Hitung panjang kode
            $kodeLength = strlen(strval($request->kode));

            // Switch case untuk menentukan tabel
            switch ($kodeLength) {
                case 1:
                    $table = 'akun_1';
                    break;
                case 2:
                    $table = 'akun_2';
                    break;
                case 4:
                    $table = 'akun_3';
                    break;
                default:
                    return redirect()->back()->with('error', 'Kode Salah!')->withInput();
            }

            // Simpan data ke database
            DB::table($table)->insert([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan!')->withInput();
        }

        return redirect()->route('master.akun.index')->with('success', 'Data berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kodeLength = strlen(strval($id));

            // Switch case untuk menentukan tabel
            switch ($kodeLength) {
                case 1:
                    $table = 'akun_1';
                    break;
                case 2:
                    $table = 'akun_2';
                    break;
                case 4:
                    $table = 'akun_3';
                    break;
                default:
                    return redirect()->back()->with('error', 'Kode Salah!')->withInput();
            }

        $akun = DB::table($table)->where('kode', $id)->first();
        if (!$akun) {
            return redirect()->route('master.akun.index')->with('error', 'Data tidak ditemukan!');
        }

        return view('pages.akun.edit', compact('akun'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data
        $kodeLength = strlen(strval($id));

            // Switch case untuk menentukan tabel
            switch ($kodeLength) {
                case 1:
                    $table = 'akun_1';
                    break;
                case 2:
                    $table = 'akun_2';
                    break;
                case 4:
                    $table = 'akun_3';
                    break;
                default:
                    return redirect()->back()->with('error', 'Kode Salah!')->withInput();
            }

        DB::table($table)->where('kode', $id)->update([
            'nama' => $request->nama,
            'updated_at' => now(),
        ]);

        return redirect()->route('master.akun.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kodeLength = strlen(strval($id));

            // Switch case untuk menentukan tabel
            switch ($kodeLength) {
                case 1:
                    $table = 'akun_1';
                    break;
                case 2:
                    $table = 'akun_2';
                    break;
                case 4:
                    $table = 'akun_3';
                    break;
                default:
                    return redirect()->back()->with('error', 'Kode Salah!')->withInput();
            }
        DB::table($table)->where('kode', $id)->delete();

        return redirect()->route('master.akun.index')->with('success', 'Data berhasil dihapus!');
    }
}

