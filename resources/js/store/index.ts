import type {InjectionKey} from 'vue';
import { createStore, Store, useStore as baseUseStore} from 'vuex';
import type {TRootState} from "./types";
import FieldModule from "./modules/fields";
import Module from "./modules/module";
import AccountModule from "./modules/account";
import DealModule from "./modules/deal";

export const key: InjectionKey<Store<TRootState>> = Symbol();

export const store: Store<TRootState> = createStore<TRootState>({
    modules: {
        field: FieldModule,
        account: AccountModule,
        deal: DealModule,
        module: Module
    }
});

export function useStore (): Store<TRootState> {
    return baseUseStore(key)
}
