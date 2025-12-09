<script lang="ts">
	import { page } from '$app/stores';
	import { goto } from '$app/navigation';
	import { ChevronLeft } from 'lucide-svelte';
	import RunForm from '$lib/../components/dashboard/RunForm.svelte';

	const runId = $page.params.id;

	// Mock existing data
	const existingData = {
		date: '2024-01-15T10:00',
		distance: '5.00',
		duration: '00:30:00',
		notes: 'Morning run'
	};

	function handleSave(data: any) {
		console.log('Saving run', runId, data);
		goto(`/dashboard/runs/${runId}`);
	}

	function handleCancel() {
		goto(`/dashboard/runs/${runId}`);
	}
</script>

<div class="max-w-2xl mx-auto space-y-6">
	<a
		href={`/dashboard/runs/${runId}`}
		class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900"
	>
		<ChevronLeft size={16} class="mr-1" />
		Back to Details
	</a>

	<RunForm
		title="Run Details"
		subtitle=""
		submitLabel="Save Changes"
		initialData={existingData}
		onSubmit={handleSave}
		onCancel={handleCancel}
	/>
</div>
