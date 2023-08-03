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
                                <a href="/testing/create"
                                    class='items-center mx-5 bg-green-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Tambah Pesanan') }}
                                </a>
                            </div>

                            <div class="text-right">
                                <form action="/testing">
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
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle text-center border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                                    {{ __('No') }}
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center">
                                                    {{ __('Order No') }}
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                    {{ __('Pelanggan') }}
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                    {{ __('No Phone') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                //forgive me a bit sketchy
                                                foreach ($branches as $branch):
                                                    $bra[$branch->id] = 0;
                                                endforeach;
                                            @endphp
                                            @foreach ($testing as $order)
                                                @php
                                                    //again, sorry
                                                    $bra[$order->branch_id]++;
                                                @endphp
                                                <tr onclick="window.location='/testing/view/{{ $order->id }}'"
                                                    class="hover:bg-gray-100 cursor-pointer">
                                                    <td class="text-center">
                                                        {{ ($testing->currentpage() - 1) * $testing->perpage() + $loop->index + 1 }}
                                                    </td>
                                                    <th
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                        {{ order_num($order->id) }}
                                                    </th>
                                                    <td
                                                        class="flex border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                        <div id="branch-label"
                                                            class="w-5 h-5 mr-2 rounded-full bg-{{ $order->branch->color_code }}-500">
                                                        </div>
                                                        {{ $order->customer->name }}
                                                    </td>
                                                    <td>
                                                        {{ $order->customer->phone }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{ $testing->withQueryString()->links() }}
                        </div>
                    </section>
                    <div class="m-5 grid md:grid-cols-2">
                        <div>
                            @foreach ($branches as $branch)
                                <div onclick="window.location='/testing/no-pickup?branch={{ $branch->id }}'"
                                    class="inline-flex items-center bg-white leading-none text-{{ $branch->color_code }}-500 rounded-full p-2 shadow text-sm cursor-pointer">
                                    <span
                                        class="inline-flex bg-{{ $branch->color_code }}-500 text-white rounded-full h-6 px-3 justify-center items-center text-">{{ $bra[$branch->id] }}</span>
                                    <span class="inline-flex px-2">{{ ucwords($branch->shortname) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <a href="/testing"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            {{ __('Kembali ke senarai pesanan') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
