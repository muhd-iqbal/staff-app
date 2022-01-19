<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Item') }}
        </h2>
        <x-head.tinymce-config />
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- start component -->
                    <form action="/orders/item/{{ $item->id }}/update" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="flex items-center justify-center">
                            <div class="grid bg-white rounded-lg shadow-xl w-full">

                                <div class="flex justify-center">
                                    <div class="flex">
                                        <h1 class="text-gray-600 font-bold md:text-2xl text-xl"></h1>
                                    </div>
                                </div>

                                @if ($errors->any())
                                    <div class="bg-red-500 mt-5 mx-7">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="grid grid-cols-1 mt-5 mx-7">
                                    <div class="mt-3 grid md:grid-cols-12 gap-3">
                                        <x-form.input name="product" label="Produk" value="{!! $item->product !!}" />
                                        <x-form.input name="price" label="Harga" value="{{ $item->price / 100 }}" />
                                        <x-form.input name="size" label="Saiz" value="{!! $item->size !!}" />
                                        <x-form.input name="finishing" label="Nota / Finishing"
                                            value="{!! $item->finishing !!}" />
                                        <x-form.input name="quantity" label="Kuantiti"
                                            value="{{ $item->quantity }}" />
                                        <div class="col-span-6 mt-5 md:m-7">
                                            <label for="is_urgent" class="relative flex-inline items-center isolate p-4 rounded-2xl">
                                                <input id="is_urgent" type="checkbox" name="is_urgent" class="relative peer z-20 text-red-600 rounded-md focus:ring-0" {{ $item->is_urgent ? 'checked' : '' }}/>
                                                <span class="ml-2 relative z-20 text-red-500 font-bold">URGENT?</span>
                                                <div class="absolute inset-0 bg-white peer-checked:bg-purple-50 peer-checked:border-purple-300 z-10 border rounded-2xl"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 mt-5 mx-7">
                                    <label
                                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold mb-1">Nota</label>

                                    <textarea name="remarks" id="mytextarea"
                                        placeholder="Remarks">{{ $item->remarks }}</textarea>

                                </div>

                                <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                                    <a href="/orders/item/{{ $item->id }}"
                                        class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Batal
                                    </a>
                                    <button
                                        class='w-auto bg-purple-500 hover:bg-purple-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Kemaskini Item
                                    </button>
                                </div>

                            </div>
                        </div> <!-- end components -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
