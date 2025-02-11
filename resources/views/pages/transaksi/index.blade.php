<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Transaksi Utama') }}
                </h2>
            </div>
            <div>
                <a href="{{ route('transaksi.create') }}" class="text-indigo-600 hover:text-indigo-900">Tambah</a>
                <a href="{{ route('transaksi.download') }}" target="_blank"
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-300">
                    Cetak PDF
                </a>

            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Detail Transaksi</h3>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200 dark:bg-gray-700">
                                    <th class="border border-gray-300 px-4 py-2">Nomor</th>
                                    <th class="border border-gray-300 px-4 py-2">Dinas</th>
                                    <th class="border border-gray-300 px-4 py-2">Kegiatan</th>
                                    <th class="border border-gray-300 px-4 py-2">Akun</th>
                                    <th class="border border-gray-300 px-4 py-2">Nilai</th>
                                    <th class="border border-gray-300 px-4 py-2">Aksi</
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trx_detail as $t)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">{{ $t->nomor_trx }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{
                                            // Ambil nama dinas berdasarkan kode dinas
                                            $dinas->where('kode', $t->dinas)->first()->nama

                                        }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{
                                            // Ambil nama kegiatan berdasarkan kode kegiatan
                                            $kegiatan->where('kode', $t->kegiatan)->first()->nama
                                            }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{
                                            // Ambil nama akun berdasarkan kode akun
                                            $akun->where('kode', $t->akun)->first()->nama
                                        }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-right">Rp. {{ $t->nilai }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-right">
                                            {{-- Detail  --}}
                                            {{-- <a href="{{ route('master.akun.show', $item->kode) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a> --}}
                                            {{-- Ubah --}}
                                            <a href="{{ route('transaksi.edit', $t->nomor_trx) }}" class="text-indigo-600 hover:text-indigo-900">Ubah</a>
                                            {{-- Hapus --}}
                                            <form action="{{ route('transaksi.destroy', $t->nomor_trx) }}" method="post" class="inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        {{-- <div class="mt-4">
                            {{ $transaksi->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
