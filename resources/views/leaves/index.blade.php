<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Permohonan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- component -->
                    <div class="flex justify-center items-center">
                        <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <div
                                class="w-full bg-gray-900 rounded-lg sahdow-lg p-6 flex flex-col justify-center items-center">
                                <div class="mb-4">
                                    <p class="text-white text-5xl font-bold">{{ $user->annual_leave }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-xl text-white font-bold mb-2">Cuti Tahunan</p>
                                </div>
                            </div>
                            <div
                                class="w-full bg-gray-900 rounded-lg sahdow-lg p-6 flex flex-col justify-center items-center">
                                <div class="mb-4">
                                    <p class="text-white text-5xl font-bold">{{ $user->annual_leave-$leaves_cnt }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-xl text-white font-bold mb-2">Baki Cuti Tahunan</p>
                                </div>
                            </div>
                            <a href="leaves/create/"
                                class="w-full bg-gray-900 rounded-lg sahdow-lg p-6 flex flex-col justify-center items-center">
                                <p class="text-white text-5xl font-bold">
                                    <svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </p>
                            </a>
                        </div>
                    </div>
                    <section class="container mx-auto p-6 font-mono">
                        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr
                                            class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                            <th class="px-4 py-3">Tarikh Cuti</th>
                                            <th class="px-4 py-3">Perihal</th>
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
                                                        {{ $leave->detail }}
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
                                                        <a href="{{ asset('storage/'.$leave->attachment) }}" target="_blank"><img src="{{ asset('img/has-attachment.svg') }}" class="h-7"></a>
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
                    <x-dashboard-link />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
