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
                                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('No') }}</th>
                                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Pelanggan') }}</th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Item') }}</th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Saiz') }}</th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Kuantiti') }}</th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Designer') }}</th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Subcon') }}
                                                    <form method="GET" action="">
                                                        <select name="subcon" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-xs" onchange="this.form.submit()">
                                                            <option value="">{{ __('Semua Subcon') }}</option>
                                                            @foreach($subcons as $subcon)
                                                                <option value="{{ $subcon->id }}" {{ request('subcon') == $subcon->id ? 'selected' : '' }}>
                                                                    {{ $subcon->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @foreach(request()->except('subcon') as $key => $value)
                                                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                                        @endforeach
                                                    </form>
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Note') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @if (count($items))
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
                                                        <td class="text-center">
                                                            {{ $list->size }}
                                                            {{ $list->measurement ? '(' . $list->measurement . ')' : '' }}
                                                        </td>
                                                        <td class="text-center">{{ $list->quantity }}</td>
                                                        <td class="flex py-1 justify-center">
                                                            @if ($list->user)
                                                                <img class="h-5 w-5 rounded-full"
                                                                    src="{{ asset('storage/' . $list->user->photo) }}"
                                                                    title="{{ $list->user->name }}" />
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($list->supplier_id)
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $list->supplier->name }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <!-- Note column: more visible style -->
                                                        <td class="text-center">
                                                            <form method="POST" action="{{ route('orders.item.note', $list->id) }}" onclick="event.stopPropagation();">
                                                                @csrf
                                                                <textarea name="note" rows="2" class="border-2 border-blue-400 rounded w-full text-xs font-semibold bg-yellow-100 p-2 text-blue-900" style="resize:vertical;" onclick="event.stopPropagation();">{{ $list->note ?? '' }}</textarea>
                                                                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white px-2 py-1 rounded text-xs mt-1 font-bold shadow" onclick="event.stopPropagation();">Save</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" class="text-center">{{ __('Tiada item') }}</td>
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
                        <!-- Clean, visible print section -->
                        <div class="flex flex-wrap justify-center gap-4 mt-6">
                            <a href="/orders/item/status/is_approved?loc=subcon"
                                class="bg-white border-2 border-blue-500 hover:bg-blue-600 hover:text-white text-blue-700 font-bold py-2 px-8 rounded-lg shadow transition">
                                Subcon
                            </a>
                            <a href="/orders/item/status/is_approved?loc=2"
                                class="bg-white border-2 border-blue-500 hover:bg-blue-600 hover:text-white text-blue-700 font-bold py-2 px-8 rounded-lg shadow transition">
                                Guar
                            </a>
                            <a href="/orders/item/status/is_approved?loc=1"
                                class="bg-white border-2 border-blue-500 hover:bg-blue-600 hover:text-white text-blue-700 font-bold py-2 px-8 rounded-lg shadow transition">
                                Gurun
                            </a>
                            <a href="/print"
                                class="bg-gradient-to-r from-green-400 to-blue-500 border-2 border-green-500 hover:from-green-600 hover:to-blue-700 hover:text-white text-white font-bold py-2 px-8 rounded-lg shadow transition">
                                Print List
                            </a>
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
