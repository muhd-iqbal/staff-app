<x-agent-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('IMAGE: ') . $item->product }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="container mx-auto p-6">
                    <div>
                        <a href="/agent/order/{{ $order->id }}" class="text-blue-600">
                            << Kembali ke order</a>
                    </div>
                    <div class="text-right mb-5">
                        <form action="/agent/item/{{ $item->id }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="picture" id="picture" required>
                            <button type="submit"
                                class="bg-green-600 px-2 py-1 rounded-md shadow-md text-white hover:bg-green-900">Tambah
                                Gambar</button>
                        </form>
                    </div>
                    <h2 class="text-lg text-center">Senarai Gambar</h2>
                    <div class="container px-5 py-2 mx-auto lg:pt-12 lg:px-32">
                        <div class="-m-1 md:-m-2">
                            @foreach ($item->order_pictures as $pic)
                                <div class="flex flex-wrap ">
                                    <div class="w-full p-1 md:p-2">
                                        <img alt="gallery"
                                            class="block object-cover object-center w-full h-full rounded-lg"
                                            src="{{ asset('storage/' . $pic->picture) }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-agent-layout>
