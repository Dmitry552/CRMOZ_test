import {$http} from "../../../utils/http";
import {CustomAction} from "../../types";

export const createModules: CustomAction = (
    {},
    data
): Promise<any> => {
    return new Promise((resolve, reject) => {
        $http.post(`/api/module`, data).then(() => {
            resolve();
        }).catch((err) => {
            reject(err);
        });
    });
};
