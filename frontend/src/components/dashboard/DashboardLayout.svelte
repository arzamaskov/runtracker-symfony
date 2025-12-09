<script lang="ts">
	import { page } from '$app/stores';
	import { LogOut, User } from 'lucide-svelte';

	let { children } = $props();
</script>

<div class="min-h-screen bg-gray-50 flex flex-col">
	<!-- Dashboard Header -->
	<header class="bg-white border-b border-gray-200 sticky top-0 z-10">
		<div class="max-w-6xl mx-auto px-4 h-[var(--header-height)] flex items-center justify-between">
			<div class="flex items-center gap-8">
				<a
					href="/dashboard"
					class="text-xl font-bold tracking-tight uppercase flex items-center"
					style="font-family: var(--font-family);"
				>
					<span style="color: var(--color-primary);">RUN</span><span
						style="color: var(--color-text-primary);">TRACKER</span
					>
				</a>

				<nav class="hidden md:flex space-x-4">
					<a
						href="/dashboard"
						class="px-3 py-2 text-sm font-medium rounded-md transition-colors
                        {$page.url.pathname === '/dashboard'
							? 'bg-blue-50 text-blue-700'
							: 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'}"
					>
						Overview
					</a>
				</nav>
			</div>

			<div class="flex items-center space-x-3 ml-auto">
				<div class="flex items-center space-x-2 text-sm text-gray-700">
					<div
						class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600"
					>
						<User size={16} />
					</div>
					<span class="hidden sm:block">User</span>
				</div>
				<button
					class="px-4 py-2 text-gray-500 hover:text-gray-700 transition-colors rounded-lg"
					title="Sign out"
				>
					<LogOut size={20} />
				</button>
			</div>
		</div>
	</header>

	<!-- Main Content -->
	<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
		{@render children()}
	</main>
</div>
