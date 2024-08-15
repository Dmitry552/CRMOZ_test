import type {Action, Module} from "vuex";
import {TFieldsState} from "./modules/fields";

export type TRootState = {
    field: TFieldsState,
};

export type CustomAction<T> = Action<T, TRootState>;
export type CustomModule<T> = Module<T, TRootState>;
