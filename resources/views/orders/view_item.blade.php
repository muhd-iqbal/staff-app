<x-app-layout>
    <script src="https://unpkg.com/clipboard@2/dist/clipboard.min.js"></script>
    <script type="text/javascript">
        var Clipboard = new ClipboardJS('.btn');

        function copied() {
            let cp = document.getElementById("btn");
            cp.innerHTML = 'Copied!'
            cp.classList.add("bg-gray-300");
            cp.classList.remove("bg-gray-700");
        }
    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Item Pesanan') . ': ' . order_num($item->order_id) }}
        </h2>
    </x-slot>
    <x-modalbox>
        <!--Title-->
        <div class="flex justify-between items-center pb-3">
            <p class="text-2xl font-bold">Perhatian</p>
        </div>
        <!--Body-->
        <div class="my-5">
            <p>Padam item? Item akan dihapus dari rekod.</p>
        </div>
        <!--Footer-->
        <div class="flex justify-end pt-2 gap-2">
            <button class="focus:outline-none modal-close px-4 bg-gray-400 text-black hover:bg-gray-300">Batal</button>
            <form action="/orders/item/{{ $item->id }}/delete" method="POST">
                @csrf
                @method('DELETE')
                <x-button>Padam</x-button>
            </form>
        </div>
    </x-modalbox>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- start component -->
                    <div class="flex items-center justify-center">
                        <div class="grid bg-white rounded-lg shadow-xl w-full">
                            @if (auth()->user()->isAdmin)
                                <div class="text-right" title="Padam Item"><span class=" text-red-500 cursor-pointer"
                                        onclick="openModal()">x</span></div>
                            @endif
                            <div class="">
                                <!-- Trigger -->

                            </div>
                            <div class="m-5 grid md:grid-cols-2">
                                <div class="flex flex-col">
                                    <div class="header flex gap-2">
                                        <h1 class="text-gray-600 font-bold md:text-2xl text-xl">
                                            {{ $item->product }}
                                        </h1>
                                        <button onclick="copied()" id="btn"
                                            class="btn bg-gray-700 text-white p-2 py-1 rounded-md text-sm hover:bg-gray-300 active:bg-gray-700"
                                            data-clipboard-text="{{ order_num($item->order->id) }} - {{ $item->order->customer->name }} {{ $item->order->customer->organisation ? ' - ' . $item->order->customer->organisation : '' }} - {{ $item->product }} {{ $item->size }} ({{ $item->measurement }})">
                                            Copy
                                        </button>
                                    </div>
                                    <div>
                                        <h2 class="text-gray-500 font-bold text-lg">{{ __('PIC: ') }}
                                            {{ $item->user_id ? $item->user->name : 'Tiada' }}</h2>
                                    </div>
                                    <div>
                                        <h2 class="text-gray-500 font-bold text-lg">{{ __('Status: ') }}
                                            {{ $status }}</h2>
                                    </div>
                                    <div>
                                        <h2 class="text-gray-500 font-bold text-lg">{{ __('Tarikh Ambil Alih: ') }}
                                            {{ date('d/m/Y h:i A', strtotime($item->user_id ? $item->is_design_time : 'Tiada')) }} </h2>
                                    </div>
                                    <div class="text-red-500 font-bold text-xl">
                                        {{ $item->is_urgent ? 'URGENT' : '' }}</div>
                                    @if ($item->supplier_id)
                                        @if (auth()->user()->isAdmin)
                                            Subcon:
                                            <div class="form">
                                                <form action="/orders/item/{{ $item->id }}/update-subcon"
                                                    method="POST">
                                                    @csrf
                                                    <select name="supplier_id" id=""
                                                        onchange="showSubmit('supplier-save')">
                                                        </option>
                                                        @foreach ($suppliers as $sub)
                                                            <option value="{{ $sub->id }}"
                                                                {{ $sub->id == $item->supplier_id ? 'selected' : '' }}>
                                                                {{ $sub->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <x-button class="h-10 hidden" id="supplier-save">Simpan
                                                    </x-button>
                                                    <a href="/suppliers/create" id="supplier-add" title="Tambah Subcon"
                                                        class="h-10 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">+</a>
                                                </form>
                                            </div>
                                        @else
                                            {{ __('Subcon: ') . $item->supplier->name }}
                                        @endif

                                    @endif
                                </div>
                                <div class="grid grid-col mt-10 md:mt-0">
                                    <div class="md:text-right">{{ __('Saiz: ') . $item->size }}
                                        ({{ $item->measurement }})</div>
                                    <div class="md:text-right">{{ __('Kuantiti: ') . $item->quantity }}</div>
                                    <div class="md:text-right">
                                        {{ __('Harga: RM') . RM($item->price) }}</div>
                                    <div class="md:text-right">{{ $item->finishing }}</div>

                                    @if($item->status_design) 
                                        <div class="md:text-right">
                                            {{ __('Status Design: ') . ($item->status_design) }}
                                        </div>
                                    @endif
                                    
                                    <div class="justify-self-end">
                                        @php
                                            $log = 'Dibuat: ' . date('d/m/Y h:i A', strtotime($item->created_at));
                                            if ($item->is_design) {
                                                $log .= '\nDesign: ' . date('d/m/Y h:i A', strtotime($item->is_design_time));
                                            }
                                            if ($item->is_approved) {
                                                $log .= '\nApprove: ' . date('d/m/Y h:i A', strtotime($item->is_approved_time));
                                            }
                                            if ($item->is_done) {
                                                $log .= '\nSelesai: ' . date('d/m/Y h:i A', strtotime($item->is_done_time));
                                            }
                                        @endphp
                                        <img class="cursor-pointer" title="Lihat log item"
                                            onclick="openLog('{{ $log }}')"
                                            src="https://img.icons8.com/material-rounded/24/000000/log.png" />
                                    </div>
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
                            <div class="grid grid-cols-1 md:grid-cols-2 mt-5 mx-7">
                                @if (auth()->user()->isAdmin)
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
                                <div
                                    class="my-5 flex {{ auth()->user()->isAdmin ? 'md:flex-row-reverse' : '' }} gap-2">
                                    @if ($item->is_done)
                                        <x-form.confirm-button id="{{ $item->id }}" txt="Print Semula" />
                                        <x-form.single-action action='/orders/item/{{ $item->id }}/design'
                                            title='Design Semula' color='red' />
                                    @elseif($item->is_approved)
                                        <x-form.single-action action='/orders/item/{{ $item->id }}/done'
                                            title='Selesai' color='green' />
                                        <x-form.single-action action='/orders/item/{{ $item->id }}/design'
                                            title='Design Semula' color='red' />
                                    @elseif($item->is_design)
                                        <x-form.confirm-button id="{{ $item->id }}" txt="Confirm Design" />
                                    @else
                                        <div
                                            class="bg-red-500 font-bold text-white text-center py-1 px-2 text-xs rounded-full h-6">
                                            {{ __('Pilih designer di ruangan tugasan') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

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

        window.addEventListener('paste', e => {
            fileInput.files = e.clipboardData.files;
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
