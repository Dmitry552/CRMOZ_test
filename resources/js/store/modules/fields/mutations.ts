import * as types from './mutationsFieldsTypes';
import {TFieldsState} from "./index";

export default {
    [types.GET_FIELDS]: (state: TFieldsState, payload): void => {
        state.fields = payload;
    },
}
