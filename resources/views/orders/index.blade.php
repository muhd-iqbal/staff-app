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
                        <a href="/orders/create"
                            class='items-center m-5 bg-green-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            Tambah Pesanan
                        </a>
                        <div class="w-full xl:w-full mb-12 xl:mb-0 px-4 mx-auto">
                            <div class="flex justify-end">
                                <form action="/orders">
                                    <input type="text" name="search" placeholder="Carian..."
                                        value="{{ request('search') }}">
                                </form>
                            </div>
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">

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
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                    {{ __('Tarikh') }}
                                                </th>
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
                                                    <td
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                        {{ date('D d/m/Y', strtotime($order->created_at)) }}
                                                    </td>
                                                    <td
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                        @if ($order->isDone)
                                                            <span
                                                                class="bg-green-500 font-bold text-white text-center py-1 px-2 rounded-full">Selesai</span>
                                                        @else
                                                            <span
                                                                class="bg-red-500 font-bold text-white text-center py-1 px-2 rounded-full">Pending</span>
                                                        @endif
                                                    </td>
                                                </tr>

                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            {{ $orders->links() }}
                        </div>
                        <div class="m-5">
                            <div
                                class="inline-flex items-center bg-white leading-none text-purple-600 rounded-full p-2 shadow text-sm">
                                <span
                                    class="inline-flex bg-purple-600 text-white rounded-full h-6 px-3 justify-center items-center text-"></span>
                                <span class="inline-flex px-2">Gurun</span>
                            </div>
                            <div
                                class="inline-flex items-center bg-white leading-none text-pink-600 rounded-full p-2 shadow text-sm">
                                <span
                                    class="inline-flex bg-pink-600 text-white rounded-full h-6 px-3 justify-center items-center text-"></span>
                                <span class="inline-flex px-2">Guar</span>
                            </div>
                        </div>

                    </section>

                    <x-dashboard-link />

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
