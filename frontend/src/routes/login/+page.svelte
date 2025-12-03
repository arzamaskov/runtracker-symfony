<script lang="ts">
    let email: string = "";
    let password: string = "";
    let errors: { email: string; password: string } = {
        email: "",
        password: "",
    };
    let touched: { email: boolean; password: boolean } = {
        email: false,
        password: false,
    };

    let isSubmitting = false;

    function validateEmail(email: string): string {
        if (!email) return "Email обязателен";
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
            return "Введите корректный email";
        return "";
    }

    function validatePassword(password: string): string {
        if (!password) return "Пароль обязателен";
        if (password.length < 8)
            return "Пароль должен быть не менее 8 символов";
        return "";
    }

    function handleBlur(field: keyof typeof touched): void {
        touched[field] = true;
        if (field === "email") errors.email = validateEmail(email);
        if (field === "password") errors.password = validatePassword(password);
    }

    function handleInput(field: keyof typeof touched): void {
        if (touched[field]) {
            if (field === "email") errors.email = validateEmail(email);
            if (field === "password")
                errors.password = validatePassword(password);
        }
    }

    async function handleSubmit(event: Event) {
        touched.email = true;
        touched.password = true;
        errors.email = validateEmail(email);
        errors.password = validatePassword(password);

        if (errors.email || errors.password) {
            return;
        }

        isSubmitting = true;

        // Simulate an API call
        await new Promise((resolve) => setTimeout(resolve, 2000));

        isSubmitting = false;
        // In a real app, you'd handle success/failure, redirect, etc.
    }
</script>

<div
    class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50"
    style="background-color: var(--color-bg);"
>
    <div
        class="max-w-md w-full space-y-8 bg-white p-10 transition-all duration-300"
        style="border-radius: var(--radius-xl); box-shadow: var(--shadow-modal);"
    >
        <div class="text-center">
            <a
                href="/"
                class="inline-flex items-center text-3xl font-bold tracking-tight uppercase mb-2"
                style="font-family: var(--font-family);"
            >
                <span style="color: var(--color-primary);">RUN</span><span
                    style="color: var(--color-text-primary);">TRACKER</span
                >
            </a>
            <h2
                class="mt-6 text-3xl font-bold tracking-tight text-slate-900"
                style="font-family: var(--font-family);"
            >
                С возвращением!
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                Пожалуйста, войдите в свой аккаунт.
            </p>
        </div>
        <form
            class="mt-8 space-y-6"
            on:submit|preventDefault={handleSubmit}
            novalidate
        >
            <div class="space-y-5">
                <div>
                    <label
                        for="email-address"
                        class="block text-sm font-medium text-slate-700 mb-1 ml-1"
                    >
                        Email
                    </label>
                    <input
                        id="email-address"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        bind:value={email}
                        on:blur={() => handleBlur("email")}
                        on:input={() => handleInput("email")}
                        class="appearance-none relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all sm:text-sm"
                        style="border-radius: var(--radius-input); height: var(--input-height);"
                        placeholder="name@example.com"
                    />
                    <div class="min-h-[20px] mt-1 ml-1">
                        {#if errors.email}
                            <p class="text-xs text-red-500 animate-pulse">
                                {errors.email}
                            </p>
                        {/if}
                    </div>
                </div>
                <div>
                    <label
                        for="password"
                        class="block text-sm font-medium text-slate-700 mb-1 ml-1"
                    >
                        Пароль
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        bind:value={password}
                        on:blur={() => handleBlur("password")}
                        on:input={() => handleInput("password")}
                        class="appearance-none relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all sm:text-sm"
                        style="border-radius: var(--radius-input); height: var(--input-height);"
                        placeholder="••••••••"
                    />
                    <div class="min-h-[20px] mt-1 ml-1">
                        {#if errors.password}
                            <p class="text-xs text-red-500 animate-pulse">
                                {errors.password}
                            </p>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input
                        id="remember-me"
                        name="remember-me"
                        type="checkbox"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded"
                    />
                    <label
                        for="remember-me"
                        class="ml-2 block text-sm text-slate-600"
                    >
                        Запомнить меня
                    </label>
                </div>

                <div class="text-sm">
                    <a
                        href="#"
                        class="font-medium text-blue-600 hover:text-blue-500 transition-colors"
                    >
                        Забыли пароль?
                    </a>
                </div>
            </div>

            <div>
                <button
                    type="submit"
                    disabled={isSubmitting}
                    class="group relative w-full flex justify-center items-center py-3 px-4 border border-transparent text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40 hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed"
                    style="height: var(--btn-height); border-radius: var(--radius-control); font-size: 16px;"
                >
                    {#if isSubmitting}
                        <svg
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        Вход...
                    {:else}
                        Войти
                    {/if}
                </button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-slate-500">
            Нет аккаунта?
            <a
                href="/register"
                class="font-semibold leading-6 text-blue-600 hover:text-blue-500"
                >Зарегистрироваться</a
            >
        </p>
    </div>
</div>
