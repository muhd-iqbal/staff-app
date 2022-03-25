<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Subcon / Supplier ')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="container mx-auto p-6 font-mono">
                        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Telefon</th>
                                        <th>Emel</th>
                                    </tr>
                                    @foreach ($suppliers as $sub)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sub->name }}</td>
                                            <td>{{ $sub->phone }}</td>
                                            <td>{{ $sub->email }}</td>
                                            <td><a href="/suppliers/{{ $sub->id }}/update">Edit</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        {{ $suppliers->withQueryString()->links() }}
                    </section>
                    <div class="text-center mb-5">
                        {{-- @if (request('back'))
                        <a href="{{ request('back') }}"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2 mr-2'>
                            Kembali ke order
                        </a>
                        @endif --}}
                        <a href="/"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            Ke halaman utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
