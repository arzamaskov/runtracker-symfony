<script lang="ts">
	import FormInput from '$lib/../components/forms/FormInput.svelte';
	import FormButton from '$lib/../components/forms/FormButton.svelte';
	import { validateEmail, validatePassword } from '$lib/utils/validation';
	import { login } from "$lib/api/auth";
	import { goto } from "$app/navigation";
	import { ApiError } from "$lib/api/client";

	let email = $state('');
	let password = $state('');
	let errors = $state({ email: '', password: '' , general: ''});
	let touched = $state({ email: false, password: false });
	let isSubmitting = $state(false);

	function handleBlur(field: 'email' | 'password'): void {
		touched[field] = true;
		if (field === 'email') errors.email = validateEmail(email);
		if (field === 'password') errors.password = validatePassword(password);
	}

	function handleInput(field: 'email' | 'password'): void {
		if (touched[field]) {
			if (field === 'email') errors.email = validateEmail(email);
			if (field === 'password') errors.password = validatePassword(password);
		}
	}

	async function handleSubmit(event: Event) {
		event.preventDefault();
		touched.email = true;
		touched.password = true;
		errors.email = validateEmail(email);
		errors.password = validatePassword(password);

		if (errors.email || errors.password) {
			return;
		}

		errors.general = '';
		isSubmitting = true;
		try {
			await login(email, password);
			goto('/dashboard');
		} catch (error) {
			if (error instanceof ApiError) {
				if (error.status === 401) {
					errors.general = 'Неверный email или пароль';
				} else if (error.status === 400) {
					errors.general = 'Проверьте правильность заполнения полей';
				} else {
					errors.general = error.message || 'Ошибка при входе';
				}
			} else {
				errors.general = 'Произошла ошибка. Попробуйте позже.';
			}
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
				С возвращением!
			</h2>
			<p class="mt-2 text-sm text-slate-500">Пожалуйста, войдите в свой аккаунт.</p>
		</div>
		{#if errors.general}
			<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4" role="alert">
				<p class="text-sm">{errors.general}</p>
			</div>
		{/if}
		<form class="mt-8 space-y-6" onsubmit={handleSubmit} novalidate>
			<div class="space-y-5">
				<FormInput
					id="email-address"
					name="email"
					type="email"
					label="Email"
					bind:value={email}
					error={errors.email}
					placeholder="name@example.com"
					autocomplete="email"
					required={true}
					onblur={() => handleBlur('email')}
					oninput={() => handleInput('email')}
				/>

				<FormInput
					id="password"
					name="password"
					type="password"
					label="Пароль"
					bind:value={password}
					error={errors.password}
					placeholder="••••••••"
					autocomplete="current-password"
					required={true}
					onblur={() => handleBlur('password')}
					oninput={() => handleInput('password')}
				/>
			</div>

			<div class="flex items-center justify-between">
				<div class="flex items-center">
					<input
						id="remember-me"
						name="remember-me"
						type="checkbox"
						class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded"
					/>
					<label for="remember-me" class="ml-2 block text-sm text-slate-600">
						Запомнить меня
					</label>
				</div>

				<div class="text-sm">
					<button type="button" class="font-medium text-blue-600 hover:text-blue-500 transition-colors bg-transparent border-0 p-0 cursor-pointer">
						Забыли пароль?
					</button>
				</div>
			</div>

			<div>
				<FormButton type="submit" variant="primary" disabled={isSubmitting} loading={isSubmitting}>
					{isSubmitting ? 'Вход...' : 'Войти'}
				</FormButton>
			</div>
		</form>

		<p class="mt-10 text-center text-sm text-slate-500">
			Нет аккаунта?
			<a href="/register" class="font-semibold leading-6 text-blue-600 hover:text-blue-500"
				>Зарегистрироваться</a
			>
		</p>
	</div>
</div>
