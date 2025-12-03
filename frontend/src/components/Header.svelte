<script lang="ts">
    import { page } from "$app/stores";
    let isMenuOpen = false;

    function toggleMenu() {
        isMenuOpen = !isMenuOpen;
    }
</script>

<header
    class="fixed w-full top-0 z-50 transition-all duration-300 backdrop-blur bg-white/80 supports-[backdrop-filter]:bg-white/80"
    style="border-bottom: 1px solid var(--color-border);"
>
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center h-[var(--header-height)]">
            <!-- Logo + Nav on left -->
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a
                    href="/"
                    class="flex items-center text-xl font-bold tracking-tight uppercase"
                    style="font-family: var(--font-family);"
                >
                    <span style="color: var(--color-primary);">RUN</span><span
                        style="color: var(--color-text-primary);">TRACKER</span
                    >
                </a>

                <!-- Nav immediately after logo -->
                <nav
                    class="hidden md:flex space-x-2"
                    aria-label="Главная навигация"
                >
                    <a
                        href="/#features"
                        class="text-sm text-slate-700 hover:text-slate-900 transition px-3 py-2 rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                        >Возможности</a
                    >
                    <a
                        href="/#how"
                        class="text-sm text-slate-700 hover:text-slate-900 transition px-3 py-2 rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                        >Как работает</a
                    >
                    <a
                        href="/#faq"
                        class="text-sm text-slate-700 hover:text-slate-900 transition px-3 py-2 rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                        >FAQ</a
                    >
                </nav>
            </div>

            <!-- Auth buttons on right -->
            <div class="flex items-center space-x-3 ml-auto">
                <div class="hidden md:flex items-center space-x-3">
                    <a
                        href="/login"
                        class="px-4 py-2 bg-slate-100 text-slate-800 text-sm rounded-lg hover:bg-slate-200 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                    >
                        Вход
                    </a>
                    <a
                        href="/register"
                        class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                    >
                        Регистрация
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button
                    on:click={toggleMenu}
                    class="md:hidden inline-flex items-center justify-center p-2 rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 text-slate-700 hover:text-slate-900"
                    aria-label="Открыть меню"
                    aria-expanded={isMenuOpen}
                >
                    <svg
                        class="w-6 h-6"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        aria-hidden="true"
                        focusable="false"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile nav -->
    {#if isMenuOpen}
        <div
            class="md:hidden border-t border-slate-200/50 bg-white/90 backdrop-blur"
        >
            <div class="max-w-6xl mx-auto px-4 py-3">
                <nav
                    class="flex flex-col space-y-1"
                    aria-label="Главная навигация (моб.)"
                >
                    <a
                        href="/#features"
                        class="px-3 py-2 rounded text-slate-700 hover:text-slate-900 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >Возможности</a
                    >
                    <a
                        href="/#how"
                        class="px-3 py-2 rounded text-slate-700 hover:text-slate-900 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >Как работает</a
                    >
                    <a
                        href="/#faq"
                        class="px-3 py-2 rounded text-slate-700 hover:text-slate-900 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >FAQ</a
                    >

                    <div
                        class="pt-4 mt-4 border-t border-slate-100 flex flex-col space-y-2"
                    >
                        <a
                            href="/login"
                            class="px-3 py-2 rounded text-slate-700 hover:text-slate-900 hover:bg-slate-50"
                            >Вход</a
                        >
                        <a
                            href="/register"
                            class="px-3 py-2 rounded text-blue-600 font-medium hover:bg-slate-50"
                            >Регистрация</a
                        >
                    </div>
                </nav>
            </div>
        </div>
    {/if}
</header>
