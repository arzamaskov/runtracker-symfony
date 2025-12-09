import { apiPost, setToken, ApiError } from "$lib/api/client";

interface RegisterRequest{
    email: string,
    name: string,
    password: string
}
interface RegisterResponse{
    success: boolean,
    data: {
        id: string
    }
}

interface LoginRequest{
    email: string,
    password: string
}
interface LoginResponse{
    token: string
}

async function register(email: string, name: string, password: string) {
    const result = await apiPost<RegisterResponse>('/auth/register', { email, name, password });

    if (result.success && result.data?.id) {
        return {id: result.data.id}
    }
    throw new ApiError('Неверный формат ответа', 0, 'INVALID_RESPONSE');
}

async function login(email: string, password: string) {
    const result = await apiPost<LoginResponse>('/auth/token/login', {email, password});

    if (result.token) {
        setToken(result.token);
        return;
    } else {
        throw new ApiError('Ошибка авторизации', 401, 'AUTH_ERROR');
    }
}

export {register, login};
export type { RegisterResponse, RegisterRequest, LoginRequest, LoginResponse };
