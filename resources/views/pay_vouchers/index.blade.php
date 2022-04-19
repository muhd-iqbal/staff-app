<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('') }}
        </h2>
    </x-slot>
    <x-modalbox width='max-w-xl'>
        <!--Title-->
        <div class="flex justify-between items-center pb-3">
            <p class="text-2xl font-bold">Tambah Baucer</p>
        </div>
        <div class="pt-2 gap-2">
            <form action="/payment-vouchers/add" method="POST">
                @csrf
                <div class="grid grid-col-2">
                    <x-form.input name="payee_name" label="Nama" value="{{ old('payee_name') }}" class="mb-2"
                        tags="required" />
                    <x-form.input name="payee_phone" label="Telefon" value="{{ old('payee_phone') }}"
                        class="mb-2" tags="required" />
                    <x-form.input name="payee_bank" label="Bank" value="{{ old('payee_bank') }}"
                        class="mb-2" />
                    <x-form.input name="payee_acc_no" label="No Akaun" value="{{ old('payee_acc_no') }}"
                        class="mb-2" />
                    <x-form.input name="due_date" label="Due Date" type="date" value="{{ old('due_date') }}"
                        class="mb-2" />
                    <x-form.input name="payment_method" label="Kaedah Pembayaran" value="{{ old('payment_method') }}"
                        class="mb-2" />
                    <x-form.input name="remarks" label="Remarks" value="{{ old('remarks') }}"
                        class="mb-2" />
                </div>
                <div class="flex">
                    <x-button>Tambah</x-button>
                    <span class="modal-close ml-auto cursor-pointer">Batal</span>
                </div>
            </form>
        </div>
    </x-modalbox>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="container mx-auto p-6 font-mono">
                    <div class="flex">
                        <div class="text-xl">Senarai Payment Voucher</div>
                        <div class="ml-auto bg-yellow-500 p-2 px-4 rounded-md shadow-md hover:bg-yellow-300 cursor-pointer"
                            onclick="openModal()">Tambah</div>
                    </div>
                    <div class="table w-full">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr>
                                    <th class="border">ID</th>
                                    <th class="border">Penerima</th>
                                    <th class="border">Amaun(RM)</th>
                                    <th class="border">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vouchers as $voucher)
                                    <tr class="text-center">
                                        <td class="border">{{ pay_vo_num($voucher->id) }}</td>
                                        <td class="border">{{ $voucher->payee_name }}</td>
                                        <td class="border">{{ RM($voucher->total) }}</td>
                                        <td class="border">
                                            <a href="/payment-vouchers/{{ $voucher->id }}"
                                                class="bg-blue-500 p-1 px-2 text-white rounded-md hover:bg-blue-700">Lihat</a>
                                            <a href="/payment-vouchers/{{ $voucher->id }}/edit"
                                                class="bg-red-500 p-1 px-2 text-white rounded-md hover:bg-red-700">Edit</a>
                                        </td>
                                        <td class="p-0 w-min border font-bold">
                                            @if ($voucher->is_received)
                                                <span class="text-green-500">&#10004;</span>
                                            @elseif ($voucher->is_approved)
                                                <span class="text-yellow-500">&#10004;</span>
                                            @else
                                                <span class="text-red-500">&#10006;</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $vouchers->withQueryString()->links() }}
                    </div>
                    <div class="text-right">
                        <div class="text-green-500">&#10004; Payment Received</div>
                        <div class="text-yellow-500">&#10004; Approved</div>
                        <div class="text-red-500">&#10006; Not approved</div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <div class="text-center">
        <a href="/"
            class='w-auto text-center bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2 mt-3'>
            {{ __('Kembali') }}
        </a>
    </div>
</x-app-layout>
