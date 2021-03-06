<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Tugasan') }}
        </h2>
    </x-slot>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

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
                                    <table id="dataTable" class="items-center bg-transparent w-full border-collapse">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center">
                                                    {{ __('No') }}
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                    {{ __('Tarikh') }}
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                    {{ __('Pelanggan') }}
                                                </th>
                                                <th
                                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-base uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                    {{ __('Item') }}
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if (count($prev))
                                                @foreach ($prev as $task)

                                                    <tr onclick="window.location='/orders/item/{{ $task->id }}';"
                                                        class="hover:bg-gray-100 cursor-pointer">
                                                        <th
                                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                            {{ order_num($task->order->id) }}
                                                        </th>
                                                        <td
                                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                            {{ date('D d/m/Y', strtotime($task->order->created_at)) }}
                                                        </td>
                                                        <td
                                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                            {{ $task->order->customer->name }}
                                                        </td>
                                                        <td
                                                            class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                            {{ $task->product }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan=4
                                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                                                        Tiada tugasan yang diberikan.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{ $prev->links() }}
                        </div>
                    </section>
                    <div class="grid justify-items-center grid-cols-1">
                        <div class="flex items-center">
                            <a href="/to-do"
                                class="border py-2 px-4 rounded-lg bg-yellow-500 text-white ">Tugasan semasa</a>
                            <x-dashboard-link />
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

        });
    </script>
</x-app-layout>
