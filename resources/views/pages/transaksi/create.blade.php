<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Transaksi Tambah') }}
                </h2>
            </div>
            <div>
                <a href="{{ route('transaksi.index') }}" class="text-indigo-600 hover:text-indigo-900">Kembali</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Formulir --}}
                    <form method="POST" action="{{ route('transaksi.store') }}">
                        @csrf
                        <div class="mb-4">
                            {{-- Input Nomor Transaksi (Auto-Generated) --}}
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nomor Transaksi</label>
                            <input type="text" name="nomor_transaksi" value="{{ 'TRX-' . now()->format('YmdHis') }}"
                                class="w-full px-4 py-2 rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-300 dark:bg-gray-900" readonly>

                            {{-- Input Tanggal Transaksi --}}
                            <label class="block mt-4 font-medium text-sm text-gray-700 dark:text-gray-300">Tanggal Transaksi</label>
                            <input type="date" name="tanggal"
                                class="w-full px-4 py-2 rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-300 dark:bg-gray-900" required>

                            {{-- Input Dinas Select --}}
                            <label class="block mt-4 font-medium text-sm text-gray-700 dark:text-gray-300">Dinas</label>
                            <select name="dinas_id"
                                class="w-full px-4 py-2 rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-300 dark:bg-gray-900" required>
                                <option value="">Pilih Dinas</option>
                                @foreach($dinas as $d)
                                    <option value="{{ $d->kode }}">{{ $d->nama }}</option>
                                @endforeach
                            </select>

                            {{-- Input Kegiatan Select --}}
                            <label class="block mt-4 font-medium text-sm text-gray-700 dark:text-gray-300">Kegiatan</label>
                            <select name="kegiatan_id"
                                class="w-full px-4 py-2 rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-300 dark:bg-gray-900" required>
                                <option value="">Pilih Kegiatan</option>
                                @foreach($kegiatan as $k)
                                    <option value="{{ $k->kode }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>

                            {{-- Input Akun Select --}}
                            <label class="block mt-4 font-medium text-sm text-gray-700 dark:text-gray-300">Akun</label>
                            <select name="akun_id"
                                class="w-full px-4 py-2 rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-300 dark:bg-gray-900" required>
                                <option value="">Pilih Akun</option>
                                @foreach($akun as $a)
                                    <option value="{{ $a->kode }}">{{ $a->nama }}</option>
                                @endforeach
                            </select>

                            {{-- Input Nilai --}}
                            <label class="block mt-4 font-medium text-sm text-gray-700 dark:text-gray-300">Nilai</label>
                            <input type="text" name="nilai" placeholder="1.000.000"
                                class="w-full px-4 py-2 rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-300 dark:bg-gray-900" required>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-300">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Looping Detail Transaksi --}}
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
