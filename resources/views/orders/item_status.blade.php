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
                    <!-- end components -->

                    <div class="flex flex-col text-left mt-2">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
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
                                                    class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Status') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($items as $list)

                                                <tr class="cursor-pointer"
                                                    onclick="window.location='/orders/item/{{ $list->id }}'">
                                                    <td class="py-4 whitespace-nowrap">
                                                        <div class="ml-4">
                                                            <div class="flex items-center">
                                                                {{ $list->order->customer_name }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $list->product }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">{{ $list->quantity }}</td>
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
                                                                class="bg-green-600 font-bold text-white text-center py-1 px-2 text-xs rounded-full">
                                                                {{ __('Selesai') }}</span>
                                                        @elseif($list->is_printing)
                                                            <span
                                                                class="bg-purple-600 font-bold text-white text-center py-1 px-2 text-xs rounded-full">
                                                                {{ __('Finishing') }}</span>
                                                        @elseif($list->is_approved)
                                                            <span
                                                                class="bg-yellow-700 font-bold text-white text-center py-1 px-2 text-xs rounded-full">
                                                                {{ __('Production') }}</span>
                                                        @elseif($list->is_design)
                                                            <span
                                                                class="bg-yellow-400 font-bold text-white text-center py-1 px-2 text-xs rounded-full">
                                                                {{ __('Design') }}</span>
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