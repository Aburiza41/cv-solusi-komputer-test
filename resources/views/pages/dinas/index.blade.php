<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dinas Utama') }}
                </h2>
            </div>
            <div>
                <a href="{{ route('master.dinas.create') }}" class="text-indigo-600 hover:text-indigo-900">Tambah</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Looping Data --}}
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nama Dinas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Kode Dinas
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($dinas as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ str_pad($item->kode, 3, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- Detail  --}}
                                        {{-- <a href="{{ route('master.dinas.show', $item->kode) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a> --}}
                                        {{-- Ubah --}}
                                        <a href="{{ route('master.dinas.edit', $item->kode) }}" class="text-indigo-600 hover:text-indigo-900">Ubah</a>
                                        {{-- Hapus --}}
                                        <form action="{{ route('master.dinas.destroy', $item->kode) }}" method="post" class="inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        {{-- Link --}}
                        <div class="mt-4">
                            {{ $dinas->links() }}
                            </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
