<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kegiatan = DB::table('kegiatan')->paginate(5);

        return view('pages.kegiatan.index', compact('kegiatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kegiatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debuggingi
        // dd($request->all());

        // Validasi data input
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:kegiatan,kode',
            'nama' => 'required|string|max:255',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Insert data ke database
        DB::table('kegiatan')->insert([
            'kode' => number_format((float) $request->kode, 0, '.', ''), // Konversi ke Decimal(3,0)
            'nama' => $request->nama,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with('error', 'Kode Salah!')->withInput();
        }

        return redirect()->route('master.kegiatan.index')->with('success', 'Data berhasil ditambahkan!');
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
        $kegiatan = DB::table('kegiatan')->where('kode', $id)->first();
        if (!$kegiatan) {
            return redirect()->route('kegiatan.index')->with('error', 'Data tidak ditemukan!');
        }

        return view('pages.kegiatan.edit', compact('kegiatan'));
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
        DB::table('kegiatan')->where('kode', $id)->update([
            'nama' => $request->nama,
            'updated_at' => now(),
        ]);

        return redirect()->route('master.kegiatan.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('kegiatan')->where('kode', $id)->delete();

        return redirect()->route('master.kegiatan.index')->with('success', 'Data berhasil dihapus!');
    }
}
