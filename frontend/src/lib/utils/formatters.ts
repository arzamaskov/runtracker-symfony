/**
 * Shared formatting utilities
 */

export function formatDuration(seconds: number): string {
	const hours = Math.floor(seconds / 3600);
	const minutes = Math.floor((seconds % 3600) / 60);
	const secs = seconds % 60;

	return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}

export function formatDistance(km: number): string {
	return `${km.toFixed(2)} km`;
}

export function formatPace(minutesPerKm: number): string {
	const minutes = Math.floor(minutesPerKm);
	const seconds = Math.round((minutesPerKm - minutes) * 60);
	return `${minutes}:${seconds.toString().padStart(2, '0')} /km`;
}

export function formatDate(date: Date | string): string {
	const d = typeof date === 'string' ? new Date(date) : date;
	const month = (d.getMonth() + 1).toString().padStart(2, '0');
	const day = d.getDate().toString().padStart(2, '0');
	const year = d.getFullYear();
	return `${month}/${day}/${year}`;
}

export function parseDuration(duration: string): number {
	const parts = duration.split(':');
	if (parts.length !== 3) return 0;

	const hours = parseInt(parts[0], 10) || 0;
	const minutes = parseInt(parts[1], 10) || 0;
	const seconds = parseInt(parts[2], 10) || 0;

	return hours * 3600 + minutes * 60 + seconds;
}
