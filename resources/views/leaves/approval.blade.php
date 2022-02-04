<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Permohonan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-4 py-12">
                <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-10">
                    @if (count($leaves))
                        @foreach ($leaves as $leave)
                            <x-leave-card :leave="$leave" />
                        @endforeach
                    @else
                        Tiada Permohonan Cuti.
                    @endif
                </div>
            </section>
            <div class="text-center">
                <a href="/leaves/list" class="bg-blue-500 text-white p-2 px-4 rounded-md hover:bg-blue-700">Ke Senarai
                    Cuti</a>
                <x-dashboard-link />
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
