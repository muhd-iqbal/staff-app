<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Order') }}
        </h2>
    </x-slot>
    <x-modalbox action='/orders/{{ $order->id }}/delete' text='Padam order? Setiap item perlu dipadam terlebih dahulu.' />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- start component -->
                    <div class="flex items-center justify-center">
                        <div class="grid bg-white rounded-lg shadow-xl w-full">
                            @if (auth()->user()->isAdmin)
                            <div class="text-right" title="Padam Order"><span class=" text-red-500 cursor-pointer" onclick="openModal()">x</span></div>
                            @endif
                            <div class="flex flex-col items-center">
                                <div class="flex">
                                    <h1 class="text-gray-600 font-bold md:text-2xl text-xl">{{ __('Pesanan:') }}
                                        {{ \App\Http\Controllers\Controller::order_num($order->id) }}</h1>
                                    <a href="{{ 'https://wa.me/6' . $order->customer_phone }}">
                                        <img src="https://cdn.cdnlogo.com/logos/w/29/whatsapp-icon.svg" width="30"></a>
                                </div>
                                <div>
                                    <h2 class="text-gray-500 font-bold md:text-xl text-lg">
                                        {{ ucwords($order->method) }}
                                        ({{ ucwords($order->location) }})</h2>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2">
                                <div class="mt-5 mx-7">
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        {{ __('Nama Pelanggan: ') . $order->customer_name }}
                                    </div>
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        {{ __('No Telefon: ') . $order->customer_phone }}
                                    </div>
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        {{ __('Tarikh pesanan: ') . date('d/m/Y', strtotime($order->date)) }}
                                    </div>
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        {{ __('Deadline: ') }}
                                        @if ($order->deadline)
                                            {{ date('d/m/Y', strtotime($order->deadline)) }}
                                        @endif
                                    </div>
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
                            <div class='grid grid-rows md:grid-cols-3 gap-5 items-center justify-center p-5 pb-5'>
                                {{-- @if (!$order->isDone) --}}
                                <a href="/orders/{{ $order->id }}/add-item"
                                    class='w-auto bg-green-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Tambah Item') }}
                                </a>
                                {{-- @endif --}}
                                <a href="/orders/view/{{ $order->id }}/edit"
                                    class='w-auto bg-yellow-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Edit Order') }}
                                </a>
                                {{-- @endif --}}
                                <a href="/orders"
                                    class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Kembali ke senarai pesanan') }}
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
                                                    {{ __('Kuantiti') }}
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

                                                <tr class="cursor-pointer"
                                                    onclick="window.location='/orders/item/{{ $list->id }}'">
                                                    <td class="py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium {{ $list->is_urgent?'text-red-600':'' }}">
                                                                    {{ $list->product }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center {{ $list->is_urgent?'text-red-600':'' }}">{{ $list->size }}</td>
                                                    <td class="text-center {{ $list->is_urgent?'text-red-600':'' }}">{{ $list->quantity }}</td>
                                                    <td class="flex py-4 justify-center">
                                                        @if ($list->user)
                                                            <img class="h-10 w-10 rounded-full"
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
                    {{-- End Details --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
