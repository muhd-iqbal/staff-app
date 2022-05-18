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
                        {{ date('d/m/Y', strtotime($order->date)) }}
                    </div>
                    <div class="capitalize text-center text-lg">
                        Cawangan: {{ $order->branch->shortname }}
                    </div>
                    <div class="text-center">
                        Jumlah: RM {{ RM($order->grand_total) }}
                    </div>
                    <div class="mt-5">
                        <table class="w-full border-collapse mb-5">
                            <tr>
                                <th class="border uppercase">Produk</th>
                                <th class="border uppercase">Saiz</th>
                                <th class="border uppercase">Kuantiti X harga</th>
                            </tr>
                            @foreach ($items as $item)
                                <tr class="text-center">
                                    <td class="border">{{ $item->product }}</td>
                                    <td class="border">{{ $item->size }}</td>
                                    <td class="border">
                                        @if ($item->price > 0)
                                            {{ $item->quantity . ' X ' . RM($item->price) }}
                                        @else
                                            {{ $item->quantity}} X <span class="text-red-500 uppercase">belum dikemaskini</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="text-right my-4">
                        <a href="/agent">Back</a>

                    </div>
                </section>
            </div>
        </div>
    </div>
</x-agent-layout>
