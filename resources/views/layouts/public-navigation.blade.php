<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Title -->
            <div class="flex items-center">
                <a href="{{ route('quizzes.index') }}" class="flex items-center">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    <span class="ml-3 text-lg font-semibold text-gray-800 dark:text-gray-200">Quizzes</span>
                </a>
            </div>

            <!-- Right side of Navbar -->
            <div class="flex items-center ml-6">
                @auth
                    {{-- Show Admin Panel link only if the user is an admin --}}
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.quizzes.index') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Admin Panel</a>
                    @endif

                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                        @csrf
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>