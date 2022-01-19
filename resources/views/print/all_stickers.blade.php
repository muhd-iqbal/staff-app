<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Stickers</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }

        page[size="A4"] {
            width: 21cm;
            height: 29.7cm;
        }

        @media print {

            body,
            page {
                margin: 0;
                box-shadow: 0;
            }
        }

    </style>
</head>

<body>
    <page size="A4">
        <div class="grid grid-cols-3 items-start text-center gap-2">

            @foreach ($items as $item)

                @switch($item->order->location)
                    @case('gurun')

                        <div class="lebar-3 bg-purple-300">
                    @break
                    @case('guar')

                        <div class="lebar-3 bg-pink-300">
                    @break
                @endswitch
                <div class="font-bold text-lg">{{ $item->product }}</div>
                <div>{{ $item->order->customer->name }}</div>
                <div>{{ $item->size . ' (' . $item->quantity }} UNIT)</div>
        </div>

        @endforeach
        </div>
    </page>
</body>

</html>
