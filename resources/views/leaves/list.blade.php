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
                                        <th class="px-4 py-3">Tarikh Cuti</th>
                                        <th class="px-4 py-3">Staf</th>
                                        <th class="px-4 py-3">Jenis</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Foto</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($leaves as $leave)
                                        <tr class="text-gray-700">
                                            <td class="px-4 py-3 border">
                                                <div class="flex items-center text-sm">
                                                    <div>
                                                        <p class="font-semibold text-black">
                                                            {{ date('D d/m/Y', strtotime($leave->start)) }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 border">
                                                <p class="text-black">
                                                    {{ $leave->user->name }}
                                                </p>
                                            </td>
                                            <td class="px-4 py-3 text-sm border">{{ $leave->leave_type->name }}
                                            </td>
                                            <td class="px-4 py-3 text-xs border">
                                                @if ($leave->approved)
                                                    <span
                                                        class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                                        Lulus
                                                    </span>
                                                @else
                                                    @if ($leave->active)
                                                        <span
                                                            class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-sm">
                                                            Dalam Proses
                                                        </span>
                                                    @else
                                                        <span
                                                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-sm">
                                                            Dibatalkan
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-xs border justify-center">
                                                @if ($leave->attachment)
                                                    <a href="{{ asset('storage/' . $leave->attachment) }}"
                                                        target="_blank"><img
                                                            src="{{ asset('img/has-attachment.svg') }}"
                                                            class="h-7"></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $leaves->links() }}
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
