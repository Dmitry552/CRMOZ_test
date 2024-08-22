<script lang="ts" setup>

import {useStore} from "../store";
import {computed} from "vue";
import {useRouter} from "vue-router";

const store = useStore();
const {push} = useRouter()

const user = computed(() => store.getters.getUser);

const logoutUser = () => store.dispatch('logout');

function handleSignOut() {
    logoutUser().then(() => {
        push({name: 'login'});
    })
}
</script>

<template>
    <header class="bg-white absolute w-full px-2">
        <nav class="mx-auto flex max-w-full items-center justify-end p-2 lg:px-3">
            <div class="flex items-center">
                <div class="px-4 py-3 text-sm text-gray-900">
                    <div>{{user?.lastName}} {{user?.firstName}}</div>
                </div>
                <div class="py-1">
                    <button
                        @click="handleSignOut"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-300 w-full text-center"
                    >
                        Sign out
                    </button>
                </div>
            </div>
        </nav>
    </header>
</template>

<style scoped>

</style>
