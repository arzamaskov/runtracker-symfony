<script lang="ts">
	import { onMount } from 'svelte';
	import {
		Chart as ChartJS,
		Title,
		Tooltip,
		Legend,
		BarElement,
		BarController,
		CategoryScale,
		LinearScale,
		type ChartConfiguration
	} from 'chart.js';
	import { getDefaultChartOptions, getDefaultScaleOptions } from '$lib/utils/chartConfig';

	ChartJS.register(Title, Tooltip, Legend, BarElement, BarController, CategoryScale, LinearScale);

	let { labels, values } = $props<{
		labels: string[];
		values: number[];
	}>();

	let chartCanvas: HTMLCanvasElement;
	let chartInstance: ChartJS;

	onMount(() => {
		const config: ChartConfiguration = {
			type: 'bar',
			data: {
				labels: labels,
				datasets: [
					{
						label: 'Distance (km)',
						data: values,
						backgroundColor: '#0A84FF',
						borderRadius: 2,
						barThickness: 'flex',
						maxBarThickness: 40
					}
				]
			},
			options: {
				...getDefaultChartOptions(),
				scales: {
					x: {
						...getDefaultScaleOptions()
					},
					y: {
						...getDefaultScaleOptions(),
						display: true,
						ticks: {
							...getDefaultScaleOptions().ticks,
							stepSize: 4
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
