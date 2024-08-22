import axios, {type AxiosInstance, InternalAxiosRequestConfig} from "axios";

const $http: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_APP_URL
});

const $authHttp = axios.create({
    baseURL: import.meta.env.VITE_APP_URL,
})

$authHttp.interceptors.request.use((value: InternalAxiosRequestConfig ): InternalAxiosRequestConfig => {
    value.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`
    return value;
});

export {
    $http,
    $authHttp
}
