<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div class="text-xl font-bold uppercase my-5"> Log Masuk Ejen</div>
            <a href="/">
                <x-application-logo class="w-40 h-40 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="/agent/login">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="id" :value="__('Nama Agen')" />

                <select id="id"
                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    name="id" required autofocus>
                    <option selected disabled>Nama Agen</option>
                    @foreach ($agents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Ingat sesi') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-button class="ml-3">
                    {{ __('Log Masuk') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
    @if (session()->has('forbidden'))
        <div id="flash"
            class="absolute z-50 top-0 left-0 right-0 bg-red-500 text-center leading-10 overflow-hidden shadow-md">
            <p>{!! session('forbidden') !!}</p>
        </div>
    @endif
</x-guest-layout>
