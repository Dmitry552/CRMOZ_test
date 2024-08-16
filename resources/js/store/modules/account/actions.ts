import {$http} from "../../../utils/http";
import {CustomAction} from "../../types";

export const createAccount: CustomAction = (
    {},
    data
): Promise<any> => {
    return new Promise((resolve, reject) => {
        $http.post(`/api/account`, data).then(() => {
            resolve();
        }).catch((err) => {
            reject(err);
        });
    });
};
