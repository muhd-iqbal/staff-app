<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

</head>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
<style>
    @page {
        size: A5
    }

</style>
<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A5 landscape">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <div class="block w-full overflow-x-auto">
            <table class="items-center bg-transparent w-full border-collapse ">
                <thead>
                    <tr class="text-center bg-gray-300">
                        <th class="align-middle border border-solid border-black text-sm uppercase font-semibold">
                            {{ __('Pelanggan') }}
                        </th>
                        <th class="align-middle border border-solid border-black text-sm uppercase font-semibold">
                            {{ __('Item') }}
                        </th>
                        <th class="align-middle border border-solid border-black text-sm uppercase font-semibold">
                            {{ __('Saiz') }}
                        </th>
                        <th class="align-middle border border-solid border-black text-sm uppercase font-semibold">
                            {{ __('Kuantiti') }}
                        </th>
                        <th class="align-middle border border-solid border-black text-sm uppercase font-semibold">
                            {{ __('Due/Finishing') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td colspan="5"
                            class="bg-gray-50 border border-solid border-black align-middle text-center text-sm whitespace-nowrap">
                            GURUN
                        </td>
                    </tr>
                    @if (count($print))
                        @foreach ($print as $task)
                            @if ($task->order->location == 'gurun')

                                <tr class="text-center {{ $task->is_urgent ? 'bg-red-500' : '' }}">
                                    <td class="border border-solid border-black align-middle text-sm whitespace-nowrap">
                                        {{ $task->order->customer_name }}
                                    </td>
                                    <td class="border border-solid border-black align-middle text-sm whitespace-nowrap">
                                        {{ $task->product }}
                                    </td>
                                    <td class="border border-solid border-black align-middle text-sm whitespace-nowrap">
                                        {{ $task->size }}
                                    </td>
                                    <td class="border border-solid border-black align-middle text-sm whitespace-nowrap">
                                        {{ $task->quantity }}
                                    </td>
                                    <td class="border border-solid border-black align-middle text-sm whitespace-nowrap">
                                        {{ $task->finishing }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td colspan="5"
                                class="bg-gray-50 border border-solid border-black align-middle text-center text-sm whitespace-nowrap">
                                GUAR
                            </td>
                        </tr>
                        @foreach ($print as $task)
                            @if ($task->order->location == 'guar')

                                <tr class="text-center {{ $task->is_urgent ? 'bg-red-500' : '' }}">
                                    <td class="border border-solid border-black align-middle text-sm whitespace-nowrap">
                                        {{ $task->order->customer_name }}
                                    </td>
                                    <td class="border border-solid border-black align-middle text-sm whitespace-nowrap">
                                        {{ $task->product }}
                                    </td>
                                    <td class="border border-solid border-black align-middle text-sm whitespace-nowrap">
                                        {{ $task->size }}
                                    </td>
                                    <td class="border border-solid border-black align-middle text-sm whitespace-nowrap">
                                        {{ $task->quantity }}
                                    </td>
                                    <td class="border border-solid border-black align-middle text-sm whitespace-nowrap">
                                        {{ $task->finishing }}
                                    </td>
                                </tr>
                            @endif
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

    </section>

</body>

</html>
{{-- <div class="py-12">
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
</div> --}}
