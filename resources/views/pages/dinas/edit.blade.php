<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Ubah Dinas') }}
                </h2>
            </div>
            <div>
                <a href="{{ route('master.dinas.index') }}" class="text-indigo-600 hover:text-indigo-900">Kembali</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Formulir Ubah Dinas --}}
                    <form method="POST" action="{{ route('master.dinas.update', $dinas->kode) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="kode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Kode Dinas
                            </label>
                            <input type="number" name="kode" id="kode"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                value="{{ old('kode', $dinas->kode) }}" required readonly>
                            @error('kode')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nama Dinas
                            </label>
                            <input type="text" name="nama" id="nama"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                value="{{ old('nama', $dinas->nama) }}" required>
                            @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
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
