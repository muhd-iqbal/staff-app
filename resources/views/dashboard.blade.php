<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (auth()->user()->active)
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- component -->
                        <section class="container px-6 py-4 mx-auto">
                            @isset($links_order)
                                <div class="text-gray-700 text-lg mb-2 underline cursor-pointer">Order</div>
                                <div class="grid gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                                    @foreach ($links_order as $title => $link)
                                        <div onclick="window.location='{{ $link }}'"
                                            class="flex items-center p-4 bg-white border-2 border-gray-200 rounded-lg shadow-sm cursor-pointer hover:bg-gray-100">
                                            <div>
                                                <p class="text-base font-normal text-gray-800">{{ $title }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endisset
                            @isset($links_acc)
                                <div class="text-gray-700 text-lg mb-2 underline cursor-pointer">Maklumat Akaun</div>
                                <div class="grid gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                                    @foreach ($links_acc as $title => $link)
                                        <div onclick="window.location='{{ $link }}'"
                                            class="flex items-center p-4 bg-white border-2 border-gray-200 rounded-lg shadow-sm cursor-pointer hover:bg-gray-100">
                                            <div>
                                                <p class="text-base font-normal text-gray-800">{{ $title }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endisset
                            @isset($links_admin)
                                <div class="text-gray-700 text-lg mb-2 underline cursor-pointer">Admin Sahaja</div>
                                <div class="grid gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                                    @foreach ($links_admin as $title => $link)
                                        <div onclick="window.location='{{ $link }}'"
                                            class="flex items-center p-4 bg-white border-2 border-gray-200 rounded-lg shadow-sm cursor-pointer hover:bg-gray-100">
                                            <div>
                                                <p class="text-base font-normal text-gray-800">{{ $title }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endisset
                            @isset($links_staff)
                                <div class="text-gray-700 text-lg mb-2 underline cursor-pointer">Lain-lain</div>
                                <div class="grid gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                                    @foreach ($links_staff as $title => $link)
                                        <div onclick="window.location='{{ $link }}'"
                                            class="flex items-center p-4 bg-white border-2 border-gray-200 rounded-lg shadow-sm cursor-pointer hover:bg-gray-100">
                                            <div>
                                                <p class="text-base font-normal text-gray-800">{{ $title }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endisset
                        </section>
                    </div>
                @else
                    <p class="text-red-500">{{ __('Akaun anda tidak aktif, sila hubungi admin.') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
