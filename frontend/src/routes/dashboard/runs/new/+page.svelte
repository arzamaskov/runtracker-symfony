<script lang="ts">
	import RunForm from '$lib/../components/dashboard/RunForm.svelte';
	import { goto } from '$app/navigation';
	import { ChevronLeft } from 'lucide-svelte';

	function handleAddRun(data: any) {
		console.log('Adding run:', data);
		// Logic to save run would go here
		goto('/dashboard');
	}

	function handleCancel() {
		goto('/dashboard');
	}
</script>

<div class="max-w-2xl mx-auto space-y-6">
	<a href="/dashboard" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900">
		<ChevronLeft size={16} class="mr-1" />
		Back to Dashboard
	</a>

	<RunForm onSubmit={handleAddRun} onCancel={handleCancel} />
</div>
