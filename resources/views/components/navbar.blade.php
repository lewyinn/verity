<header class="flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white text-sm py-3 fixed z-[9999]">
    <nav class="max-w-[85rem] w-full mx-auto px-4 flex flex-wrap basis-full items-center justify-between">
        <a class="sm:order-1 flex justify-center items-end gap-1 text-2xl text-[#FE6716] font-extrabold focus:outline-none focus:opacity-80"
            href="#">
            <img src="{{ asset('storage/Logo Verity.png') }}" alt="" class="size-8 lg:size-10">
            Verity
        </a>
        <div class="sm:order-3 flex items-center gap-x-2">
            <button type="button"
                class="sm:hidden hs-collapse-toggle relative size-7 flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                id="hs-navbar-alignment-collapse" aria-expanded="false" aria-controls="hs-navbar-alignment"
                aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-alignment">
                <svg class="hs-collapse-open:hidden shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="36"
                    height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" x2="21" y1="6" y2="6" />
                    <line x1="3" x2="21" y1="12" y2="12" />
                    <line x1="3" x2="21" y1="18" y2="18" />
                </svg>
                <svg class="hs-collapse-open:block hidden shrink-0 size-5" xmlns="http://www.w3.org/2000/svg"
                    width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
                <span class="sr-only">Toggle</span>
            </button>
            {{-- Dropdown User IMG --}}
            <div
                class="hs-dropdown [--strategy:static] sm:[--strategy:fixed] [--adaptive:none] py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none disabled:opacity-50 disabled:pointer-events-none relative">
                <button id="hs-navbar-example-dropdown" type="button"
                    class="hs-dropdown-toggle flex items-center w-full text-gray-600 hover:text-gray-400 focus:outline-none focus:text-gray-400 font-medium"
                    aria-haspopup="menu" aria-expanded="false" aria-label="Mega Menu">
                    @if (auth()->check())
                        <img src="{{ auth()->user()->avatar_url ? asset('storage/' . auth()->user()->avatar_url) : 'https://w7.pngwing.com/pngs/339/876/png-transparent-login-computer-icons-password-login-black-symbol-subscription-business-model-thumbnail.png' }}" 
                            alt="" class="w-8 rounded-full">
                    @else
                        <img srcset="https://placeholder.com/100x100" alt="" class="w-8 rounded-full">
                    @endif

                    <svg class="hs-dropdown-open:-rotate-180 sm:hs-dropdown-open:rotate-0 duration-300 ms-1 shrink-0 size-4"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div
                    class="hs-dropdown-menu transition-[opacity,margin] ease-in-out duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 sm:w-auto z-10 bg-white shadow-md rounded-lg p-1 px-2 space-y-1 absolute top-full -left-10 mt-2 hidden sm:block sm:right-auto sm:left-0">
                    @if (auth()->check())
                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-base text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                            href="/admin">
                            Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-base text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100">Logout</button>
                        </form>
                    @else
                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-base text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                            href="/admin/login">
                            Login
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div id="hs-navbar-alignment"
            class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow sm:grow-0 sm:basis-auto sm:block sm:order-2"
            aria-labelledby="hs-navbar-alignment-collapse">
            <div class="flex flex-col gap-5 mt-5 sm:flex-row sm:items-center sm:mt-0 sm:ps-5">
                <a class="font-medium text-base {{ request()->is('/') ? 'text-[#FE6716]' : 'text-gray-500 hover:text-[#FE6716]' }} focus:outline-none"
                    href="/" aria-current="{{ request()->is('/') ? 'page' : null }}">Home</a>
                <a class="font-medium text-base {{ request()->is('about') ? 'text-[#FE6716]' : 'text-gray-500 hover:text-[#FE6716]' }} focus:outline-none focus:text-[#FE6716]"
                    href="/about" aria-current="{{ request()->is('about') ? 'page' : null }}">About</a>
                <a class="font-medium text-base {{ request()->is('news') ? 'text-[#FE6716]' : 'text-gray-500 hover:text-[#FE6716]' }} focus:outline-none focus:text-[#FE6716]"
                    href="/news" aria-current="{{ request()->is('news') ? 'page' : null }}">News</a>
                <a class="font-medium text-base {{ request()->is('category') ? 'text-[#FE6716]' : 'text-gray-500 hover:text-[#FE6716]' }} focus:outline-none focus:text-[#FE6716]"
                    href="/category"
                    aria-current="{{ request()->is('category') ? 'page' : null }}">Category</a>
            </div>
        </div>
    </nav>
</header>