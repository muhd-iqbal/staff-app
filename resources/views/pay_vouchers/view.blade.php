<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Voucher: ') }}
        </h2>
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }

                #section-to-print,
                #section-to-print * {
                    visibility: visible;
                }

                #section-to-print {
                    position: absolute;
                    left: 0;
                    top: 0;
                }

                .noprint {
                    visibility: hidden;
                    display: none;
                }
            }
        </style>
    </x-slot>

    <x-modalbox width='max-w-xl'>
        <!--Title-->
        <div class="flex justify-between items-center pb-3">
            <p class="text-2xl font-bold text-black">Tambah Item</p>
        </div>
        <div class="pt-2 gap-2">
            @if ($voucher->is_approved)
                <span>Baucer telah di approve. Tambah item?</span>
            @endif
            <form action="/payment-vouchers/{{ $voucher->id }}/add" method="POST">
                @csrf
                <div class="grid grid-col-2">
                    <x-form.input name="title" label="Detail" value="{{ old('name') }}" class="mb-2" />
                    <x-form.input name="amount" label="Amaun" value="{{ old('amount') }}" class="mb-2" />
                </div>
                <div class="flex">
                    <x-button>Tambah</x-button>
                    <span class="modal-close ml-auto cursor-pointer">Batal</span>
                </div>
            </form>
        </div>
    </x-modalbox>

    <div class="w-full py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (auth()->user()->isAdmin)
                <div class="flex flex-row-reverse gap-3 mb-3">
                    <form action="/payment-vouchers/{{ $voucher->id }}/paid" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            onclick="return confirm('Tanda dibayar: Baucer {{ pay_vo_num($voucher->id) }}? \n Baucer dibayar tidak boleh diubah!')"
                            class='w-auto text-center bg-black hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2 mt-3'>
                            {{ __('Tanda Dibayar') }}
                        </button>
                    </form>
                    <form action="/payment-vouchers/{{ $voucher->id }}/approve" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            onclick="return confirm('Approve payment voucher {{ pay_vo_num($voucher->id) }}')"
                            class='w-auto text-center bg-green-600 hover:bg-green-900 rounded-lg shadow-xl font-medium text-white px-4 py-2 mt-3'>
                            {{ __('Approve') }}
                        </button>
                    </form>
                </div>
            @endif
            <div id="section-to-print" class="bg-white overflow-hidden sm:rounded-lg">
                <div class="p-6 bg-white">
                    <div class="text-center">
                        <div class="font-bold text-base text-gray-500 text-right">{{ __('PAYMENT VOUCHER') }}</div>
                        <div class="text-2xl uppercase font-bold">{{ $branch->name }}</div>
                        <div class="text-lg">{{ $branch->address }}</div>
                        <div class="text-lg">Contact: {{ phone_format($branch->phone_1) }} /
                            admin@inspirazs.com.my</div>
                        {{-- <div class="text-lg">Phone:0199290219 Emel: 2sdmfnsd@kskfd.cppo</div> --}}
                    </div>
                    <div class="grid grid-cols-3 w-full mt-5">
                        <div class="col-span-2 grid grid-cols-4">
                            <div class="col-span-1">Payee Name:</div>
                            <div class="border col-span-3 mr-5 px-2">{{ $voucher->payee_name }}</div>
                            <div class="col-span-1">Phone No:</div>
                            <div class="border col-span-3 mr-5 px-2">{{ phone_format($voucher->payee_phone) }}</div>
                            <div class="col-span-1">Bank Name:</div>
                            <div class="border col-span-3 mr-5 px-2">{{ $voucher->payee_bank }}</div>
                            <div class="col-span-1">Account No:</div>
                            <div class="border col-span-3 mr-5 px-2">{{ $voucher->payee_acc_no }}</div>
                        </div>
                        <div class="col-span-1 grid grid-cols-3">
                            <div class="col-span-1">PV No:</div>
                            <div class="border col-span-2 px-2">{{ pay_vo_num($voucher->id) }}</div>
                            <div class="col-span-1">Due Date:</div>
                            <div class="border col-span-2 px-2">
                                {{ $voucher->due_date ? date('d/m/Y', strtotime($voucher->due_date)) : '' }}
                            </div>
                            <div class="col-span-1">Payment Method:</div>
                            <div class="border col-span-2 px-2">{{ $voucher->payment_method }}</div>
                            <div class="col-span-1">&nbsp;</div>
                        </div>
                    </div>
                    <div class="table w-full mt-5">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border w-1/12">No</th>
                                    <th class="border">Payment Details</th>
                                    <th class="border w-1/6 text-right">Amount (RM)</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-right border bg-gray-200">Total (RM)</th>
                                    <th class="text-right border">{{ RM($voucher->total) }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($voucher_lists as $list)
                                    <tr>
                                        <td class="border text-center">{{ $loop->iteration }}</td>
                                        <td class="border px-2 flex gap-5">
                                            {{ $list->title }}
                                            <form action="/payment-vouchers/{{ $voucher->id }}/{{ $list->id }}"
                                                method="POST" class="noprint">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500"
                                                    onclick="return confirm('Padam {{ $list->title }}?')">x</button>
                                            </form>
                                        </td>
                                        <td class="border text-right">{{ RM($list->amount) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        <div class="font-bold">{{ __('Remarks') }}</div>
                        <div class="border-2">&nbsp;{{ $voucher->remarks }}</div>
                    </div>

                    <div class="grid grid-cols-3 gap-5 mt-5">
                        <div>
                            <div>Requested By</div>
                            <div class="w-full border-b-2 mt-5">&nbsp;</div>
                            <div class="">{{ $prepared_by->name }}</div>
                            <div class="">IC No: {{ ic_format($prepared_by->icno) }}</div>
                            <div class="">Date: {{ date('d/m/Y', strtotime($voucher->prepared_date)) }}
                            </div>
                        </div>
                        <div>
                            <div>Approved By</div>
                            <div class="w-full border-b-2 mt-5">&nbsp;</div>
                            <div class="">{{ $approved_by ? $approved_by->name : '' }}</div>
                            <div class="">
                                {{ $approved_by ? 'IC No: ' . ic_format($approved_by->icno) : '' }}</div>
                            <div class="">
                                {{ $voucher->approved_date ? 'Date: ' . date('d/m/Y', strtotime($voucher->approved_date)) : '' }}
                            </div>
                        </div>
                        <div>
                            <div>Received By</div>
                            <div class="w-full border-b-2 mt-5">&nbsp;</div>
                            <div class="">{{ $voucher->payee_name }}</div>
                            <div class="">IC: </div>
                            <div class="">Date:
                                {{ $voucher->received_date ? date('d/m/Y', strtotime($voucher->received_date)) : '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="/payment-vouchers"
                    class='w-auto text-center bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2 mt-3'>
                    {{ __('Kembali') }}
                </a>
                <a href="/payment-vouchers/{{ $voucher->id }}/edit"
                    class='w-auto text-center bg-yellow-500 hover:bg-yellow-700 rounded-lg shadow-xl font-medium text-white px-4 py-2 mt-3'>
                    {{ __('Edit') }}
                </a>
                <div class="ml-auto">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <button onclick="openModal()"
                        class="bg-green-400 p-2 rounded-md px-4 font-bold mt-3 text-white hover:bg-green-600">Tambah
                        Item</button>
                    <button onclick="print()"
                        class="bg-blue-400 p-2 rounded-md px-4 font-bold mt-3 text-white hover:bg-blue-600">Cetak</button>
                </div>
            </div>
            <div class="mt-3">
                @if ($voucher->attachment)
                     <img src="{{ asset('storage/' . $voucher->attachment) }}" alt=""
                        class="w-full p-2 border">
                @endif
                <form action="/payment-vouchers/{{ $voucher->id }}/img" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="attachment" id="attachment" required>
                    <button type="submit"
                        class="px-2 py-1 bg-yellow-400 rounded-md shadow-md hover:bg-yellow-500"
                        @if($voucher->attachment) onclick="return confirm('Lampiran telah dimuat naik. Ganti baru?')" @endif
                        >Submit</button>
                </form>
                <small class="text-red-500">Satu lampiran sahaja.</small>
            </div>

        </div>
    </div>

</x-app-layout>
