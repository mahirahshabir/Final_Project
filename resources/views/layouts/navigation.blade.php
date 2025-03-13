<nav class="bg-gray-900 p-2 text-white flex justify-between items-center">
{{-- < x-data="{ open: false }" class="bg-white border-b border-gray-100"> --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center">  <!-- Flex container -->

            <!-- Navigation Links - Aligned to the Right -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>



                <!-- Projects Dropdown -->
                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                            <div>Projects</div>
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('projects.index')">All Projects</x-dropdown-link>
                        <x-dropdown-link :href="route('projects.create')">Create Project</x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                <!-- Assignees Dropdown -->
                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                            <div>Assignees</div>
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('assignees.index')">All Assignees</x-dropdown-link>
                        <x-dropdown-link :href="route('assignees.create')">Assign User</x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                <!-- User Profile & Settings -->
                {{-- <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                            <div>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        @if(Auth::check())
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('login')">{{ __('Login') }}</x-dropdown-link>
                        @endif
                    </x-slot>
                </x-dropdown> --}}
            </div>

            <!-- Hamburger -->
            {{-- <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div> --}}
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ optional(Auth::user())->name ?? 'Guest' }}</div>
                <div class="font-medium text-sm text-gray-500">{{ optional(Auth::user())->email ?? 'Not logged in' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

        <!-- Right Side: Settings Dropdown -->
        <div class="relative">
            <!-- Settings Button -->
            <button id="settings-btn" class="flex items-center gap-2 px-4 py-2 bg-gray-700 rounded-lg hover:bg-gray-600 focus:outline-none">
                ⚙️ Settings
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <!-- Settings Dropdown -->
           <div id="settings-menu" class="hidden absolute right-0 mt-2 w-48 bg-white text-black rounded-lg shadow-lg">
            <a href="{{ route('phases.show') }}" class="block w-full text-left px-4 py-2 hover:bg-gray-200">
                ➕ Manage Phases
            </a>
             <a href="{{route('custom-fields.index')}}" class="block px-4 py-2 hover:bg-gray-200">📑 Custom Fields</a>
         </div>

            <!-- Dropdown Menu -->
            {{-- <div id="settings-menu" class="hidden absolute right-0 mt-2 w-48 bg-white text-black rounded-lg shadow-lg">
                <a href="{{ route('phases.show') }}" class="block px-4 py-2 hover:bg-gray-200">➕ Create Phases</a>
                <a href="" class="block px-4 py-2 hover:bg-gray-200">📑 Custom Fields</a>
            </div> --}}


        </div>

</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const settingsButton = document.getElementById("settings-btn");
        const settingsMenu = document.getElementById("settings-menu");

        settingsButton.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevent immediate closing
            settingsMenu.classList.toggle("hidden");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (event) {
            if (!settingsButton.contains(event.target) && !settingsMenu.contains(event.target)) {
                settingsMenu.classList.add("hidden");
            }
        });

        // Prevent closing when clicking inside the dropdown
        settingsMenu.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    });
</script>
