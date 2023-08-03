<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ order_num($order->id) }}
        </h2>
    </x-slot>
    <x-modalbox>
        <!--Title-->
        <div class="flex justify-between items-center pb-3">
            <p class="text-2xl font-bold">Perhatian</p>
        </div>
        <!--Body-->
        <div class="my-5">
            <p>Padam order? Setiap item perlu dipadam terlebih dahulu.</p>
        </div>
        <!--Footer-->
        <div class="flex justify-end pt-2 gap-2">
            <button class="focus:outline-none modal-close px-4 bg-gray-400 text-black hover:bg-gray-300">Batal</button>
            <form action="/orders/{{ $order->id }}/delete" method="POST">
                @csrf
                @method('DELETE')
                <x-button>Padam</x-button>
            </form>
        </div>
    </x-modalbox>
    @php
        $alert = 0;
    @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="p-6 border-t-4
                    @if ($order->date >= config('app.pos_start')) @if ($order->due == $order->grand_total) border-red-600 @elseif ($order->due > 0) border-yellow-500 @else border-green-600 @endif
                    @endif
                    ">
                    <!-- start component -->
                    <div class="flex items-center justify-center">
                        <div class="grid bg-white rounded-lg shadow-xl w-full">
                            @if (auth()->user()->isAdmin)
                                <div class="text-right" title="Padam Order"><span class=" text-red-500 cursor-pointer"
                                        onclick="openModal()">x</span></div>
                            @endif
                            <div class="flex flex-col items-center">
                                <div class="flex">
                                    <h1 class="text-gray-600 font-bold md:text-2xl text-xl">{{ __('Pesanan:') }}
                                        {{ order_num($order->id) }}</h1>
                                    <a href="{{ 'https://wa.me/6' . $order->customer->phone }}">
                                        <img src="https://cdn.cdnlogo.com/logos/w/29/whatsapp-icon.svg"
                                            width="30"></a>
                                </div>
                                <div>
                                    <h2 class="text-gray-500 font-bold md:text-xl text-lg">
                                        {{ ucwords($order->method) }}
                                        ({{ ucwords($order->branch->shortname) }})</h2>
                                </div>
                                @if ($order->pay_method)
                                    <div class="bg-gray-400 text-white px-1 rounded-lg uppercase">
                                        {{ $order->pay_method }}
                                        </div>
                                @endif
                            </div>

                            <div class="grid md:grid-cols-2">
                                <div class="mt-5 mx-7">
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        {{ __('Organisasi: ') . $order->customer->organisation }}
                                        <br>
                                        {{ __('Nama Pelanggan: ') . $order->customer->name }}
                                        <a href="/customer/{{ $order->customer_id }}"
                                            class="lowercase bg-gray-600 text-white px-1 rounded hover:text-gray-200">lihat</a>
                                    </div>
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        {{ __('No Telefon: ') . $order->customer->phone }}
                                    </div>
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        {{ __('Tarikh pesanan: ') . date('d-M-Y', strtotime($order->date)) }}
                                    </div>
                                    @if ($order->deadline)
                                        <div
                                            class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                            {{ __('Deadline: ') }}
                                            {{ date('d/m/Y', strtotime($order->deadline)) }}
                                        </div>
                                    @endif
                                    @if ($order->pickup)
                                        <div
                                            class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                            {{ __('Pickup: ') . $order->pickup . ' (' . date('d/m/Y', strtotime($order->pickup_time)) . ')' }}
                                        </div>
                                    @endif
                                </div>
                                @if (auth()->user()->isAdmin && !$order->isDone)
                                    <div class="text-right m-5">
                                        <form method="POST" action="/orders/view/{{ $order->id }}/mark-done">
                                            @csrf
                                            @method('PATCH')
                                            <x-button class="h-10"
                                                onclick="return confirm('{{ __('Sahkan order selesai') }}')">
                                                {{ __('Tanda Selesai') }}</x-button>
                                        </form>
                                    </div>
                                @endif
                                @if (auth()->user()->isAdmin && $order->isDone)
                                    <div class="text-right m-5">
                                        <form method="POST" action="/orders/view/{{ $order->id }}/mark-undone">
                                            @csrf
                                            @method('PATCH')
                                            <x-button class="h-10"
                                                onclick="return confirm('{{ __('Sahkan: tanda order tidak selesai') }}')">
                                                {{ __('Tanda Tidak Selesai') }}</x-button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <div
                                class='grid text-sm md:text-base grid-cols-2 md:grid-cols-3 gap-5 items-center justify-center p-5 pb-5'>
                                <a href="/orders/{{ $order->id }}/add-item"
                                    class='w-auto text-center bg-green-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Tambah Item') }}
                                </a>
                                <a href="/orders/view/{{ $order->id }}/edit"
                                    class='w-auto text-center bg-yellow-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Edit Order') }}
                                </a>
                                <div class="grid grid-flow-col gap-3 text-center font-medium text-white">
                                    <div>
                                        <button
                                            class="w-full py-2 text-center bg-gradient-to-r from-purple-600 to-red-500 hover:from-red-600 hover:to-yellow-500 rounded-full shadow-lg"
                                            onclick="window.location='/orders/{{ $order->id }}/invoice'">
                                            INVOIS
                                        </button>
                                    </div>
                                    <div>
                                        <button
                                            class="w-full py-2 text-center bg-gradient-to-r from-purple-600 to-red-500 hover:from-red-600 hover:to-yellow-500 rounded-full shadow-lg"
                                            onclick="window.location='/orders/{{ $order->id }}/delivery-order'">
                                            DO
                                        </button>
                                    </div>
                                </div>
                                <a href="/orders/{{ $order->id }}/payments"
                                    class='w-auto text-center bg-pink-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Bayaran') }}
                                </a>
                                <a href="/orders/view/{{ $order->id }}/pickup"
                                    @if ($order->pickup) onclick = "return confirm('Pickup sudah direkod!\nKemaskini semula?')" @endif
                                    class='w-auto text-center bg-blue-500 hover:bg-gray-700 rounded-lg shadow-xl
                                    font-medium text-white px-4 py-2'>
                                    {{ __('Pickup') }}
                                </a>
                                <a href="/orders"
                                    class='w-auto text-center bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Kembali') }}
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
                                                    {{ __('Item') }}
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Saiz') }}
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('KTT X Harga') }}
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Designer') }}
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Status') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($lists as $list)
                                                @php
                                                    if ($list->price == 0) {
                                                        $alert = $alert + 1;
                                                    } else {
                                                        $alert = $alert;
                                                    }
                                                @endphp
                                                <tr class="cursor-pointer"
                                                    onclick="window.location='/orders/item/{{ $list->id }}'">
                                                    <td class="py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="ml-4">
                                                                <div
                                                                    class="text-sm font-medium {{ $list->is_urgent ? 'text-red-600' : '' }}">
                                                                    {{ $list->product }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="text-center {{ $list->is_urgent ? 'text-red-600' : '' }}">
                                                        {{ $list->size }}
                                                        {{ $list->measurement ? '(' . $list->measurement . ')' : '' }}
                                                    </td>
                                                    <td
                                                        class="text-center {{ $list->is_urgent ? 'text-red-600' : '' }}">
                                                        {{ $list->quantity . ' X ' . RM($list->price) }}</td>
                                                    <td class="flex py-4 justify-center">
                                                        @if ($list->user)
                                                            <img class="h-8 w-8 rounded-full"
                                                                src="{{ asset('storage/' . $list->user->photo) }}"
                                                                title="{{ $list->user->name }}" />
                                                        @endif
                                                    </td>
                                                    <td class="justify-center">
                                                        @if ($list->is_done)
                                                            <span
                                                                class="bg-green-600 font-bold text-white text-center py-1 px-2 text-xs rounded-full">{{ __('Selesai') }}</span>
                                                        @elseif($list->is_printing)
                                                            <span
                                                                class="bg-purple-600 font-bold text-white text-center py-1 px-2 text-xs rounded-full">{{ __('Finishing') }}</span>
                                                        @elseif($list->is_approved)
                                                            <span
                                                                class="bg-yellow-700 font-bold text-white text-center py-1 px-2 text-xs rounded-full">{{ __('Production') }}</span>
                                                        @elseif($list->is_design)
                                                            <span
                                                                class="bg-yellow-400 font-bold text-white text-center py-1 px-2 text-xs rounded-full">{{ __('Design') }}</span>
                                                        @else
                                                            <span
                                                                class="bg-red-500 font-bold text-white text-center py-1 px-2 text-xs rounded-full">
                                                                {{ __('Pending') }} </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 border border-gray-200 rounded-lg shadow-lg p-4 bg-white">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <div>Tambahan: <span
                                class="bg-gray-500 text-sm px-1 rounded-sm text-white cursor-pointer hover:bg-gray-700"
                                onclick="toggleModalShipping()">edit</span></div>
                        <div>Penghantaran: RM{{ RM($order->shipping) }}</div>
                        <div>Diskaun: RM{{ RM($order->discount) }}</div>
                        <div>Jumlah: RM{{ RM($order->grand_total) }}</div>
                    </div>

                    <div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden" id="modal-shipping">
                        <div
                            class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity">
                                <div class="absolute inset-0 bg-gray-900 opacity-75" />
                            </div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                            <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                <form action="/orders/{{ $order->id }}/additional" method="POST">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        @csrf
                                        @method('PATCH')
                                        <label>Caj Penghantaran</label>
                                        <input type="number" step="0.01" class="w-full bg-gray-100 p-2 mt-2 mb-3"
                                            name="shipping" value="{{ RM($order->shipping) }}" />
                                        <label>Jumlah Diskaun</label>
                                        <input type="text" class="w-full bg-gray-100 p-2 mt-2 mb-3"
                                            name="discount" value="{{ RM($order->discount) }}" />
                                    </div>
                                    <div class="bg-gray-200 px-4 py-3 text-right">
                                        <button type="button"
                                            class="py-2 px-4 bg-red-600 text-white rounded hover:bg-gray-700 mr-2"
                                            onclick="toggleModalShipping()"> Batal</button>
                                        <button type="submit"
                                            class="py-2 px-4 bg-green-500 text-white rounded hover:bg-blue-700 mr-2"
                                            @if ($order->paid == $order->grand_total) onclick="return confirm('Pesanan telah dibayar sepenuhnya! Teruskan?  ')" @endif>
                                            Kemaskini</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @if ($alert > 0)
        <script>
            alert_count = {{ $alert }}
            alert('Terdapat ' + alert_count + ' Item Dengan Nilai RM0, kemaskini atau abaikan mesej ini.')
        </script>
    @endif
    <script>
        function toggleModalShipping() {
            document.getElementById('modal-shipping').classList.toggle('hidden')
        }
    </script>
</x-app-layout>
