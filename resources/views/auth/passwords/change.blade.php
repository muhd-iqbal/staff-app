<x-dashboard-link />
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <x-application-logo class="w-40 h-40 fill-current text-gray-500" />
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div>
            <div>
                <div>
                    <div>
                        <div>{{ __('Tukar Kata Laluan') }}</div>

                        <div>
                            <form method="POST" action="{{ route('password.change') }}">
                                @csrf

                                <div class="mt-4">
                                    <x-label for="password" :value="__('Kata Laluan Baru')" />

                                    <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                        required />
                                </div>

                                <div class="mt-4">
                                    <x-label for="password-confirm" :value="__('Masukkan Semula Kata Laluan Baru')" />

                                    <x-input id="password-confirm" class="block mt-1 w-full" type="password"
                                        name="password_confirmation" required />
                                </div>

                                <x-button class="mt-4"> {{ __('Reset Password') }}</x-button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>
