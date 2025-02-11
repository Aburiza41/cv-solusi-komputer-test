<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Transaksi Ubah') }}
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
                    <form method="POST" action="{{ route('transaksi.update', $trx_detail->nomor_trx) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            {{-- Input Nomor Transaksi (Readonly) --}}
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nomor Transaksi</label>
                            <input type="text" name="nomor_transaksi" value="{{ $trx_detail->nomor_trx }}"
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
                                    <option value="{{ $d->kode }}" {{ $trx_detail->dinas == $d->kode ? 'selected' : '' }}>
                                        {{ $d->nama }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Input Kegiatan Select --}}
                            <label class="block mt-4 font-medium text-sm text-gray-700 dark:text-gray-300">Kegiatan</label>
                            <select name="kegiatan_id"
                                class="w-full px-4 py-2 rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-300 dark:bg-gray-900" required>
                                <option value="">Pilih Kegiatan</option>
                                @foreach($kegiatan as $k)
                                    <option value="{{ $k->kode }}" {{ $trx_detail->kegiatan == $k->kode ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Input Akun Select --}}
                            <label class="block mt-4 font-medium text-sm text-gray-700 dark:text-gray-300">Akun</label>
                            <select name="akun_id"
                                class="w-full px-4 py-2 rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-300 dark:bg-gray-900" required>
                                <option value="">Pilih Akun</option>
                                @foreach($akun as $a)
                                    <option value="{{ $a->kode }}" {{ $trx_detail->akun == $a->kode ? 'selected' : '' }}>
                                        {{ $a->nama }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Input Nilai --}}
                            <label class="block mt-4 font-medium text-sm text-gray-700 dark:text-gray-300">Nilai</label>
                            <input type="text" name="nilai" value="{{ $trx_detail->nilai }}"
                                class="w-full px-4 py-2 rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-300 dark:bg-gray-900" required>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-300">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
