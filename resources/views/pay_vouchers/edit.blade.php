<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Baucer') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="container mx-auto p-6 font-mono">
                    <form action="/payment-vouchers/{{ $voucher->id }}/edit" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-col-2">
                            <x-form.input name="payee_name" label="Nama" value="{{ $voucher->payee_name }}"
                                class="mb-2" />
                            <x-form.input name="payee_phone" label="Telefon" value="{{ $voucher->payee_phone }}"
                                class="mb-2" />
                            <x-form.input name="payee_bank" label="Bank" value="{{ $voucher->payee_bank }}"
                                class="mb-2" />
                            <x-form.input name="payee_acc_no" label="No Akaun" value="{{ $voucher->payee_acc_no }}"
                                class="mb-2" />
                            <x-form.input name="due_date" label="Due Date" type="date"
                                value="{{ $voucher->due_date }}" class="mb-2" />
                            <x-form.input name="payment_method" label="Kaedah Pembayaran"
                                value="{{ $voucher->payment_method }}" class="mb-2" />
                            <x-form.input name="remarks" label="Remarks" value="{{ $voucher->remarks }}"
                                class="mb-2" />
                        </div>
                        <div class="flex mt-5">
                            <a href="/payment-vouchers/{{ $voucher->id }}" class="text-red-500">Kembali</a>
                            <x-button class="ml-auto">Kemaskini</x-button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
