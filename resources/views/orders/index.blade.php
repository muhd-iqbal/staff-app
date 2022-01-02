<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="py-1">
                        <div class="grid md:grid-cols-2 my-2">
                            <div class="mt-3">
                                <a href="/orders/create"
                                    class='items-center mx-5 bg-green-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Tambah Pesanan') }}
                                </a>
                            </div>
                            <div class="text-right">
                                <form action="/orders">
                                    <input type="text" name="search" placeholder="Carian..."
                                        class="items-center mx-5 rounded-lg shadow-xl font-medium px-4 py-2"
                                        value="{{ request('search') }}">
                                </form>
                            </div>
                        </div>
                        <div class="w-full xl:w-full mb-12 xl:mb-0 px-4 mx-auto">
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                                <div class="block w-full overflow-x-auto">
                                    <table class="items-center bg-transparent w-full border-collapse ">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center">
                                                    {{ __('No') }}
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                    {{ __('Pelanggan') }}
                                                </th>
                                                {{-- <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                    {{ __('Tarikh') }}
                                                </th> --}}
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                    {{ __('Status') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr onclick="window.location='orders/view/{{ $order->id }}'"
                                                    class="hover:bg-gray-100 cursor-pointer">
                                                    <th
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                        {{ \App\Http\Controllers\Controller::order_num($order->id) }}
                                                    </th>
                                                    <td
                                                        class="flex border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                        @if ($order->location == 'gurun')
                                                            <div class="w-5 h-5 bg-purple-600 mr-2 rounded-full"></div>
                                                        @elseif ($order->location == "guar")
                                                            <div class="w-5 h-5 bg-pink-600 mr-2 rounded-full"></div>
                                                        @endif
                                                        {{ $order->customer_name }}
                                                    </td>
                                                    {{-- <td
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                        {{ date('D d/m/Y', strtotime($order->date)) }}
                                                    </td> --}}
                                                    <td
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                        @php
                                                            $status = $is_done = $is_printing = $is_approved = $is_design = $is_pending = 0;
                                                            $count = count($order->order_item);
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

                                                            @endphp
                                                        @endforeach

                                                        @unless($count == 0)

                                                            @php $status = $status/$count @endphp

                                                            @if ($is_pending)
                                                                <div
                                                                    class="inline-flex items-center bg-red-600 leading-none text-white rounded-full p-1 shadow text-sm font-bold">
                                                                    <span
                                                                        class="inline-flex px-1">{{ __('Pending') }}</span>
                                                                    <span
                                                                        class="inline-flex bg-white text-red-600 rounded-full h-4 px-2 justify-center items-center text- font-bold">{{ $is_pending }}</span>
                                                                </div>
                                                            @endif
                                                            @if ($is_design)
                                                                <div
                                                                    class="inline-flex items-center bg-yellow-400 leading-none text-white rounded-full p-1 shadow text-sm font-bold">
                                                                    <span
                                                                        class="inline-flex px-1">{{ __('Design') }}</span>
                                                                    <span
                                                                        class="inline-flex bg-white text-yellow-300 rounded-full h-4 px-2 justify-center items-center text- font-bold">{{ $is_design }}</span>
                                                                </div>
                                                            @endif
                                                            @if ($is_approved)
                                                                <div
                                                                    class="inline-flex items-center bg-yellow-700 leading-none text-white rounded-full p-1 shadow text-sm font-bold">
                                                                    <span
                                                                        class="inline-flex px-1">{{ __('Production') }}</span>
                                                                    <span
                                                                        class="inline-flex bg-white text-yellow-700 rounded-full h-4 px-2 justify-center items-center text- font-bold">{{ $is_approved }}</span>
                                                                </div>
                                                            @endif
                                                            @if ($is_printing)
                                                                <div
                                                                    class="inline-flex items-center bg-purple-600 leading-none text-white rounded-full p-1 shadow text-sm font-bold">
                                                                    <span
                                                                        class="inline-flex px-1">{{ __('Finishing') }}</span>
                                                                    <span
                                                                        class="inline-flex bg-white text-purple-600 rounded-full h-4 px-2 justify-center items-center text- font-bold">{{ $is_printing }}</span>
                                                                </div>
                                                            @endif
                                                            @if ($is_done)
                                                                <div
                                                                    class="inline-flex items-center bg-green-600 leading-none text-white rounded-full p-1 shadow text-sm font-bold">
                                                                    <span
                                                                        class="inline-flex px-1">{{ __('Selesai') }}</span>
                                                                    <span
                                                                        class="inline-flex bg-white text-green-600 rounded-full h-4 px-2 justify-center items-center text- font-bold">{{ $is_done }}</span>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div
                                                                class="inline-flex items-center bg-gray-600 leading-none text-white rounded-full p-1 shadow text-sm font-bold">
                                                                <span
                                                                    class="inline-flex px-1">{{ __('Tiada Item') }}</span>
                                                            </div>

                                                        @endunless
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{ $orders->links() }}
                        </div>
                        <div class="m-5 grid md:grid-cols-2">
                            <div>
                                <div onclick="window.location='/orders/location/gurun'"
                                    class="inline-flex items-center bg-white leading-none text-purple-600 rounded-full p-2 shadow text-sm cursor-pointer">
                                    <span
                                        class="inline-flex bg-purple-600 text-white rounded-full h-6 px-3 justify-center items-center text-"></span>
                                    <span class="inline-flex px-2">Gurun</span>
                                </div>
                                <div onclick="window.location='/orders/location/guar'"
                                    class="inline-flex items-center bg-white leading-none text-pink-600 rounded-full p-2 shadow text-sm cursor-pointer">
                                    <span
                                        class="inline-flex bg-pink-600 text-white rounded-full h-6 px-3 justify-center items-center text-"></span>
                                    <span class="inline-flex px-2">Guar</span>
                                </div>
                            </div>
                            <div class="flex flex-col-reverse md:flex-row-reverse mt-5 gap-3">
                                <div onclick="window.location='/orders/item/status/is_done'"
                                    class="inline-flex items-center bg-green-600 leading-none text-white rounded-full p-1 shadow text-sm font-bold cursor-pointer">
                                    <span class="inline-flex px-1">{{ __('Selesai') }}</span>
                                </div>
                                <div onclick="window.location='/orders/item/status/is_approved'"
                                    class="inline-flex items-center bg-yellow-700 leading-none text-white rounded-full p-1 shadow text-sm font-bold cursor-pointer">
                                    <span class="inline-flex px-1">{{ __('Production') }}</span>
                                </div>
                                <div onclick="window.location='/orders/item/status/is_design'"
                                    class="inline-flex items-center bg-yellow-400 leading-none text-white rounded-full p-1 shadow text-sm font-bold cursor-pointer">
                                    <span class="inline-flex px-1">{{ __('Design') }}</span>
                                </div>
                                <div  onclick="window.location='/orders/item/status/is_pending'"
                                    class="inline-flex items-center bg-red-600 leading-none text-white rounded-full p-1 shadow text-sm font-bold cursor-pointer">
                                    <span class="inline-flex px-1">{{ __('Pending') }}</span>
                                </div>
                            </div>
                        </div>
                    </section>
                    <x-dashboard-link />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
