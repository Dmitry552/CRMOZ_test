import * as getters from './getters';
import * as actions from './actions';
import mutations from "./mutations";
import {CustomModule} from "../../types";

export type TFieldsState = {
    fields: Field | null
}

const state: TFieldsState = {
    fields: null
}

const FieldModule: CustomModule<TFieldsState> = {
    state,
    getters,
    actions,
    mutations
}

export default FieldModule;
