<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- start component -->
                    <div class="flex items-center justify-center">
                        <div class="grid bg-white rounded-lg shadow-xl w-full">
                            <div class="m-5 grid md:grid-cols-2">
                                <div class="flex flex-col">
                                    <div class="header flex gap-2">
                                        <h1 class="text-gray-600 font-bold md:text-2xl text-xl">
                                            {{ $item->product }}
                                        </h1>
                                    </div>
                                </div>
                                <div class="grid grid-col mt-10 md:mt-0">
                                    <div class="md:text-right">{{ __('Saiz: ') . $item->size }}
                                        ({{ $item->measurement }})</div>
                                    <div class="md:text-right">{{ __('Kuantiti: ') . $item->quantity }}</div>
                                    <div class="md:text-right">
                                        {{ __('Harga: RM') . RM($item->price) }}</div>
                                </div>
                            </div>
                            <div class='flex gap-5 items-center justify-center p-5 pb-5'>
                                <a href="/quote/{{ $quote->id }}/list/{{ $list->id }}"
                                    class='w-auto bg-yellow-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Edit item') }}
                                </a>
                                <a href="/quote/{{ $quote->id }}"
                                    class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Kembali ke senarai pesanan') }}
                                </a>
                            </div>
                        </div>
                    </div> <!-- end components -->
                    <div class="mt-5 flex justify-between">
                        <div class="p-5">
                            @if (count($pictures))
                                <h2 class="text-xl font-bold">{{ __('Senarai gambar') }}</h2>
                            @endif
                        </div>
                        <div class="">
                            <form action="/orders/item/{{ $item->id }}/foto" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <x-form.input name="picture" label="{{ __('Muat Naik Foto:') }}" type="file"
                                    id="picture" />
                                <x-button class="mt-2">{{ __('Muat naik') }}</x-button>
                            </form>
                        </div>
                    </div>
                    <div class="mt-3">
                        @foreach ($pictures as $pic)
                            <div class="relative mb-2">
                                <img src="{{ asset('storage/' . $pic->picture) }}" alt=""
                                    class="w-full p-2 border">
                                <form action="/orders/item/picture/{{ $pic->id }}/del" method="POST">
                                    @csrf
                                    <button
                                        class="absolute top-5 right-5 bg-red-500 p-2 py-1 text-white rounded hover:bg-red-400"
                                        onclick="return confirm('Padam foto?')">x</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const form = document.getElementById("picture");
        const fileInput = document.getElementById("picture");

        fileInput.addEventListener('change', () => {
            form.submit();
        });

        function showSubmit(id) {
            var x = document.getElementById(id);
            x.style.display = "inline-block";
        }

        function openLog(item) {
            alert(item);
        }
    </script>
</x-app-layout>
