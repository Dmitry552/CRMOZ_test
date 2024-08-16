<script setup lang="ts">
import {useStore} from "../store";
import {ref} from "vue";

import spinner from '../images/spinner.svg';
import CreateForm from "../components/CreateForm.vue";
import swal from "sweetalert";

const store = useStore();

const showAccount = ref(false);
const showDeal = ref(false);
const loading = ref(false);


const defaultsFields = ref({
    account: ['Account_Name', 'Website', 'Phone'],
    deal: ['Deal_Name', 'Stage']
});

const createModules = (data) => store.dispatch('createModules', data);
const createAccount = (data) => store.dispatch('createAccount', data);
const createDeal = (data) => store.dispatch('createDeal', data);

async function handleSubmit(value) {
    try {
        if (showDeal.value && !showAccount.value) {
            await createDeal(value);
        } else if (!showDeal.value && showAccount.value) {
            await createAccount(value)
        } else if (showDeal.value && showAccount.value) {
            await createModules(value)
        }
    } catch (err) {
        swal({
            title: "Ops!",
            text: err.data.error,
            icon: "warning",
        })
    }
}

function handleSetLoading(value) {
    loading.value = value;
}

</script>

<template>
    <div class="w-full pb-4">
        <main class="bg-white h-full px-2 flex justify-center items-start">
            <div
                class="w-full flex items-center justify-center p-4 mt-16 sm:mt-16"
            >
                <div class="mx-auto w-full  max-w-[550px] bg-white">
                    <div class="flex w-100 justify-center gap-4">
                        <div>
                            <input v-model="showAccount" type="checkbox" name="account" id="account">
                            <label
                                for="account"
                            >
                                Create Account
                            </label>
                        </div>
                        <div>
                            <input v-model="showDeal" type="checkbox" name="deal" id="deal">
                            <label
                                for="deal"
                            >
                                Create Deal
                            </label>
                        </div>
                    </div>
                    <div v-if="loading" class="h-[80px] flex w-100 justify-center">
                        <img class="h-[100%]" :src="spinner" alt="spinner">
                    </div>
                    <CreateForm
                        :defaultsFields="defaultsFields"
                        :createAccount="showAccount"
                        :createDeal="showDeal"
                        @submit="handleSubmit"
                        @setLoading="handleSetLoading"
                    />
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>

</style>
