<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Permohonan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr
                                        class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                        <th class="px-4 py-3">Bil</th>
                                        <th class="px-4 py-3">Nama</th>
                                        <th class="px-4 py-3">Baki / Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($staff as $list)
                                        <tr class="text-gray-700 hover:bg-gray-300"
                                            onclick="location.href='/staff/show/{{ $list->id }}'" role="button">
                                            <td class="px-4 py-3 border">
                                                <div class="flex items-center text-sm">
                                                    <div>
                                                        <p class="font-semibold text-black">
                                                            {{ $loop->iteration }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 border">
                                                <div class="flex items-center text-sm">
                                                    <div>
                                                        <p class="font-semibold text-black">
                                                            {{ $list->name }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 border">
                                                <p class="text-black">
                                                    @if ($list->annual_leave)
                                                        {{ $list->annual_leave - $list->leave->count() }} /
                                                        {{ $list->annual_leave }}
                                                    @endif
                                                </p>
                                            </td>
                                            {{-- <td class="px-4 py-3 text-sm border">{{ $list->leave_type->name }} --}}
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <a href="/top/leave-types" class="bg-green-500 p-2 px-4 rounded-md text-white">Jenis Cuti</a>
                    <a href="/top/leave-staff" class="bg-green-500 p-2 px-4 rounded-md text-white">Baki Cuti Staf</a>
                    <x-dashboard-link />
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
