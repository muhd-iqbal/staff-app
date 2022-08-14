<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            @if ($bday)
                <div class="text-right">
                    <form action="/easter" method="POST">
                        @csrf
                        <button class="bg-yellow-500 px-2 py-1 rounded-md shadow-md hover:bg-yellow-400">Stop
                            Video</button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    @if ($bday)
        @include('birthday-easter')
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (auth()->user()->active)
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- component -->
                        <section class="container px-6 py-4 mx-auto z-50 relative">
                            @isset($links_order)
                                <div class="text-gray-900 text-lg mb-2 underline"><span
                                        class="bg-white px-2">Order</span></div>
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
                                <div class="text-gray-900 text-lg mb-2 underline"><span
                                        class="bg-white px-2">Maklumat Akaun</span></div>
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
                                <div class="text-gray-900 text-lg mb-2 underline"><span
                                        class="bg-white px-2">Admin Sahaja</span></div>
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
                                <div class="text-gray-900 text-lg mb-2 underline"><span
                                        class="bg-white px-2">Lain-lain</span></div>
                                <div class="grid gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                                    @foreach ($links_staff as $title => $link)
                                        <div onclick="window.location='{{ $link }}'"
                                            class="flex items-center p-4 bg-white border-2 border-gray-200 rounded-lg shadow-sm cursor-pointer hover:bg-gray-100">
                                            <div>
                                                <p class="text-base font-normal text-gray-800">{{ $title }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    <form action="{{ config('auth.tie_web') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="email" id="email"
                                            value="{{ config('auth.tie_username') }}">
                                        <input type="hidden" name="password" id="password"
                                            value="{{ config('auth.tie_pass') }}">
                                        <button type="submit"
                                            class="flex items-center p-4 bg-white border-2 border-gray-200 rounded-lg shadow-sm cursor-pointer hover:bg-gray-100 w-full">
                                            <div>
                                                <p class="text-base font-normal text-gray-800">Admin Tie</p>
                                            </div>
                                        </button>
                                    </form>
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
