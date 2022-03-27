<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pelanggan: {{ $customer->name }}
        </h2>
    </x-slot>
    {{-- <x-modalbox action='/orders/{{ $order->id }}/delete'
        text='Padam order? Setiap item perlu dipadam terlebih dahulu.' /> --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- start component -->
                    <div class="flex items-center justify-center">
                        <div class="grid bg-white rounded-lg shadow-xl w-full">
                            {{-- @if (auth()->user()->isAdmin)
                                <div class="text-right" title="Padam Order"><span class=" text-red-500 cursor-pointer"
                                        onclick="openModal()">x</span></div>
                            @endif --}}
                            <div class="flex flex-col items-center">
                                <div class="flex">
                                    <h1 class="uppercase text-gray-600 font-bold md:text-2xl text-xl">
                                        {{ $customer->name }}</h1>
                                    <a href="{{ 'https://wa.me/6' . $customer->phone }}">
                                        <img src="https://cdn.cdnlogo.com/logos/w/29/whatsapp-icon.svg" width="30"></a>
                                </div>
                                <div>
                                    {{-- <h2 class="text-gray-500 font-bold md:text-xl text-lg">
                                        {{ ucwords($order->method) }}
                                        ({{ ucwords($order->branch->shortname) }})</h2> --}}
                                </div>
                            </div>

                            <div class="text-center">
                                <div class="mt-5 mx-7">
                                    @if ($customer->address)
                                        <div class="md:text-base text-sm text-gray-500 text-light font-semibold">
                                            {{ $customer->address . ', ' . $customer->postcode . ', ' . $customer->city . ', ' . $customer->state }}
                                        </div>
                                    @endif
                                    <div class="md:text-base text-sm text-gray-500 text-light font-semibold">
                                        {{ __('No Telefon: ') . $customer->phone }}
                                    </div>
                                    @if ($customer->email)
                                        <div class="md:text-base text-sm text-gray-500 text-light font-semibold">
                                            {{ __('Emel: ') . $customer->email }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class='flex flex-row gap-3 items-center justify-center p-5 pb-5'>
                                <a href="/customer/{{ $customer->id }}/edit"
                                    class='w-auto text-center bg-yellow-600 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Edit pelanggan') }}
                                </a>
                                {{-- <a href="/orders/view/{{ $order->id }}/edit"
                                    class='w-auto text-center bg-yellow-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Edit Order') }}
                                </a>
                                <a href="/orders/{{ $order->id }}/invoice"
                                    class='w-auto text-center bg-purple-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Invois') }}
                                </a>
                                <a href="/orders/{{ $order->id }}/payments"
                                    class='w-auto text-center bg-pink-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Bayaran') }}
                                </a>
                                <a href="/orders/view/{{ $order->id }}/pickup"
                                    @if ($order->pickup) onclick = "return confirm('Pickup sudah direkod!\nKemaskini semula?')" @endif
                                    class='w-auto text-center bg-blue-500 hover:bg-gray-700 rounded-lg shadow-xl
                                    font-medium text-white px-4 py-2'>
                                    {{ __('Pickup') }}
                                </a> --}}
                                <a href="/customers"
                                    class='w-auto text-center bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Kembali ke senarai pelanggan') }}
                                </a>
                            </div>
                        </div>
                    </div> <!-- end components -->

                    <div class="flex flex-col text-left mt-2">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 font-medium text-xs text-gray-500 uppercase tracking-wider">
                                                    {{ __('Order') }}
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Tarikh') }}
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Harga') }}
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Bayaran') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($orders as $order)
                                                <tr onclick="window.location='/orders/view/{{ $order->id }}'"
                                                    class="hover:bg-gray-100 cursor-pointer">
                                                    <th
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">

                                                        {{-- <div class="w-3 overflow-hidden inline-block"> --}}
                                                        @if ($order->date >= env('POS_START'))
                                                            <div
                                                                class="w-3 h-3 inline-block
                                                        @if ($order->due == $order->grand_total) bg-red-600
                                                        @elseif ($order->due > 0) bg-yellow-500
                                                        @else bg-green-600 @endif
                                                        ">
                                                            </div>
                                                        @endif
                                                        {{-- </div> --}}
                                                        {{ order_num($order->id) }}
                                                    </th>
                                                    <td
                                                        class="flex border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                        <div id="branch-label"
                                                            class="w-5 h-5 mr-2 rounded-full bg-{{ $order->branch->color_code }}-600">
                                                        </div>
                                                        {{ $order->date }}
                                                        {{-- <div id="urgent-{{ $order->id }}"
                                                        class="ml-2 items-center bg-red-600 leading-none text-white rounded-full p-1 shadow text-sm font-bold hidden">
                                                        <span class="inline-flex px-1">{{ __('URGENT') }}</span>
                                                    </div> --}}
                                                    </td>
                                                    <td
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                        RM{{ RM($order->grand_total) }}
                                                    </td>
                                                    <td
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                        RM{{ RM($order->paid) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center my-2">
                                    Tertunggak: RM {{ RM($customer->order->sum('due')) }}
                                </div>
                                {{ $orders->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
