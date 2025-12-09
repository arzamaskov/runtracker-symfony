/**
 * Shared Chart.js configuration
 */

import type { ChartOptions } from 'chart.js';

export function getDefaultFontConfig() {
	return {
		family: 'Inter, sans-serif',
		size: 12
	};
}

export function getDefaultScaleOptions(): any {
	return {
		grid: {
			display: false
		},
		border: {
			display: false
		},
		ticks: {
			font: getDefaultFontConfig()
		}
	};
}

export function getDefaultChartOptions(): Partial<ChartOptions> {
	return {
		responsive: true,
		maintainAspectRatio: false,
		plugins: {
			legend: {
				display: false
			}
		}
	};
}
