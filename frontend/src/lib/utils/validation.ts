/**
 * Shared validation utilities
 */

export function validateEmail(email: string): string {
	if (!email) return 'Email обязателен';
	if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
		return 'Введите корректный email';
	}
	return '';
}

export function validatePassword(password: string): string {
	if (!password) return 'Пароль обязателен';
	if (password.length < 8) {
		return 'Пароль должен быть не менее 8 символов';
	}
	return '';
}

export function validateName(name: string): string {
	if (!name) return 'Имя обязательно';
	if (name.length < 2) {
		return 'Имя должно быть не менее 2 символов';
	}
	return '';
}

export function validateRequired(value: string, fieldName: string): string {
	if (!value || value.trim() === '') {
		return `${fieldName} обязательно`;
	}
	return '';
}

export function validateDistance(distance: string): string {
	if (!distance) return 'Дистанция обязательна';
	const num = parseFloat(distance);
	if (isNaN(num) || num <= 0) {
		return 'Введите корректную дистанцию';
	}
	return '';
}

export function validateDuration(duration: string): string {
	if (!duration) return 'Длительность обязательна';
	// HH:MM:SS format validation
	if (!/^\d{1,2}:\d{2}:\d{2}$/.test(duration)) {
		return 'Формат: ЧЧ:ММ:СС (например, 00:30:00)';
	}
	return '';
}
