<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Print List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="py-1">
                        <div class="w-full xl:w-full mb-12 xl:mb-0 px-4 mx-auto mt-5">
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">
                                <div class="rounded-t mb-0 px-4 py-3 border-0">
                                    <div class="flex flex-wrap items-center">
                                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                            <h3 class="font-semibold text-xl text-blueGray-700">
                                                {{ __('Senarai Tugasan') }}</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="block w-full overflow-x-auto">
                                    <table class="items-center bg-transparent w-full border-collapse ">
                                        <thead>
                                            <tr class="text-center">
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                                    {{ __('Pelanggan') }}
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                                    {{ __('Item') }}
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                                    {{ __('Saiz') }}
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                                    {{ __('Kuantiti') }}
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                                    {{ __('Due/Finishing') }}
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if (count($print))
                                                @foreach ($print as $task)

                                                    <tr onclick="window.location='orders/item/{{ $task->id }}';"
                                                        class="hover:bg-gray-100 cursor-pointer text-center">
                                                        <td
                                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap">
                                                            {{ $task->order->customer_name }}
                                                        </td>
                                                        <td
                                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap">
                                                            {{ $task->product }}
                                                        </td>
                                                        <td
                                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap">
                                                            {{ $task->size }}
                                                        </td>
                                                        <td
                                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-2">
                                                            {{ $task->quantity }}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan=4
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                        Tiada.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                    <x-dashboard-link />

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
