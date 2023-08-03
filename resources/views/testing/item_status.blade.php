<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Item Status: ') . $status }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex flex-col text-left mt-2">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr class="text-center">
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('No') }}</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Pelanggan') }}
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Item') }}
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
                                                    class=" px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Status') }}
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Tarikh Ambil Alih') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @if (count($items))
                                                <?php $count = 1; ?>
                                                @foreach ($items as $list)

                                                    <tr class="text-center cursor-pointer {{ $list->is_urgent ? 'bg-red-500' : '' }}"
                                                        onclick="window.location='/orders/item/{{ $list->id }}'">
                                                        <td class="text-center">
                                                            {{ ($items->currentpage() - 1) * $items->perpage() + $loop->index + 1 }}
                                                        </td>
                                                        <td class="whitespace-nowrap">
                                                            {{ $list->order->customer->name }}
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $list->product }}
                                                            </div>
                                                        </td>
                                                        <td class="text-center">{{ $list->quantity }}</td>
                                                        <td class="flex py-1 justify-center">
                                                            ($list->user->name)
                                                                
                                                            @endif
                                                        </td>
                                                        <td
                                                        class="border-t-0 px-6 text-center align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2">

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
                                                                    class="inline-flex items-center bg-red-600 leading-none text-white rounded-full p-1 shadow text-sm font-bold">
                                                                    <span
                                                                        class="inline-flex text-white rounded-full h-6 w-6 justify-center items-center text-base">{{ $is_pending }}</span>
                                                                </div>
                                                            @endif
                                                            @if ($is_design)
                                                                <div
                                                                    class="inline-flex items-center bg-yellow-400 leading-none text-white rounded-full p-1 shadow text-sm font-bold">
                                                                    <span
                                                                        class="inline-flex text-white bg-yellow-400 rounded-full h-6 w-6 justify-center items-center text-base">{{ $is_design }}</span>
                                                                </div>
                                                            @endif
                                                            @if ($is_approved)
                                                                <div
                                                                    class="inline-flex items-center bg-yellow-700 leading-none text-white rounded-full p-1 shadow text-sm font-bold">
                                                                    <span
                                                                        class="inline-flex text-white bg-yellow-700 rounded-full h-6 w-6 justify-center items-center text-base font-bold">{{ $is_approved }}</span>
                                                                </div>
                                                            @endif
                                                            @if ($is_printing)
                                                                <div
                                                                    class="inline-flex items-center bg-purple-600 leading-none text-white rounded-full p-1 shadow text-sm font-bold">
                                                                    <span
                                                                        class="inline-flex text-white bg-purple-600 rounded-full h-6 w-6 justify-center items-center text-base">{{ $is_printing }}</span>
                                                                </div>
                                                            @endif
                                                            @if ($is_done)
                                                                <div
                                                                    class="inline-flex items-center bg-green-600 leading-none text-white rounded-full p-1 shadow text-sm font-bold">
                                                                    <span
                                                                        class="inline-flex text-white bg-green-600 rounded-full h-6 w-6 justify-center items-center text-base font-bold">{{ $is_done }}</span>
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
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center">{{ __('Tiada item') }}
                                                    </td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        {{ $items->withQueryString()->links() }}
                    </div>
                    @if ($status == 'Production')
                        <div class="flex flex-col-reverse md:flex-row-reverse gap-2 mt-2">
                            <a href="/orders/item/status/is_approved?loc=subcon"
                                class="mr-5 bg-white border border-gray-600 hover:bg-blue-700 hover:text-white text-black font-bold py-2 px-6">Subcon</a>
                            <a href="/orders/item/status/is_approved?loc=guar"
                                class="mr-5 bg-white border border-gray-600 hover:bg-blue-700 hover:text-white text-black font-bold py-2 px-6">Guar</a>
                            <a href="/orders/item/status/is_approved?loc=gurun"
                                class="mr-5 bg-white border border-gray-600 hover:bg-blue-700 hover:text-white text-black font-bold py-2 px-6">Gurun</a>
                            <a href="/print"
                                class="mr-5 bg-white border border-gray-600 hover:bg-blue-700 hover:text-white text-black font-bold py-2 px-6">Print
                                List</a>
                        </div>
                    @endif
                    <div class="mt-5 text-center">
                        <a href="/orders"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            {{ __('Kembali ke senarai pesanan') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>