<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="py-1">
                        <div class="w-full xl:w-full mb-12 xl:mb-0 px-4 mx-auto mt-5">
                            <div class="flex justify-end">
                                <form action="/orders">
                                    <input type="text" name="search" placeholder="Cari...">
                                </form>
                            </div>
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">
                                <div class="rounded-t mb-0 px-4 py-3 border-0">
                                    <div class="flex flex-wrap items-center">
                                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                            <h3 class="font-semibold text-xl text-blueGray-700">Senarai</h3>
                                        </div>
                                        <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                                            <a href="/orders/create"
                                                class="bg-indigo-500 text-white active:bg-indigo-600 text-sm font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150 py-2"
                                                type="button">Order Baru</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="block w-full overflow-x-auto">
                                    <table class="items-center bg-transparent w-full border-collapse ">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center">
                                                    No
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                    Pelanggan
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                    Tarikh
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($orders as $order)

                                                <tr onclick="window.location='orders/view/{{ $order->id }}';" class="hover:bg-gray-100 cursor-pointer">
                                                    <th
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                        {{ \App\Http\Controllers\Controller::order_num($order->id) }}
                                                    </th>
                                                    <td
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
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
                    </section>

                    <x-dashboard-link />

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
