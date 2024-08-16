import {$http} from "../../../utils/http";
import {CustomAction} from "../../types";

export const createDeal: CustomAction = (
    {},
    data
): Promise<any> => {
    return new Promise((resolve, reject) => {
        $http.post(`/api/deal`, data).then(({data}) => {
            resolve(data);
        }).catch((err) => {
            reject(err);
        });
    });
};
