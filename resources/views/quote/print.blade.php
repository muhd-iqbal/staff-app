<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quotation: ' . $quote->id) }}
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
            <div id="section-to-print" class="bg-white overflow-hidden sm:rounded-lg">
                <div class="p-6 bg-white">
                    <div class="text-right">
                        <div class="font-bold text-xl">{{ __('SEBUT HARGA') }}</div>
                    </div>
                    <div>
                        <div class="flex text-left gap-5">
                            <x-application-logo class="hidden md:block h-24 w-auto fill-current text-gray-600" />
                            <x-application-logo class="block md:hidden h-32 w-auto fill-current text-gray-600" />
                            <div>
                                <div class="text-2xl font-bold uppercase">{{ $quote->branch->name }}</div>
                                <div class="text-base font-bold uppercase">{{ $quote->branch->address }}</div>
                                <div class="text-base font-bold uppercase">Tel:
                                    {{ phone_format($quote->branch->phone_1) }}
                                    {{ $quote->branch->phone_2 ? ' / ' . phone_format($quote->branch->phone_2) : '' }}
                                </div>
                                <div class="text-base font-bold">EMEL: admin@inspirazs.com.my</div>
                            </div>
                        </div>

                        <div class="mt-5">
                            {{ __('Kepada: ') }}
                        </div>
                        {{ $quote->customer->organisation ? $quote->customer->organisation : $quote->customer->name }}<br>
                        {{-- <div>{{ $quote->customer->organisation ? '' : $quote->customer->name }}</div> --}}
                        {{ $quote->customer->address }},<br>{{ $quote->customer->postcode }}
                        {{ $quote->customer->city }}, {{ $quote->customer->state }}
                        <div>{{ $quote->customer->organisation ? 'PIC: '.$quote->customer->name : ''  }}</div>
                        <div>
                            {{ __('Telefon: ') . phone_format($quote->customer->phone) }}
                        </div>
                    </div>
                    <div class="border-b border-gray-600 pb-3">
                        <div class="grid grid-cols-2 mt-5">
                            <div class="font-bold">
                                {{ __('No. Sebut Harga: ') . quote_num($quote->id) }}
                            </div>
                            <div class="text-right">{{ __('Tarikh: ') . date('d/m/Y', strtotime($quote->date)) }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <table class="w-full border-collapse">
                            <tr class="bg-gray-100">
                                <th class="text-center px-3 border w-1/12">No</th>
                                <th class="text-left px-3 border">Perkara</th>
                                <th class="text-center px-3 border w-2/12">Saiz</th>
                                <th class="text-center px-3 border w-2/12">Kuantiti</th>
                                <th class="text-center px-3 border w-2/12">Harga Seunit</th>
                                <th class="text-right px-3 border w-2/12">Jumlah (RM)</th>
                            </tr>
                            @foreach ($quote->quote_item as $item)
                                <tr>
                                    <td class="text-center px-3 border">{{ $loop->iteration }}</td>
                                    <td class="px-3 border">{{ $item->product }}</td>
                                    <td class="px-3 text-center border">
                                        {{ $item->size }}
                                        {{ $item->measurement ? '(' . $item->measurement . ')' : '' }}
                                    </td>
                                    <td class="px-3 text-center border">{{ $item->quantity }}</td>
                                    <td class="px-3 text-center border">{{ RM($item->price) }}</td>
                                    <td class="px-3 text-right border">{{ RM($item->total) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @if ($quote->discount || $quote->shipping)
                        <div class="grid grid-cols-2 mt-5">
                            <div class="font-bold">{{ __('Jumlah Kasar') }}</div>
                            <div class="text-right font-bold">{{ 'RM' . RM($quote->total) }}</div>
                        </div>
                    @endif
                    @if ($quote->discount)
                        <div class="grid grid-cols-2 mt-3">
                            <div class="font-bold">{{ __('Diskaun') }}</div>
                            <div class="text-right font-bold">
                                {{ '(RM' . RM($quote->discount) . ')' }}</div>
                        </div>
                    @endif
                    @if ($quote->shipping)
                        <div class="grid grid-cols-2 mt-3">
                            <div class="font-bold">{{ __('Penghantaran') }}</div>
                            <div class="text-right font-bold">{{ 'RM' . RM($quote->shipping) }}
                            </div>
                        </div>
                    @endif
                    <div class="grid grid-cols-2 mt-3">
                        <div class="font-bold">{{ __('Jumlah Bersih') }}</div>
                        <div class="text-right font-bold">{{ 'RM' . RM($quote->grand_total) }}
                        </div>
                    </div>
                    @if ($quote->foot_note)
                        <div class="border mt-2 p-1">
                            <div>Nota:</div>
                            <div>{!! $quote->foot_note !!}</div>
                        </div>
                    @endif
                    <div class="text-center mt-10">
                        <div class="text-sm">

                            Ini adalah dokumen yang dihasilkan komputer. Tidak perlu tandatangan
                        </div>
                        <div class="text-center">{{ __('Sebut harga sah sehingga: ') . date('d/m/Y', strtotime($quote->date)) }}
                            </div>
                    </div>
                </div>
            </div>
            <div class="flex">
                <a href="/quote/{{ $quote->id }}"
                    class='w-auto text-center bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2 mt-3'>
                    {{ __('Kembali') }}
                </a>
                <div class="ml-auto">
                    <button onclick="print()"
                        class="bg-blue-400 p-2 rounded-md px-4 font-bold mt-3 text-white hover:bg-blue-600">Cetak</button>
                </div>
            </div>
            <div class="mt-5">
                Nota Kaki <span class="text-xs rounded-full bg-gray-700 text-white px-1 cursor-pointer"
                    onclick="alert('Elakkan guna simbol. Ganti nota dengan ayat.\nNew line: nota<br> \nBold: <b>nota</b> \nItalic: <i>nota</i>\nUnderline: <u>nota</u>')">
                    ?
                </span>
                <form action="/quote/{{ $quote->id }}/print" method="POST">
                    @csrf
                    @method('PATCH')
                    <div>
                        <textarea name="foot_note" id="foot_note" cols="30" rows="3" class="rounded-md resize-none">{{ $quote->foot_note }}</textarea>
                    </div>
                    <div>
                        <button type="submit"
                            class="px-2 bg-yellow-400 hover:bg-yellow-600 rounded-md">Kemaskini</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
