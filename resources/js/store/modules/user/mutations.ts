import * as types from './mutationsUsersTypes';
import {TUserState} from "./index";
import {store} from "../../index";

export default {
    [types.SAVE_AUTH_TOKEN]: (state: TUserState, payload: {token: string}): void => {
        state.token = payload.token;
    },
    [types.SAVE_USER]: (state: TUserState, payload: {user}): void => {
        state.user = payload.user;
    },
    [types.REMOVE_AUTH_TOKEN]: (state: TUserState): void => {
        state.token = '';
    },
    [types.REMOVE_USER]: (state: TUserState): void => {
        state.user = null;
    }
}

export const setToken = (data) => store.commit(types.SAVE_AUTH_TOKEN, {token: data})
