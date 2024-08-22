import {$authHttp} from "../../../utils/http";
import {CustomAction} from "../../types";

export const createModules: CustomAction = (
    {},
    payload
): Promise<any> => {
    return new Promise((resolve, reject) => {
        $authHttp.post(`/api/module`, payload).then(({data}) => {
            resolve(data);
        }).catch((err) => {
            reject(err);
        });
    });
};
