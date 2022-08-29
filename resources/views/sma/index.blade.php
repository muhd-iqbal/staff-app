<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            {{ __("Senarai Order Sistem POS lama $branch") }}
        </h2>
    </x-slot>
    {{-- <script>
        function goToOrder() {
            var id = prompt("Masukkan ID Pesanan");
            if (id === null) {
                return; //break out of the function early
            }
            document.getElementById("id").value = id;
            document.getElementById("form").submit();
        }
    </script>
    <form id="form" action="/order/go">
        <input type="hidden" id="id" name="id" />
    </form> --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @isset($to_be_updated)
                <div class="bg-yellow-500 p-2 rounded mb-4 text-center">
                    Terdapat {{ $to_be_updated }} Item tiada harga. <a href="/order/item/zero-value"
                        class="bg-gray-100 px-2 rounded ml-2">Lihat</a>
                </div>
            @endisset
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="py-1">
                        <div class="flex flex-col md:flex-row gap-5 my-2">
                            <div class="flex text-red-500">*UNTUK RUJUKAN SAHAJA. TIDAK BOLEH DIUBAH</div>
                            <div class="flex-grow"></div>
                            <div class="flex md:flex-row-reverse">
                                <form action="">
                                    <input type="text" name="search" placeholder="Carian..."
                                        class="items-center mx-1 rounded-lg shadow-xl font-medium px-4 py-2"
                                        value="{{ request('search') }}">
                                    <a href="/orders" class="text-2xl" title="Tunjuk semua">&#8635;</a>
                                </form>
                            </div>
                        </div>
                        <div class="w-full xl:w-full mb-12 xl:mb-0 px-4 mx-auto mt-5">
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                                <div class="block w-full overflow-x-auto">
                                    <table class="w-full border-collapse border rounded">
                                        <thead>
                                            <tr>
                                                <th> {{ __('ID') }} </th>
                                                <th class="hidden md:block"> {{ __('Rujukan') }} </th>
                                                <th class="text-left">{{ __('Pelanggan') }} </th>
                                                <th>{{ __('Bayaran') }} </th>
                                                <th>{{ __('Jumlah') }} </th>
                                                <th>&nbsp; </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr class="text-center border">
                                                    <td><a href="/orders/old/{{ $branch }}/{{ $order->oid }}"
                                                            class="underline text-blue-700">{{ $order->oid }}</a>
                                                    </td>
                                                    <td class="hidden md:block">{{ $order->reference_no }}</td>
                                                    <td class="text-left">{{ $order->customer }} - {{ $order->phone }}</td>
                                                    <td>{{ $order->payment_status }}</td>
                                                    <td>{{ number_format($order->grand_total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{ $orders->withQueryString()->links() }}
                        </div>
                        {{-- <div class="m-5 grid md:grid-cols-2">
                            <div>
                                @foreach ($branches as $branch)
                                    <div onclick="window.location='/orders/location/{{ $branch->id }}'"
                                        class="inline-flex items-center bg-white leading-none text-{{ $branch->color_code }}-500 rounded-full p-2 shadow text-sm cursor-pointer">
                                        <span
                                            class="inline-flex bg-{{ $branch->color_code }}-500 text-white rounded-full h-6 px-3 justify-center items-center text-"></span>
                                        <span class="inline-flex px-2">{{ ucwords($branch->shortname) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div>
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
                                    <div onclick="window.location='/orders/item/status/is_pending'"
                                        class="inline-flex items-center bg-red-600 leading-none text-white rounded-full p-1 shadow text-sm font-bold cursor-pointer">
                                        <span class="inline-flex px-1">{{ __('Pending') }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-row md:flex-row-reverse mt-5 gap-3">
                                    <div onclick="window.location='/orders?payment=paid'"
                                        class="inline-flex flex-grow md:flex-grow-0 items-center bg-green-600 leading-none text-white p-1 shadow text-sm font-bold cursor-pointer">
                                        <span class="inline-flex px-1">{{ __('Paid') }}</span>
                                    </div>
                                    <div onclick="window.location='/orders?payment=partial'"
                                        class="inline-flex flex-grow md:flex-grow-0 items-center bg-yellow-500 leading-none text-white p-1 shadow text-sm font-bold cursor-pointer">
                                        <span class="inline-flex px-1">{{ __('Partial') }}</span>
                                    </div>
                                    <div onclick="window.location='/orders?payment=unpaid'"
                                        class="inline-flex flex-grow md:flex-grow-0 items-center bg-red-600 leading-none text-white p-1 shadow text-sm font-bold cursor-pointer">
                                        <span class="inline-flex px-1">{{ __('Unpaid') }}</span>
                                    </div>
                                    <div class="text-sm font-bold" title="Order dimulakan pada {{ date('d-m-Y', strtotime(config('app.pos_start'))) }}">Tertunggak: RM{{ RM($dues) }} </div>
                                </div>
                            </div>
                        </div> --}}
                    </section>
                    <div class="mx-5">
                        <a href="/orders/old/gurun"
                            class="mr-5 bg-white border border-gray-600 hover:bg-blue-700 hover:text-white text-black font-bold py-2 px-6">Gurun</a>
                        <a href="/orders/old/guar"
                            class="mr-5 bg-white border border-gray-600 hover:bg-blue-700 hover:text-white text-black font-bold py-2 px-6">Guar</a>
                    </div>
                    <x-dashboard-link />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
