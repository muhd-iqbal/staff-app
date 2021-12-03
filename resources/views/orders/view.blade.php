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

                    <!-- start component -->
                    <div class="flex items-center justify-center">
                        <div class="grid bg-white rounded-lg shadow-xl w-full">

                            <div class="flex justify-center">
                                <div class="flex">
                                    <h1 class="text-gray-600 font-bold md:text-2xl text-xl">Order ID:
                                        {{ \App\Http\Controllers\Controller::order_num($order->id) }}</h1>
                                    <a href="https://wa.me/6{{ $order->customer_phone }}"><img
                                            src="https://cdn.cdnlogo.com/logos/w/29/whatsapp-icon.svg" width="30"></a>
                                </div>
                            </div>

                            <div class="flex w-full">
                                <div class="flex-1 mt-5 mx-7">
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        Nama Pelanggan: {{ $order->customer_name }}
                                    </div>
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        No Telefon: {{ $order->customer_phone }}
                                    </div>
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        Tarikh pesanan: {{ date('d/m/Y', strtotime($order->date)) }}
                                    </div>
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        Deadline: @if ($order->deadline)
                                            {{ date('d/m/Y', strtotime($order->deadline)) }}
                                        @endif
                                    </div>
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        {{ $order->method }}
                                    </div>
                                    @if (auth()->user()->isAdmin && !$order->isDone)
                                        <form method="POST" action="/orders/view/{{ $order->id }}/mark-done">
                                            @csrf
                                            @method('PATCH')
                                            <x-button class="h-10"
                                                onclick="return confirm('{{ __('Sahkan order selesai') }}')">
                                                {{ __('Tanda Selesai') }}</x-button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div class='flex gap-5 items-center justify-center p-5 pb-5'>
                                @if (!$order->isDone)
                                    <a href="/orders/{{ $order->id }}/add-item"
                                        class='w-auto bg-green-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Tambah Item
                                    </a>
                                @endif
                                <a href="/orders"
                                    class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    Kembali ke senarai pesanan
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
                                                    class="px-6 py-3 font-medium text-gray-500 uppercase tracking-wider">
                                                    Item
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    PIC
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($lists as $list)

                                                <tr class="cursor-pointer"
                                                    onclick="window.location='/orders/item/{{ $list->id }}'">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">

                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $list->product }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if ($list->user)
                                                                <img class="h-10 w-10 rounded-full"
                                                                    src="{{ asset('storage/' . $list->user->photo) }}"
                                                                    title="{{ $list->user->name }}" />
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if ($list->isDone)
                                                            <span
                                                                class="bg-green-500 font-bold text-white text-center py-1 px-2 text-xs rounded-full">Siap</span>
                                                        @elseif ($list->isPrinting)
                                                            <span
                                                                class="bg-yellow-500 font-bold text-white text-center py-1 px-2 text-xs rounded-full">Print</span>
                                                        @elseif ($list->isDesign)
                                                            <span
                                                                class="bg-purple-500 font-bold text-white text-center py-1 px-2 text-xs rounded-full">Design</span>
                                                        @else
                                                            <span
                                                                class="bg-red-500 font-bold text-white text-center py-1 px-2 text-xs rounded-full">Tiada
                                                                Tindakan</span>
                                                        @endif

                                                    </td>
                                                </tr>

                                            @endforeach
                                            <!-- More people... -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Details --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
