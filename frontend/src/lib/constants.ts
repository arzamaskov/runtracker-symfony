/**
 * Application constants
 */

export const APP_NAME = 'RUNTRACKER';

export const API_BASE_URL = import.meta.env.VITE_API_URL || '/api';

export const DATE_FORMAT = 'MM/DD/YYYY';

export const VALIDATION_MESSAGES = {
	EMAIL_REQUIRED: 'Email обязателен',
	EMAIL_INVALID: 'Введите корректный email',
	PASSWORD_REQUIRED: 'Пароль обязателен',
	PASSWORD_MIN_LENGTH: 'Пароль должен быть не менее 8 символов',
	NAME_REQUIRED: 'Имя обязательно',
	NAME_MIN_LENGTH: 'Имя должно быть не менее 2 символов',
	DISTANCE_REQUIRED: 'Дистанция обязательна',
	DISTANCE_INVALID: 'Введите корректную дистанцию',
	DURATION_REQUIRED: 'Длительность обязательна',
	DURATION_INVALID: 'Формат: ЧЧ:ММ:СС (например, 00:30:00)',
	DATE_REQUIRED: 'Дата обязательна'
} as const;
