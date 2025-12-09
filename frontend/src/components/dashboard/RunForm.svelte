<script lang="ts">
	import { Calendar } from 'lucide-svelte';

	let {
		initialData = {
			date: '',
			distance: '',
			duration: '',
			notes: ''
		},
		onSubmit,
		onCancel,
		title = 'Add New Run',
		subtitle = 'Record your running training session',
		submitLabel = 'Add Run'
	} = $props<{
		initialData?: {
			date: string;
			distance: string;
			duration: string;
			notes: string;
		};
		onSubmit: (data: any) => void;
		onCancel: () => void;
		title?: string;
		subtitle?: string;
		submitLabel?: string;
	}>();

	let formData = $state({ ...initialData });

	function handleSubmit(e: Event) {
		e.preventDefault();
		onSubmit(formData);
	}
</script>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl mx-auto">
	<div class="mb-8">
		<h2 class="text-xl font-bold text-gray-900">{title}</h2>
		<p class="text-sm text-gray-500 mt-1">{subtitle}</p>
	</div>

	<form onsubmit={handleSubmit} class="space-y-6">
		<!-- Date & Time -->
		<div class="space-y-2">
			<label for="date" class="block text-sm font-medium text-gray-700">Date & Time</label>
			<div class="relative">
				<input
					type="datetime-local"
					id="date"
					bind:value={formData.date}
					class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm h-10 px-3 border"
					placeholder="Select date and time"
				/>
			</div>
		</div>

		<!-- Distance -->
		<div class="space-y-2">
			<label for="distance" class="block text-sm font-medium text-gray-700">Distance (km)</label>
			<input
				type="number"
				step="0.01"
				id="distance"
				bind:value={formData.distance}
				class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm h-10 px-3 border"
				placeholder="0.00"
			/>
		</div>

		<!-- Duration -->
		<div class="space-y-2">
			<label for="duration" class="block text-sm font-medium text-gray-700"
				>Duration (HH:MM:SS)</label
			>
			<input
				type="text"
				id="duration"
				bind:value={formData.duration}
				class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm h-10 px-3 border"
				placeholder="00:00:00"
			/>
			<p class="text-xs text-gray-500">
				Format: hours:minutes:seconds (e.g., 00:30:00 for 30 minutes)
			</p>
		</div>

		<!-- Notes -->
		<div class="space-y-2">
			<label for="notes" class="block text-sm font-medium text-gray-700">Notes (optional)</label>
			<textarea
				id="notes"
				rows="4"
				bind:value={formData.notes}
				class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 border resize-none"
				placeholder="How did the run feel? Any observations..."
			></textarea>
		</div>

		<!-- Actions -->
		<div class="flex items-center gap-4 pt-4">
			<button
				type="submit"
				class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 h-11"
			>
				{submitLabel}
			</button>
			<button
				type="button"
				onclick={onCancel}
				class="flex-none px-6 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 h-11"
			>
				Cancel
			</button>
		</div>
	</form>
</div>
