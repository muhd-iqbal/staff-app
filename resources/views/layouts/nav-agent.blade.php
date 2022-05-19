<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/agent">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="sm:flex sm:items-center sm:ml-6 mt-2">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <a href="{{ route('agent.logout')}}"
                            class="flex bg-red-600 p-2 text-white items-center text-sm font-medium rounded-md hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                            >
                            <div>Log Keluar</div>

                        </a>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <x-dropdown-link href="/profile">{{ __('Maklumat') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('agent.logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('agent.logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="/profile">{{ __('Maklumat Peribadi') }}</x-responsive-nav--link>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('agent.logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('agent.logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
            </div>
        </div>
    </div>
</nav>
