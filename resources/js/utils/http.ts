import axios, {type AxiosInstance} from "axios";

const $http: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_APP_URL
});

export {
    $http
}
