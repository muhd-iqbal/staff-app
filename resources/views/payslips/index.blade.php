<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Slip Gaji') . ' ' . auth()->user()->name }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="container mx-auto p-6 font-mono">
                    <div class="grid grid-cols-2 md:grid-cols-4">
                        @foreach ($payslips as $payslip)
                            <div>
                                <a class="underline text-blue-600" href="{{ asset('storage/'.$payslip->file) }}" target="_blank">{{ month_name($payslip->month) . ' ' . $payslip->year}}</a>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
            <x-dashboard-link />
        </div>
    </div>
</x-app-layout>
