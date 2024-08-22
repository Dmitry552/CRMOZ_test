import {$authHttp} from "../../../utils/http";
import {CustomAction} from "../../types";

export const createDeal: CustomAction = (
    {},
    payload
): Promise<any> => {
    return new Promise((resolve, reject) => {
        $authHttp.post(`/api/deal`, payload).then(({data}) => {
            resolve(data);
        }).catch((err) => {
            reject(err);
        });
    });
};
