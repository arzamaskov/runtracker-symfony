<script lang="ts">
	import LoadingSpinner from '../common/LoadingSpinner.svelte';

	type ButtonVariant = 'primary' | 'secondary';

	let {
		type = 'button',
		variant = 'primary' as ButtonVariant,
		disabled = false,
		loading = false,
		onclick,
		children
	} = $props<{
		type?: 'button' | 'submit' | 'reset';
		variant?: ButtonVariant;
		disabled?: boolean;
		loading?: boolean;
		onclick?: () => void;
		children?: any;
	}>();

	const variantClasses: Record<ButtonVariant, string> = {
		primary:
			'bg-blue-600 text-white hover:bg-blue-700 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40 hover:-translate-y-0.5',
		secondary: 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'
	};

	const variantClass = variantClasses[variant] || variantClasses.primary;
</script>

<button
	{type}
	{disabled}
	onclick={onclick}
	class="group relative w-full flex justify-center items-center py-3 px-4 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all disabled:opacity-70 disabled:cursor-not-allowed {variantClass}"
	style="height: var(--btn-height); border-radius: var(--radius-control); font-size: 16px;"
>
	{#if loading}
		<span class="mr-2">
			<LoadingSpinner size={20} />
		</span>
	{/if}
	{@render children()}
</button>
