<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Delivery Order: ' . order_num($order->id)) }}
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="section-to-print" class="p-6 bg-white">
                    <div class="text-right">
                        <div class="font-bold text-xl uppercase text-gray-500">{{ __('Delivery Order') }}</div>
                    </div>
                    <div class="flex gap-10 w-2/3 mb-5">
                        <x-application-logo class="block h-24 w-auto fill-current text-gray-600" />
                        <div>
                            <div class="uppercase text-xl font-bold">{{ $order->branch->name }}</div>
                            <div class="uppercase text-base font-bold">{{ $order->branch->address }}</div>
                            <div class="text-base font-bold">Tel: {{ phone_format(013-530 3135) }} / Emel:
                                admin@inspirazs.com.my</div>
                        </div>
                    </div>
                    <div class="table w-full items-center">
                        <table class="w-full border-collapse border border-black">
                            <tr>
                                <td class="border border-black p-2">
                                    Tarikh
                                </td>
                                <td class="border border-black p-2">{{ $order->created_at }}</td>
                            </tr>
                            <tr>
                                <td class="border border-black p-2">No Tracking</td>
                                <td class="border border-black p-2">{{ $order->delivery_tracking }}</td>
                            </tr>
                            <tr>
                                <td class="border border-black p-2">No Pesanan</td>
                                <td class="border border-black p-2">{{ order_num($order->id) }}</td>
                            </tr>
                            <tr>
                                <td class="border border-black p-2">Pelanggan</td>
                                <td class="border border-black p-2">
                                    <div>
                                        {{ $order->customer->organisation }}
                                    </div>
                                    @if ($order->customer->address)
                                        <div>
                                            <div>
                                                {{ $order->customer->address }}
                                            </div>
                                            <div>
                                                {{ $order->customer->postcode . ', ' . $order->customer->city }}
                                            </div>
                                            <div>
                                                {{ $order->customer->address }}
                                            </div>
                                        </div>
                                    @endif
                                    <div>
                                        u/p: {{ $order->customer->name }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-black p-2">Status</td>
                                <td class="border border-black p-2 capitalize">
                                    {{ $order->delivery_status ? 'Dihantar' : 'Self Pickup' }}</td>
                            </tr>
                            {{-- <td class="border border-black p-2">
                                    <div>Daripada: </div>
                                    <div>{{ $order->branch->name }} </div>
                                    <div>{{ $order->branch->address }} </div>
                                    <div>Tel: {{ phone_format($order->branch->phone_1) }}</div>
                                </td> --}}
                        </table>
                    </div>

                    <div class="pt-5">
                        <table class="w-full border-collapse border">
                            <tr class="bg-gray-300 border-gray-300">
                                <th class="border">No</th>
                                <th class="border">Item</th>
                                <th class="border">Kuantiti</th>
                            </tr>
                            <tr>
                                @foreach ($order->order_item as $item)
                            <tr class="text-center">
                                <td class="border border-black">{{ $loop->iteration }}</td>
                                <td class="border border-black">
                                    {{ $item->product . ' ' . $item->size . ' (' . $item->measurement . ')' }}</td>
                                <td class="border border-black">{{ $item->quantity }}</td>
                            </tr>
                            @endforeach
                            </tr>
                        </table>
                    </div>
                    <div class="grid grid-cols-3 mt-5">
                        <div>
                            <div>Dibuat Oleh:</div>
                            <div>{{ $order->branch->name }}</div>
                        </div>
                        <div>
                            <div>Dihantar Oleh:</div>
                            <div></div>
                        </div>
                        <div>
                            <div>Diterima Oleh:</div>
                            <div></div>
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
            <div class="mt-5">
                <form action="/orders/{{ $order->id }}/delivery-order" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="grid">
                        No Tracking
                        <input type="text" name="delivery_tracking" id="delivery_tracing" class="rounded-md"
                            value="{{ $order->delivery_tracking }}">
                        Status
                        <select name="delivery_status" id="delivery_status">
                            <option selected disabled>Pilih status</option>
                            <option value="1" {{ $order->delivery_status == 1 ? 'selected' : '' }}>Dihantar</option>
                            <option value="0" {{ $order->delivery_status != 1 ? 'selected' : '' }}>Self Pickup
                            </option>
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="submit"
                            class="p-2 my-2 bg-yellow-400 hover:bg-yellow-600 rounded-md">Kemaskini</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
