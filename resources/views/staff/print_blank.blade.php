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
                    <tr class="text-center bg-gray-300 text-sm">
                        <th class="align-middle border border-solid border-black uppercase font-semibold">
                            {{ __('Pelanggan') }}
                        </th>
                        <th class="align-middle border border-solid border-black uppercase font-semibold">
                            {{ __('Item') }}
                        </th>
                        <th class="align-middle border border-solid border-black uppercase font-semibold">
                            {{ __('Saiz') }}
                        </th>
                        <th class="align-middle border border-solid border-black uppercase font-semibold">
                            {{ __('Kuantiti') }}
                        </th>
                        <th class="align-middle border border-solid border-black uppercase font-semibold">
                            {{ __('Due/Finishing') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($print))
                    @foreach ($branches as $branch)
                    <tr>
                        <td colspan="5"
                            class="bg-gray-50 border border-solid border-black align-middle text-center text-sm whitespace-nowrap">
                            {{ strtoupper($branch->shortname) }}
                        </td>
                    </tr>
                        @foreach ($print as $task)
                            @if ($task->order->branch_id == $branch->id)

                                <tr class="text-center {{ $task->is_urgent ? 'bg-red-500' : '' }} text-xs">
                                    <td class="border border-solid border-black align-middle whitespace-nowrap">
                                        {{ $task->order->customer->name }}
                                    </td>
                                    <td class="border border-solid border-black align-middle whitespace-nowrap">
                                        {{ $task->product }}
                                    </td>
                                    <td class="border border-solid border-black align-middle whitespace-nowrap">
                                        {{ $task->size }}
                                    </td>
                                    <td class="border border-solid border-black align-middle whitespace-nowrap">
                                        {{ $task->quantity }}
                                    </td>
                                    <td class="border border-solid border-black align-middle whitespace-nowrap">
                                        {{ $task->finishing }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
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

    </section>

</body>

</html>
