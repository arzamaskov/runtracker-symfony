<script lang="ts">
	import type { ComponentType } from 'svelte';

	let {
		title,
		value,
		subtext,
		icon: Icon
	} = $props<{
		title: string;
		value: string;
		subtext: string;
		icon?: ComponentType;
	}>();
</script>

<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex flex-col h-full">
	<div class="flex items-start justify-between mb-4">
		<h3 class="text-sm font-medium text-gray-500">{title}</h3>
		{#if Icon}
			<div class="text-blue-500">
				<Icon size={20} />
			</div>
		{/if}
	</div>

	<div class="mt-auto">
		<div class="text-2xl font-bold text-gray-900 mb-1">{value}</div>
		<p class="text-xs text-gray-500">{subtext}</p>
	</div>
</div>
