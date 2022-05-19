<x-agent-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order: ') . $order->id }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="container mx-auto p-6">
                    <div class="text-center text-3xl font-bold">
                        ID: {{ order_num($order->id) }}
                    </div>
                    <div class="text-center text-xl">
                        {{ date('d/m/Y', strtotime($order->date)) }}
                    </div>
                    <div class="capitalize text-center text-lg">
                        Cawangan: {{ $order->branch->shortname }}
                    </div>
                    <div class="text-center">
                        Jumlah: RM {{ RM($order->grand_total) }}
                    </div>
                    <div class="text-center">
                        Jumlah Dibayar: RM {{ RM($order->paid) }}
                    </div>
                    <div class="mt-5">
                        <table class="w-full border-collapse mb-5">
                            <tr>
                                <th class="border uppercase">Produk</th>
                                <th class="border uppercase">Saiz</th>
                                <th class="border uppercase">Kuantiti</th>
                                <th class="border uppercase">Harga Seunit</th>
                                <th class="border uppercase">Jumlah</th>
                            </tr>
                            @foreach ($items as $item)
                                <tr class="text-center">
                                    <td class="border">{{ $item->product }}</td>
                                    <td class="border">{{ $item->size }}</td>
                                    <td class="border">{{ $item->quantity }}</td>
                                    <td class="border">
                                        @if ($item->price > 0)
                                        {{ RM($item->price) }}
                                        @else
                                        <span class="text-red-500 uppercase">belum dikemaskini</span>
                                        @endif
                                    </td>
                                    <td class="border">{{ RM($item->price*$item->quantity) }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="text-center my-4 mt-10">
                        <a href="/agent" class="bg-gray-500 p-1 px-2 rounded text-white">Kembali ke dashboard</a>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-agent-layout>
