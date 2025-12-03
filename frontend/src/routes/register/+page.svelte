<script lang="ts">
    let name = "";
    let email = "";
    let password = "";
    let errors = { name: "", email: "", password: "" };
    let touched = { name: false, email: false, password: false };
    let isSubmitting = false; // Added isSubmitting variable

    function validateName(name: string) {
        if (!name) return "Имя обязательно";
        if (name.length < 2) return "Имя должно быть не менее 2 символов";
        return "";
    }

    function validateEmail(email: string) {
        if (!email) return "Email обязателен";
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
            return "Введите корректный email";
        return "";
    }

    function validatePassword(password: string) {
        if (!password) return "Пароль обязателен";
        if (password.length < 8)
            return "Пароль должен быть не менее 8 символов";
        return "";
    }

    function handleBlur(field: keyof typeof touched) {
        touched[field] = true;
        if (field === "name") errors.name = validateName(name);
        if (field === "email") errors.email = validateEmail(email);
        if (field === "password") errors.password = validatePassword(password);
    }

    function handleInput(field: keyof typeof touched) {
        if (touched[field]) {
            if (field === "name") errors.name = validateName(name);
            if (field === "email") errors.email = validateEmail(email);
            if (field === "password")
                errors.password = validatePassword(password);
        }
    }

    async function handleSubmit(event: Event) {
        // Added async keyword
        touched.name = true;
        touched.email = true;
        touched.password = true;
        errors.name = validateName(name);
        errors.email = validateEmail(email);
        errors.password = validatePassword(password);

        if (errors.name || errors.email || errors.password) {
            return; // Prevent form submission if there are errors
        }

        isSubmitting = true;
        try {
            // Simulate API call
            await new Promise((resolve) => setTimeout(resolve, 2000));
            // In a real application, you would send the data to your backend here
            console.log("Form submitted:", { name, email, password });
            alert("Регистрация успешна!");
            // Redirect or clear form
        } catch (error) {
            console.error("Submission error:", error);
            alert("Ошибка при регистрации.");
        } finally {
            isSubmitting = false;
        }
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
                Создать аккаунт
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                Создайте аккаунт, чтобы начать отслеживать свои тренировки.
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
                        for="name"
                        class="block text-sm font-medium text-slate-700 mb-1 ml-1"
                    >
                        Имя
                    </label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        autocomplete="name"
                        required
                        bind:value={name}
                        on:blur={() => handleBlur("name")}
                        on:input={() => handleInput("name")}
                        class="appearance-none relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all sm:text-sm"
                        style="border-radius: var(--radius-input); height: var(--input-height);"
                        placeholder="Иван Иванов"
                    />
                    <div class="min-h-[20px] mt-1 ml-1">
                        {#if errors.name}
                            <p class="text-xs text-red-500 animate-pulse">
                                {errors.name}
                            </p>
                        {/if}
                    </div>
                </div>
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
                        autocomplete="new-password"
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
                        Регистрация...
                    {:else}
                        Зарегистрироваться
                    {/if}
                </button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-slate-500">
            Уже есть аккаунт?
            <a
                href="/login"
                class="font-semibold leading-6 text-blue-600 hover:text-blue-500"
                >Войти</a
            >
        </p>
    </div>
</div>
