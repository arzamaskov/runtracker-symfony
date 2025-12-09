import { API_BASE_URL } from '$lib/constants';

let token: string | null = null;

if (typeof window !== 'undefined') {
	token = localStorage.getItem('auth_token');
}

function getToken(): string | null {
	return token || localStorage.getItem('auth_token');
}

export function setToken(newToken: string): void {
	token = newToken;
	if (typeof window !== 'undefined') {
		localStorage.setItem('auth_token', newToken);
	}
}

export function clearToken(): void {
	token = null;
	if (typeof window !== 'undefined') {
		localStorage.removeItem('auth_token');
	}
}

export class ApiError extends Error {
	constructor(
		message: string,
		public status: number,
		public code?: string
	) {
		super(message);
		this.name = 'ApiError';
	}
}

async function apiRequest<T>(endpoint: string, options: RequestInit = {}): Promise<T> {
	const currentToken = getToken();
	const url = `${API_BASE_URL}${endpoint}`;
	const headers: Record<string, string> = {
		'Content-Type': 'application/json',
		...((options.headers as Record<string, string>) || {})
	};

	if (currentToken) {
		headers['Authorization'] = `Bearer ${currentToken}`;
	}

	try {
		const response = await fetch(url, {
			...options,
			headers
		});
		let data;
		try {
			data = await response.json();
		} catch (parseError) {
			// Если не JSON - создаем ошибку
			throw new ApiError('Неверный формат ответа сервера', response.status, 'INVALID_JSON');
		}

		if (!response.ok) {
			if (response.status === 401) {
				clearToken();
			}

			const errorMessage = data.error?.message || data.message || `Ошибка ${response.status}`;

			const errorCode = data.error?.code || `HTTP_${response.status}`;

			throw new ApiError(errorMessage, response.status, errorCode);
		}

		return data;
	} catch (error) {
		if (error instanceof ApiError) {
			throw error;
		}

		if (error instanceof TypeError) {
			throw new ApiError('Ошибка соединения с сервером', 0, 'NETWORK_ERROR');
		}

		throw new ApiError('Произошла неизвестная ошибка', 0, 'UNKNOWN_ERROR');
	}
}

export async function apiGet<T>(endpoint: string): Promise<T> {
	return apiRequest<T>(endpoint, { method: 'GET' });
}

// POST запрос
export async function apiPost<T>(endpoint: string, body: unknown): Promise<T> {
	return apiRequest<T>(endpoint, {
		method: 'POST',
		body: JSON.stringify(body)
	});
}
