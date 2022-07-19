<x-agent-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Ejen') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="container mx-auto p-6">
                    <div class="text-center text-3xl font-bold">
                        {{ $agent->organisation }}
                    </div>
                    <div class="text-center text-xl font-bold">
                        PIC: {{ $agent->name }}
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
                        <div class="text-center mt-1">
                            Email: {{ $agent->email }}
                        </div>
                    @endif
                    <div class="text-center mt-1">
                        Jumlah Tertunggak: RM{{ RM($total->sum('due')) }}
                    </div>
                    <div class="text-right my-4">
                        <a href="/agent/add-order"
                            class="bg-green-500 py-1 px-4 rounded-md shadow-md hover:bg-green-700 hover:text-white">
                            Tambah Order
                        </a>
                    </div>

                    <div class="overflow-x-auto sm:rounded-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <small class="underline">Klik no rujukan order untuk lihat order.</small>
                                <table class="w-full border-collapse mb-5">
                                    <tr>
                                        <th class="border">Rujukan</th>
                                        <th class="border">Tarikh</th>
                                        <th class="border">Tertunggak</th>
                                        <th class="border">Status</th>
                                        {{-- <th class="border">Tindakan</th> --}}
                                    </tr>
                                    @foreach ($orders as $order)
                                        <tr class="text-center">
                                            <td class="border px-1 underline text-blue-700"><a
                                                    href="/agent/order/{{ $order->id }}">{{ order_num($order->id) }}</a>
                                            </td>
                                            <td class="border px-1">{{ date('d/m/y', strtotime($order->date)) }}</td>
                                            <td class="px-1 border{{ $order->due ? ' text-red-500' : '' }}">
                                                {{ $order->due ? RM($order->due) : 'N/A' }}</td>
                                            <td class="border px-1">
                                                @php
                                                    $status = $is_done = $is_printing = $is_approved = $is_design = $is_pending = 0;
                                                    $count = count($order->order_item);
                                                    $urgent = 0;
                                                @endphp

                                                @foreach ($order->order_item as $item)
                                                    @php
                                                        if ($item->is_done) {
                                                            $is_done++;
                                                        } elseif ($item->is_printing) {
                                                            $is_printing++;
                                                        } elseif ($item->is_approved) {
                                                            $is_approved++;
                                                        } elseif ($item->is_design) {
                                                            $is_design++;
                                                        } else {
                                                            $is_pending++;
                                                        }

                                                        if ($item->is_urgent) {
                                                            $urgent++;
                                                        }

                                                    @endphp
                                                @endforeach

                                                @unless($count == 0)
                                                    @php $status = $status/$count @endphp

                                                    @if ($is_pending)
                                                        <div
                                                            class="inline-flex items-center bg-red-600 leading-none text-white rounded-full p-0 shadow text-sm font-bold">
                                                            <span
                                                                class="inline-flex text-white rounded-full h-6 w-6 justify-center items-center text-base">{{ $is_pending }}</span>
                                                        </div>
                                                    @endif
                                                    @if ($is_design)
                                                        <div
                                                            class="inline-flex items-center bg-yellow-400 leading-none text-white rounded-full p-0 shadow text-sm font-bold">
                                                            <span
                                                                class="inline-flex text-white bg-yellow-400 rounded-full h-6 w-6 justify-center items-center text-base">{{ $is_design }}</span>
                                                        </div>
                                                    @endif
                                                    @if ($is_approved)
                                                        <div
                                                            class="inline-flex items-center bg-yellow-700 leading-none text-white rounded-full p-0 shadow text-sm font-bold">
                                                            <span
                                                                class="inline-flex text-white bg-yellow-700 rounded-full h-6 w-6 justify-center items-center text-base font-bold">{{ $is_approved }}</span>
                                                        </div>
                                                    @endif
                                                    @if ($is_printing)
                                                        <div
                                                            class="inline-flex items-center bg-purple-600 leading-none text-white rounded-full p-0 shadow text-sm font-bold">
                                                            <span
                                                                class="inline-flex text-white bg-purple-600 rounded-full h-6 w-6 justify-center items-center text-base">{{ $is_printing }}</span>
                                                        </div>
                                                    @endif
                                                    @if ($is_done)
                                                        <div
                                                            class="inline-flex items-center bg-green-600 leading-none text-white rounded-full p-0 shadow text-sm font-bold">
                                                            <span
                                                                class="inline-flex text-white bg-green-600 rounded-full h-6 w-6 justify-center items-center text-base font-bold">{{ $is_done }}</span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div
                                                        class="inline-flex items-center bg-gray-600 leading-none text-white rounded-full p-0 shadow text-sm font-bold">
                                                        <span class="inline-flex px-1">{{ __('Tiada Item') }}</span>
                                                    </div>
                                                @endunless
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <div
                            class="inline-flex items-center bg-red-600 leading-none text-white rounded-full p-0 shadow text-sm font-bold">
                            <span
                                class="inline-flex text-white bg-red-600 rounded-full h-6 px-1 justify-center items-center text-base font-bold">Pending</span>
                        </div>
                        <div
                            class="inline-flex items-center bg-yellow-400 leading-none text-white rounded-full p-0 shadow text-sm font-bold">
                            <span
                                class="inline-flex text-white bg-yellow-400 rounded-full h-6 px-1 justify-center items-center text-base font-bold">Design</span>
                        </div>
                        <div
                            class="inline-flex items-center bg-yellow-700 leading-none text-white rounded-full p-0 shadow text-sm font-bold">
                            <span
                                class="inline-flex text-white bg-yellow-700 rounded-full h-6 px-1 justify-center items-center text-base font-bold">Production</span>
                        </div>
                        <div
                            class="inline-flex items-center bg-green-600 leading-none text-white rounded-full p-0 shadow text-sm font-bold">
                            <span
                                class="inline-flex text-white bg-green-600 rounded-full h-6 px-1 justify-center items-center text-base font-bold">Selesai</span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-agent-layout>
