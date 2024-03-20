<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight print:hidden">
            {{ __('Print List') }}
        </h2>
    </x-slot>
    <style>
        @media print {
            body * {
                visibility: hidden;
            } 

            #section-to-print,
            #section-to-print * {
                visibility: visible;
            }

            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }

    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="py-1">
                        <div class="w-full xl:w-full mb-12 xl:mb-0 px-4 mx-auto mt-5">
                            <div class="text-lg font-bold">{{ $print->count() }} item</div>
                            <div class="text-right mb-2">
                                <button type="button" onclick="print()"
                                    class="bg-green-500 text-white p-2 px-4 rounded-md shadow-md hover:bg-green-700">Print List</button>
                            </div>

                            <form action="/print/all-stickers">
                                <div id="section-to-print"
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
                                                        {{ __('Bil') }}
                                                    </th>
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
                                                        {{ __('Qty') }}
                                                    </th>
                                                    <th
                                                        class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                                        {{ __('Due/Finishing') }}
                                                    </th>
                                                    <th class="text-right pr-2 print:hidden"><input type="checkbox"
                                                            onclick="toggle(this);" title="Tanda Semua" /></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if (count($print))
                                                    @foreach ($print as $task)
                                                        <tr onclick="window.location='orders/item/{{ $task->id }}';"
                                                            class="hover:bg-gray-100 cursor-pointer text-center  {{ $task->is_urgent ? 'bg-red-500' : '' }}">
                                                            <td
                                                                class="border-t-2 px-2 align-middle border-l-0 border-r-0 text-xs">
                                                            {{ ($task->currentpage() - 1) * $task->perpage() + $loop->index + 1 }}
                                                            </td>
                                                            
                                                            <td
                                                                class="border-t-2 px-2 align-middle border-l-0 border-r-0 text-xs">
                                                                {{ $task->order->customer->name }}
                                                            </td>
                                                            <td
                                                                class="border-t-2 px-2 align-middle border-l-0 border-r-0 text-xs">
                                                                {{ $task->product }}
                                                            </td>
                                                            <td
                                                                class="border-t-2 px-2 align-middle border-l-0 border-r-0 text-xs">
                                                                {{ $task->size }} ({{ $task->measurement }})
                                                            </td>
                                                            <td
                                                                class="border-t-2 px-2 align-middle border-l-0 border-r-0 text-xs p-2">
                                                                {{ $task->quantity }}
                                                            </td>
                                                            <td
                                                                class="border-t-2 px-2 align-middle border-l-0 border-r-0 text-xs p-2">
                                                                {{ $task->finishing }}
                                                            </td>
                                                            <td class="border-t-2 cursor-pointer flex items-center gap-1 print:hidden"
                                                                onclick=event.stopPropagation()>
                                                                <img src="https://img.icons8.com/material-outlined/24/000000/print.png"
                                                                    onclick="window.location='/items/print-sticker/{{ $task->id }}'" />
                                                                <input type="checkbox" name="item_id[]"
                                                                    value="{{ $task->id }}">
                                                            <td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan=4
                                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                            Tiada.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="flex flex-row-reverse">
                                    <input type="image"
                                        src="https://img.icons8.com/material-outlined/24/000000/print.png" border="0"
                                        alt="Submit" />
                                </div>
                            </form>
                        </div>
                    </section>

                    <div class='flex gap-5 items-center justify-center p-5 pb-5'>
                        <a href="/print-list" target="_blank"
                            class='w-auto bg-yellow-500 hover:bg-yellow-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            {{ __('Ke halaman cetak') }}
                        </a>
                        <a href="/"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            {{ __('Kembali ke senarai pesanan') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggle(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }
    </script>
</x-app-layout>
