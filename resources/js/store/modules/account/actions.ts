import {$authHttp} from "../../../utils/http";
import {CustomAction} from "../../types";

export const createAccount: CustomAction = (
    {},
    payload
): Promise<any> => {
    return new Promise((resolve, reject) => {
        $authHttp.post(`/api/account`, payload).then(({data}) => {
            resolve(data);
        }).catch((err) => {
            reject(err);
        });
    });
};
