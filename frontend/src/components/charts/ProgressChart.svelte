<script lang="ts">
	import { onMount } from 'svelte';
	import {
		Chart as ChartJS,
		Title,
		Tooltip,
		Legend,
		LineElement,
		PointElement,
		ScatterController,
		LinearScale,
		CategoryScale,
		TimeScale,
		type ChartConfiguration
	} from 'chart.js';
	import { getDefaultChartOptions, getDefaultScaleOptions } from '$lib/utils/chartConfig';

	ChartJS.register(
		Title,
		Tooltip,
		Legend,
		LineElement,
		PointElement,
		ScatterController,
		LinearScale,
		CategoryScale,
		TimeScale
	);

	let { data } = $props<{
		data: { x: string; y: number }[];
	}>();

	let chartCanvas: HTMLCanvasElement;
	let chartInstance: ChartJS;

	onMount(() => {
		const config: ChartConfiguration = {
			type: 'scatter',
			data: {
				datasets: [
					{
						label: 'Pace (min/km)',
						data: data,
						backgroundColor: '#0A84FF',
						borderColor: '#0A84FF',
						showLine: false,
						pointRadius: 4,
						pointHoverRadius: 6
					}
				]
			},
			options: {
				...getDefaultChartOptions(),
				plugins: {
					...getDefaultChartOptions().plugins,
					tooltip: {
						callbacks: {
							label: function (context: any) {
								return `${context.parsed.y} /km`;
							}
						}
					}
				},
				scales: {
					x: {
						...getDefaultScaleOptions(),
						type: 'category'
					},
					y: {
						...getDefaultScaleOptions(),
						grid: {
							color: 'rgba(0, 0, 0, 0.05)'
						},
						min: 0,
						ticks: {
							...getDefaultScaleOptions().ticks,
							stepSize: 1.5
						}
					}
				}
			}
		};

		chartInstance = new ChartJS(chartCanvas, config);

		return () => {
			chartInstance.destroy();
		};
	});
</script>

<div class="w-full h-64">
	<canvas bind:this={chartCanvas}></canvas>
</div>
