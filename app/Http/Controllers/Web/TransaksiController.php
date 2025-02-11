<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
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

        // Ambil data dinas
        $dinas = DB::table('dinas')->get();

        // Ambil Data Kegiatan
        $kegiatan = DB::table('kegiatan')->get();
        // Gabungkan data dari 3 tabel

        // Trx Detail
        $trx_detail = DB::table('trx_detail')->get();

        return view('pages.transaksi.index', compact('akun', 'dinas', 'kegiatan', 'trx_detail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data dari 3 tabel akun 1,2,3
        $akun1 = DB::table('akun_1')->get();
        $akun2 = DB::table('akun_2')->get();
        $akun3 = DB::table('akun_3')->get();

        // Gabungkan data dari 3 tabel
        $akun = $akun1->merge($akun2)->merge($akun3);

        // Ambil data dinas
        $dinas = DB::table('dinas')->get();

        // Ambil Data Kegiatan
        $kegiatan = DB::table('kegiatan')->get();
        // Gabungkan data dari 3 tabel

        // Trx Detail
        $trx_detail = DB::table('trx_detail')->get();

        return view('pages.transaksi.create', compact('akun', 'dinas', 'kegiatan', 'trx_detail'));
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
            'nomor_transaksi' => 'required',
            'tanggal' => 'required',
            'dinas_id' => 'required',
            'kegiatan_id' => 'required',
            'akun_id' => 'required',
            'nilai' => ['required'], // Format uang
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            // Cari trx_header berdasarkan nomor_transaksi
            $trx_header = DB::table('trx_header')->where('nomor_trx', $request->nomor_transaksi)->first();
            // Jika trx_header sudah ada Tambahkan total ditambahkan dengan nilai baru
            if ($trx_header) {
                DB::table('trx_header')->where('nomor_trx', $request->nomor_transaksi)->update([
                    'total' => $trx_header->total + $request->nilai,
                    'updated_at' => now(),
                ]);
            } else { // Jika trx_header belum ada
                DB::table('trx_header')->insert([
                    'nomor_trx' => $request->nomor_transaksi,
                    'tanggal' => $request->tanggal,
                    'dinas' => $request->dinas_id,
                    'total' => $request->nilai,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Simpan data ke database
            DB::table('trx_detail')->insert([
                'nomor_trx' => $request->nomor_transaksi,
                'dinas' => $request->dinas_id,
                'akun' => $request->akun_id,
                'nilai' => $request->nilai,
                'kegiatan' => $request->kegiatan_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error', 'Terjadi kesalahan!')->withInput();
        }

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Debugging
        // dd($id);

        $trx_detail = DB::table('trx_detail')->where('nomor_trx', $id)->first();
        if (!$trx_detail) {
            return redirect()->route('transaksi.index')->with('error', 'Data tidak ditemukan!');
        }

        // Ambil data dari 3 tabel akun 1,2,3
        $akun1 = DB::table('akun_1')->get();
        $akun2 = DB::table('akun_2')->get();
        $akun3 = DB::table('akun_3')->get();

        // Gabungkan data dari 3 tabel
        $akun = $akun1->merge($akun2)->merge($akun3);

        // Ambil data dinas
        $dinas = DB::table('dinas')->get();

        // Ambil Data Kegiatan
        $kegiatan = DB::table('kegiatan')->get();
        // Gabungkan data dari 3 tabel

        // Trx Detail
        // $trx_detail = DB::table('trx_detail')->find($id);

        return view('pages.transaksi.edit', compact('akun', 'dinas', 'kegiatan', 'trx_detail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'nomor_transaksi' => 'required',
            'tanggal' => 'required',
            'dinas_id' => 'required',
            'kegiatan_id' => 'required',
            'akun_id' => 'required',
            'nilai' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Cari transaksi detail berdasarkan ID
            $trx_detail = DB::table('trx_detail')->where('nomor_trx', $id)->first();

            if (!$trx_detail) {
                return redirect()->back()->with('error', 'Data transaksi tidak ditemukan!');
            }

            // Ambil trx_header
            $trx_header = DB::table('trx_header')->where('nomor_trx', $request->nomor_transaksi)->first();

            if (!$trx_header) {
                return redirect()->back()->with('error', 'Header transaksi tidak ditemukan!');
            }

            // Konversi nilai agar bisa disimpan ke database
            $nilai_baru = str_replace('.', '', $request->nilai);
            $nilai_lama = str_replace('.', '', $trx_detail->nilai);

            // Update total di trx_header
            DB::table('trx_header')->where('nomor_trx', $request->nomor_transaksi)->update([
                'total' => number_format($trx_header->total - $nilai_lama + $nilai_baru, 0, ',', '.'),
                'tanggal' => $request->tanggal,
                'updated_at' => now(),
            ]);

            // Update transaksi detail
            DB::table('trx_detail')->where('nomor_trx', $id)->update([
                'dinas' => $request->dinas_id,
                'akun' => $request->akun_id,
                'nilai' => $nilai_baru,
                'kegiatan' => $request->kegiatan_id,
                'updated_at' => now(),
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error', 'Terjadi kesalahan!')->withInput();
        }

        return redirect()->route('transaksi.index')->with('success', 'Data berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Cari transaksi detail berdasarkan ID
            $trx_detail = DB::table('trx_detail')->where('nomor_trx', $id)->first();

            if (!$trx_detail) {
                return redirect()->back()->with('error', 'Data transaksi tidak ditemukan!');
            }

            // Ambil trx_header berdasarkan nomor transaksi
            $trx_header = DB::table('trx_header')->where('nomor_trx', $trx_detail->nomor_trx)->first();

            if (!$trx_header) {
                return redirect()->back()->with('error', 'Header transaksi tidak ditemukan!');
            }

            // Update total di trx_header dengan mengurangi nilai transaksi yang dihapus
            DB::table('trx_header')->where('nomor_trx', $trx_detail->nomor_trx)->update([
                'total' => $trx_header->total - $trx_detail->nilai,
                'updated_at' => now(),
            ]);

            // Hapus transaksi detail
            DB::table('trx_detail')->where('nomor_trx', $id)->delete();

            // Cek apakah masih ada transaksi lain dalam `trx_detail` dengan nomor transaksi ini
            $remaining = DB::table('trx_detail')->where('nomor_trx', $trx_detail->nomor_trx)->count();

            // Jika tidak ada transaksi lain, hapus juga `trx_header`
            if ($remaining === 0) {
                DB::table('trx_header')->where('nomor_trx', $trx_detail->nomor_trx)->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus transaksi!');
        }

        return redirect()->route('transaksi.index')->with('success', 'Data berhasil dihapus!');
    }

    // Download
    public function cetakPDF()
    {
        // Ambil data transaksi untuk tanggal hari ini
        $tanggal = now()->toDateString();
        $transaksi = DB::table('trx_detail')
            ->whereDate('created_at', $tanggal)
            ->get();

        // Jika tidak ada transaksi
        if ($transaksi->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada transaksi untuk dicetak.');
        }

        // Ambil data dari 3 tabel akun 1,2,3
        $akun1 = DB::table('akun_1')->get();
        $akun2 = DB::table('akun_2')->get();
        $akun3 = DB::table('akun_3')->get();

        // Gabungkan data dari 3 tabel
        $akun = $akun1->merge($akun2)->merge($akun3);

        // Ambil data dinas
        $dinas = DB::table('dinas')->get();

        // Ambil Data Kegiatan
        $kegiatan = DB::table('kegiatan')->get();

        // Load view PDF
        $pdf = Pdf::loadView('pdf.transaksi_harian', compact('transaksi', 'tanggal', 'akun', 'dinas', 'kegiatan'));

        // Download atau tampilkan PDF
        return $pdf->stream('Laporan_Transaksi_Harian_' . $tanggal . '.pdf');
    }
}
