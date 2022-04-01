<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice: ' . $order->id) }}
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
            }

        </style>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="section-to-print" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-right">
                        <div class="font-bold text-xl">{{ __('INVOIS') }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div>
                            <x-application-logo class="block h-24 w-auto fill-current text-gray-600" />

                            <div class="mt-3">
                                {{ __('Kepada: ') }}
                            </div>
                            {{ $order->customer->company ? '<div>' . $order->customer->company . '</div>' : '' }}
                            <div>{{ $order->customer->company ? 'PIC: ' : '' . $order->customer->name }}</div>
                            <div>
                                {{ __('Telefon: ') . phone_format($order->customer->phone) }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="mt-5">{{ __('Bayar Kepada:') }}</div>
                            <div class="text-lg font-bold uppercase">{{ $order->branch->name }}</div>
                            <div class="text-base font-bold uppercase">{{ $order->branch->address }}</div>
                            <div class="mt-5">{{ __('No Akaun:') }}</div>
                            {{ $order->branch->bank_account_1 }}
                            {!! $order->branch->bank_account_2 ? '<br />' . $order->branch->bank_account_2 : '' !!}
                            {!! $order->branch->bank_account_3 ? '<br />' . $order->branch->bank_account_3 : '' !!}
                        </div>
                    </div>
                    <div class="border-b border-gray-600 pb-3">
                        <div class="grid grid-cols-2 mt-5">
                            <div class="font-bold">
                                {{ __('Order No: ') . order_num($order->id) }}
                            </div>
                            <div class="text-right">{{ __('Tarikh: ') . date('d/m/Y', strtotime($order->date)) }}
                            </div>
                        </div>
                    </div>
                    @foreach ($order->order_item as $item)
                        <div class="mt-3">
                            <div>
                                {{ '#' . $loop->iteration . ': ' . $item->product . ' (' . $item->size . ')' }}
                            </div>
                            <div class="grid grid-cols-2">
                                <div>
                                    {{ $item->quantity . ' X RM' . RM($item->price) }}
                                </div>
                                <div class="text-right">
                                    {{ 'RM' . RM($item->total) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="grid grid-cols-2 mt-5">
                        <div class="font-bold">{{ __('Jumlah Kasar') }}</div>
                        <div class="text-right font-bold">{{ 'RM' . RM($order->total) }}</div>
                    </div>
                    @if ($order->discount)
                        <div class="grid grid-cols-2 mt-3">
                            <div class="font-bold">{{ __('Diskaun') }}</div>
                            <div class="text-right font-bold">
                                {{ '(RM' . RM($order->discount) . ')' }}</div>
                        </div>
                    @endif
                    @if ($order->shipping)
                        <div class="grid grid-cols-2 mt-3">
                            <div class="font-bold">{{ __('Penghantaran') }}</div>
                            <div class="text-right font-bold">{{ 'RM' . RM($order->shipping) }}
                            </div>
                        </div>
                    @endif
                    <div class="grid grid-cols-2 mt-3">
                        <div class="font-bold">{{ __('Jumlah Bersih') }}</div>
                        <div class="text-right font-bold">{{ 'RM' . RM($order->grand_total) }}
                        </div>
                    </div>
                    <div class="text-center mt-10">
                        <div>
                            {{ __('Dibuat: ') . $order->user->name }}
                        </div>
                        <div>
                            {{ __('WhatsApp / Telefon: ') }} <br />
                            {{ phone_format($order->branch->phone_1) }}
                            {{ $order->branch->phone_2 ? ' / ' . phone_format($order->branch->phone_2) : '' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex">
                <a href="/orders/view/{{ $order->id }}"
                    class='w-auto text-center bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2 mt-3'>
                    {{ __('Kembali ke pesanan') }}
                </a>
                <div class="ml-auto">
                    <button onclick="print()"
                        class="bg-blue-400 p-2 rounded-md px-4 font-bold mt-3 text-white hover:bg-blue-600">Cetak</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
