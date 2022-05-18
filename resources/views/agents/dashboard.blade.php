<x-agent-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agent Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="container mx-auto p-6">
                    <div class="text-center text-3xl font-bold">
                        {{ $agent->name }}
                    </div>
                    @if ($agent->address)
                        <div class="text-center text-base font-bold">
                            {{ $agent->address . ', ' . $agent->postcode . ', ' . $agent->city }}
                        </div>
                    @endif
                    <div class="text-center mt-1">
                        Phone No: {{ phone_format($agent->phone) }}
                    </div>
                    @if ($agent->email)
                        <div>
                            Email: {{ $agent->email }}
                        </div>
                    @endif
                    <div class="text-right my-4">
                        <a href="/agent/add-order" class="bg-green-500 py-1 px-4 rounded-md shadow-md hover:bg-green-700 hover:text-white">
                            Tambah Order
                        </a>
                    </div>

                    <div>
                        <table class="w-full border-collapse mb-5">
                            <tr>
                                <th class="border">Rujukan</th>
                                <th class="border">Cawangan</th>
                                <th class="border">Tarikh</th>
                                <th class="border">Tindakan</th>
                            </tr>
                            @foreach ($orders as $order)
                                <tr class="text-center">
                                    <td class="border">{{ order_num($order->id) }}</td>
                                    <td class="border">{{ $order->branch->shortname }}</td>
                                    <td class="border">{{ $order->date }}</td>
                                    <td class="border underline"><a href="/agent/order/{{ $order->id }}">Lihat</a></td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $orders->links() }}
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-agent-layout>
