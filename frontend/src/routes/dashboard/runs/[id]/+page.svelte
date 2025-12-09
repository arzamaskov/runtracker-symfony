<script lang="ts">
	import { page } from '$app/stores';
	import { goto } from '$app/navigation';
	import { ChevronLeft, Edit2, Trash2 } from 'lucide-svelte';

	// Mock data based on ID
	const runId = $page.params.id;
	const run = {
		id: runId,
		date: 'Monday, January 15, 2024',
		time: '02:00 PM',
		distance: '5.00 km',
		duration: '00:30:00',
		pace: '6:00 /km',
		notes: 'Morning run'
	};

	function handleEdit() {
		goto(`/dashboard/runs/${runId}/edit`);
	}

	function handleDelete() {
		if (confirm('Are you sure you want to delete this run?')) {
			console.log('Deleting run', runId);
			goto('/dashboard');
		}
	}
</script>

<div class="max-w-2xl mx-auto space-y-6">
	<a href="/dashboard" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-900">
		<ChevronLeft size={16} class="mr-1" />
		Back to Dashboard
	</a>

	<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
		<div class="flex items-start justify-between mb-8">
			<h2 class="text-xl font-bold text-gray-900">Run Details</h2>
			<div class="flex gap-2">
				<button
					onclick={handleEdit}
					class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition"
				>
					<Edit2 size={14} />
					Edit
				</button>
				<button
					onclick={handleDelete}
					class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition"
				>
					<Trash2 size={14} />
					Delete
				</button>
			</div>
		</div>

		<div class="space-y-8">
			<!-- Date & Time -->
			<div>
				<label class="block text-sm font-medium text-gray-500 mb-1">Date & Time</label>
				<div class="text-lg font-semibold text-gray-900">
					{run.date}
				</div>
				<div class="text-gray-500">{run.time}</div>
			</div>

			<!-- Stats Grid -->
			<div class="grid grid-cols-3 gap-8">
				<div>
					<label class="block text-sm font-medium text-gray-500 mb-1">Distance</label>
					<div class="text-2xl font-bold text-gray-900">
						{run.distance}
					</div>
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-500 mb-1">Duration</label>
					<div class="text-2xl font-bold text-gray-900">
						{run.duration}
					</div>
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-500 mb-1">Pace</label>
					<div class="text-2xl font-bold text-gray-900">
						{run.pace}
					</div>
				</div>
			</div>

			<!-- Notes -->
			<div>
				<label class="block text-sm font-medium text-gray-500 mb-1">Notes</label>
				<div class="text-gray-900">{run.notes}</div>
			</div>
		</div>
	</div>
</div>
