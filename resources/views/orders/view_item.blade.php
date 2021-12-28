<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Item Pesanan') . ': ' . \App\Http\Controllers\Controller::order_num($item->order_id) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- start component -->
                    <div class="flex items-center justify-center">
                        <div class="grid bg-white rounded-lg shadow-xl w-full">
                            <div class="m-5 grid md:grid-cols-2">
                                <div class="flex flex-col">
                                    <div class="header">
                                        <h1 class="text-gray-600 font-bold md:text-2xl text-xl">{{ __('Item: ') }}
                                            {{ $item->product }}</h1>
                                    </div>
                                    <div>
                                        <h2 class="text-gray-500 font-bold md:text-xl text-lg">{{ __('Status: ') }}
                                            {{ $status }}</h2>
                                    </div>
                                    <div class="text-red-500 font-bold text-xl">
                                        {{ $item->is_urgent ? 'URGENT' : '' }}</div>
                                </div>
                                <div class="flex flex-col md:flex-col mt-5 md:mt-0">
                                    <div class="md:text-right">{{ __('Saiz: ') . $item->size }}</div>
                                    <div class="md:text-right">{{ __('Kuantiti: ') . $item->quantity }}</div>
                                    <div class="md:text-right">
                                        {{ __('Harga: RM') . number_format($item->price / 100, 2) }}</div>
                                    <div class="md:text-right">{{ $item->finishing }}</div>

                                </div>
                            </div>
                            @if ($item->remarks)
                                <div class="mt-5 mx-7">
                                    <div
                                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold border p-2">
                                        {!! $item->remarks !!}
                                    </div>
                                </div>
                            @endif
                            <hr class="mt-10 mx-10" />
                            @if (auth()->user()->isAdmin)
                                <div class="grid grid-cols-1 md:grid-cols-2 mt-5 mx-7">
                                    <div class="mb-5">
                                        <form action="/orders/item/{{ $item->id }}/user" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <label for="user_id">{{ __('Tugasan: ') }}</label><br />
                                            @error('user_id')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                            <select name="user_id" id="user_id" class="" required>
                                                <option selected disabled>{{ __('Pilih staf') }}</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ $user->id == $item->user_id ? 'selected' : '' }}
                                                        {{ $item->isPrinting ? 'disabled' : '' }}>
                                                        {{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-button class="h-10">{{ __('Simpan') }}</x-button>
                                        </form>
                                    </div>
                                    <div class="my-5 flex md:flex-row-reverse gap-2">
                                        @if ($item->is_done)
                                            <x-form.single-action action='/orders/item/{{ $item->id }}/approved'
                                                title='Print Semula' color='red' />
                                            <x-form.single-action action='/orders/item/{{ $item->id }}/design'
                                                title='Design Semula' color='red' />
                                        @elseif($item->is_printing)
                                            <x-form.single-action action='/orders/item/{{ $item->id }}/done'
                                                title='Item Selesai' color='green' />
                                            <x-form.single-action action='/orders/item/{{ $item->id }}/design'
                                                title='Design Semula' color='red' />
                                        @elseif($item->is_approved)
                                            <x-form.single-action action='/orders/item/{{ $item->id }}/printing'
                                                title='Selesai Print' color='green' />
                                            <x-form.single-action action='/orders/item/{{ $item->id }}/design'
                                                title='Design Semula' color='red' />
                                        @elseif($item->is_design)
                                            <x-form.single-action action='/orders/item/{{ $item->id }}/approved'
                                                title='Confirm Design' color='green' />
                                        @else
                                            <div
                                                class="bg-red-500 font-bold text-white text-center py-1 px-2 text-xs rounded-full h-6">
                                                {{ __('Pilih designer di ruangan tugasan') }}
                                            </div>
                                        @endif
                                        {{-- <x-form.single-action action='/orders/item/{{ $item->id }}/design'
                                            title='Design Process' />
                                        <x-form.single-action action='/orders/item/{{ $item->id }}/approved'
                                            title='Hantar Ke Production' />
                                        <x-form.single-action action='/orders/item/{{ $item->id }}/printing'
                                            title='Selesai Print' />
                                        <x-form.single-action action='/orders/item/{{ $item->id }}/done'
                                            title='Item Selesai' /> --}}
                                    </div>
                                </div>
                            @else
                                @unless(auth()->user()->id == $item->user_id)
                                    <div class="w-full m-5">
                                        <div class="mb-5">
                                            <form action="/orders/item/{{ $item->id }}/takeover" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <x-button onclick="return confirm('Sahkan ambil alih design')">
                                                    {{ __('Ambil Alih') }}</x-button>
                                            </form>
                                        </div>
                                    </div>
                                @endunless
                            @endif
                            <div class='flex gap-5 items-center justify-center p-5 pb-5'>
                                <a href="/orders/item/{{ $item->id }}/edit"
                                    class='w-auto bg-yellow-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Edit item') }}
                                </a>
                                <a href="/orders/view/{{ $item->order_id }}"
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
                                <x-form.input name="picture" label="{{ __('Muat Naik Foto:') }}" type="file" />
                                <x-button class="mt-2">{{ __('Muat naik') }}</x-button>
                            </form>
                        </div>
                    </div>
                    <div class="mt-3">
                        @foreach ($pictures as $pic)
                            <img src="{{ asset('storage/' . $pic->picture) }}" alt="" class="w-full p-5 border">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
