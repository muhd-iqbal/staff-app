<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Item Sticker</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
        html,
        body {
            margin: 0px;
            border: 0px;
            padding: 0px;
            height: 250px;
            text-align: center;
            width: 250px !important;
            max-width: 250px !important;
            overflow: hidden;
        }

        .lebar-3 {
            max-width: 6cm;
        }

    </style>

</head>

<body>

    <section>

        <div class="lebar-3 bg-{{ $item->order->branch->color_code }}-300">
            <div class="font-bold text-lg">{{ $item->product }}</div>
            <div>{{ $item->order->customer->name }}</div>
            <div>{{ $item->size . ' (' . $item->quantity }} UNIT)</div>
        </div>
    </section>
</body>

</html>
