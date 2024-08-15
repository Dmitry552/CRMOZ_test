import {$http} from "../../../utils/http";
import * as types from './mutationsFieldsTypes';
import {Commit} from "vuex";
import {CustomAction} from "../../types";
import {TFieldsState} from "./index";

export const getFields: CustomAction<TFieldsState> = (
    {commit}: {commit: Commit},
    data
): Promise<any> => {
    return new Promise((resolve, reject) => {
        let query = '';
        if (data) {
            query = '?fields='+JSON.stringify(data);
        }

        $http.get(`/api/fields${query}`).then(({data}) => {
            commit(types.GET_FIELDS, data);
            resolve();
        }).catch((err) => {
            reject(err);
        });
    });
};
