import mutations from "./mutations";
import * as actions from "./actions";
import * as getters from "./getters";
import {User} from "../../../types";
import {Module} from "vuex";
import {TRootState} from "../../types";

export type TUserState = {
    token: string,
    user?: User | null

}

const state: TUserState = {
    token: localStorage.getItem('token') || '',
    user: null
};

const UserModule: Module<TUserState, TRootState> = {
    state,
    mutations,
    actions,
    getters
}

export default UserModule;
