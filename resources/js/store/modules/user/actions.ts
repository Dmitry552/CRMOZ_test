import {CustomAction} from "../../types";
import {TUserState} from "./";
import * as types from './mutationsUsersTypes';
import {$authHttp, $http} from "../../../utils/http";
import {store} from "../../index";

export const login: CustomAction<TUserState> = ({commit}, payload): Promise<void> => {
    return new Promise((resolve, reject): void => {
        $http.post('api/login', payload)
            .then(({data}) => {
                console.log(data);
                commit(types.SAVE_AUTH_TOKEN, {token: data.access_token});
                localStorage.setItem('token', data.access_token);
                resolve(data);
            })
            .catch(error => {
                reject(error.response);
            });
    });
}

export const getUser: CustomAction<TUserState> = ({commit}): Promise<void> => {
    return new Promise((resolve, reject): void => {
        $authHttp.get('api/user/me')
            .then(({data}) => {
                commit(types.SAVE_USER, {user: data});
                resolve(data);
            })
            .catch(error => {
                if (error.response.status === 401) {
                    commit(types.REMOVE_AUTH_TOKEN);
                    commit(types.REMOVE_USER);
                    localStorage.removeItem('token');
                }
                reject(error.response);
            });
    });
}

export const logout: CustomAction<TUserState> = ({commit}): Promise<void> => {
    return new Promise((resolve, reject): void => {
        $authHttp.post('api/user/logout')
            .then(() => {
                commit(types.REMOVE_AUTH_TOKEN);
                commit(types.REMOVE_USER);
                localStorage.removeItem('token');
                resolve();
            })
            .catch(error => {
                reject(error.response);
            });
    });
}
