<script lang="ts">
	let {
		id,
		name,
		type = 'text',
		label,
		value = $bindable(''),
		error = '',
		placeholder = '',
		autocomplete = '',
		required = false,
		onblur,
		oninput
	} = $props<{
		id: string;
		name: string;
		type?: string;
		label: string;
		value?: string;
		error?: string;
		placeholder?: string;
		autocomplete?: string;
		required?: boolean;
		onblur?: () => void;
		oninput?: () => void;
	}>();
</script>

<div>
	<label for={id} class="block text-sm font-medium text-slate-700 mb-1 ml-1">
		{label}
	</label>
	<input
		{id}
		{name}
		{type}
		{autocomplete}
		{required}
		{placeholder}
		bind:value
		on:blur={onblur}
		on:input={oninput}
		class="appearance-none relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all sm:text-sm"
		style="border-radius: var(--radius-input); height: var(--input-height);"
	/>
	<div class="min-h-[20px] mt-1 ml-1">
		{#if error}
			<p class="text-xs text-red-500 animate-pulse">
				{error}
			</p>
		{/if}
	</div>
</div>
