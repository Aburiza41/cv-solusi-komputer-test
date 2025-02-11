<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Harian</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 align="center">Laporan Transaksi Harian</h2>
    <p><strong>Tanggal:</strong> {{ $tanggal }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Tanggal</th>
                <th>Dinas</th>
                <th>Kode Dinas</th>
                <th>Kegiatan</th>
                <th>Kode Kegiatan</th>
                <th>Akun</th>
                <th>Kode Akun</th>
                <th>Nilai</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $key => $trx)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $trx->nomor_trx }}</td>
                    <td>{{ date('d-m-Y H:i', strtotime($trx->created_at)) }}</td>
                    <td>{{
                        // Ambil nama dinas berdasarkan kode dinas
                        $dinas->where('kode', $trx->dinas)->first()->nama
                        }}</td>
                    <td>{{ str_pad($trx->dinas, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{
                        // Ambil nama kegiatan berdasarkan kode kegiatan
                        $kegiatan->where('kode', $trx->kegiatan)->first()->nama
                    }}</td>
                    <td>{{ str_pad($trx->kegiatan, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{
                        // Ambil nama akun berdasarkan kode akun
                        $akun->where('kode', $trx->akun)->first()->nama
                    }}</td>
                    <td>{{ $trx->akun }}</td>
                    <td>Rp {{ $trx->nilai }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
