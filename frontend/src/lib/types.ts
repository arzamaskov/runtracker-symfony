/**
 * Core application type definitions
 */

export interface User {
	id: number;
	name: string;
	email: string;
	createdAt: string;
}

export interface Run {
	id: number;
	userId: number;
	date: string;
	distance: number; // in kilometers
	duration: number; // in seconds
	notes: string;
	createdAt: string;
	updatedAt: string;
}

export interface RunFormData {
	date: string;
	distance: string;
	duration: string;
	notes: string;
}

export interface ValidationErrors<T = Record<string, string>> {
	[K: string]: string;
}

export interface FormTouched<T = Record<string, boolean>> {
	[K: string]: boolean;
}

export interface ChartDataPoint {
	x: string;
	y: number;
}

export interface Statistics {
	longestRun: {
		distance: number;
		date: string;
	};
	fastestPace: {
		pace: number;
		date: string;
	};
	longestDuration: {
		duration: number;
		date: string;
	};
}
