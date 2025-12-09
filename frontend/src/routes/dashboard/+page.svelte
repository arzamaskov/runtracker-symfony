<script lang="ts">
	import { Medal, Timer, Clock } from 'lucide-svelte';
	import StatCard from '../../components/dashboard/StatCard.svelte';
	import ProgressChart from '../../components/charts/ProgressChart.svelte';
	import WeeklyDistanceChart from '../../components/charts/WeeklyDistanceChart.svelte';

	// Mock data matching screenshots
	const weeklyData = {
		labels: ['Jan 14', 'Jan 21', 'Jan 28', 'Feb 4', 'Feb 11'],
		values: [12, 15, 8, 16, 10] // Visual approximation
	};

	const paceData = [
		{ x: 'Jan 1', y: 6.0 },
		{ x: 'Jan 8', y: 5.5 },
		{ x: 'Jan 15', y: 5.0 } // match screenshot
	];

	const distanceProgressData = [
		{ x: 'Jan 1', y: 4.0 },
		{ x: 'Jan 8', y: 5.0 },
		{ x: 'Jan 15', y: 6.0 }
	];
</script>

<div class="space-y-8">
	<!-- Header -->
	<div>
		<h1 class="text-3xl font-bold text-gray-900 tracking-tight">Analytics</h1>
		<p class="mt-2 text-gray-600">Visualize your running progress and achievements</p>
	</div>

	<!-- Stats Grid -->
	<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
		<StatCard title="Longest Run" value="6.00 km" subtext="1/15/2024" icon={Medal} />
		<StatCard title="Fastest Pace" value="5:00 /km" subtext="1/15/2024" icon={Timer} />
		<StatCard title="Longest Duration" value="30 min" subtext="1/15/2024" icon={Clock} />
	</div>

	<!-- Charts -->
	<div class="grid grid-cols-1 gap-6">
		<!-- Weekly Distance -->
		<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
			<h3 class="text-base font-semibold text-gray-900 mb-1">Weekly Distance</h3>
			<p class="text-sm text-gray-500 mb-6">Total distance covered each week</p>
			<div class="h-64">
				<WeeklyDistanceChart labels={weeklyData.labels} values={weeklyData.values} />
			</div>
		</div>

		<!-- Distance Progress -->
		<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
			<h3 class="text-base font-semibold text-gray-900 mb-1">Distance Progress</h3>
			<p class="text-sm text-gray-500 mb-6">Distance covered per run over time</p>
			<div class="h-64">
				<ProgressChart data={distanceProgressData} />
			</div>
		</div>

		<!-- Pace Progression -->
		<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
			<h3 class="text-base font-semibold text-gray-900 mb-1">Pace Progression</h3>
			<p class="text-sm text-gray-500 mb-6">Your pace improvement over time (lower is better)</p>
			<div class="h-64">
				<ProgressChart data={paceData} />
			</div>
		</div>
	</div>

	<!-- CTA to Add Run (if needed directly here, or via nav) -->
	<div class="flex justify-end">
		<a
			href="/dashboard/runs/new"
			class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition"
		>
			Add New Run
		</a>
	</div>
</div>
