<script setup lang="ts">
import {useStore} from "../store";
import {computed, ref} from "vue";
import useInputGenerate from "../composables/useInputGenerate";
import {IGetField} from "../store/modules/fields/types";
import {useForm} from 'vee-validate';
import useDataForForm from "../composables/useDataForForm";
import swal from "sweetalert";

const store = useStore();
const {
    getInputFields,
    fieldsForm
} = useInputGenerate();
const {getDataForForm, dataForForm} = useDataForForm()

const defaultsFields = ref({
    account: ['Account_Name', 'Website', 'Phone'],
    deal: ['Deal_Name', 'Stage']
});

const getFields = (data) => store.dispatch('getFields', data);
const createModules = (data) => store.dispatch('createModules', data);

const fields = computed<IGetField[]>(() => store.getters.getFields);

try {
    await getFields(defaultsFields.value);
    await getInputFields(fields.value);
    await getDataForForm(fields.value);
} catch (err) {
    swal({
        title: "Ops!",
        text: err.data.error,
        icon: "warning",
    })
}

const {handleSubmit, errors, handleReset} = useForm(dataForForm.value);

const handleSignUp = handleSubmit(value => {
    createModules(value).then(() => {
        swal({
            title: "Ok!",
            icon: "success",
        });
    }).catch((err) => {
        swal({
            title: "Ops!",
            text: err.data.error,
            icon: "warning",
        })
    }).finally(() => {
        handleReset();
    });
});

</script>

<template>
    <div class="w-full pb-4">
        <main class="bg-white h-full px-2 flex justify-center items-start">
            <div
                class="w-full flex items-center justify-center p-4 mt-16 sm:mt-16"
            >
                <div class="mx-auto w-full  max-w-[550px] bg-white">
                    <form
                        class="mt-4 space-y-4 lg:mt-5 md:space-y-5 "
                    >
                        <h3 class="mb-2 text-center text-lg font-bold text-gray-500">Account</h3>
                        <div v-for="(field, index) in fieldsForm.account" :key="index">
                            <component :is="field.component" v-bind="field.props"/>
                        </div>
                        <h3 class="mb-2 text-center text-lg font-bold text-gray-500">Deal</h3>
                        <div v-for="(field, index) in fieldsForm.deal" :key="index">
                            <component :is="field.component" v-bind="field.props"/>
                        </div>
                        <div>
                            <button
                                @click.prevent="handleSignUp"
                                class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base
                                    font-semibold text-white outline-none mt-4">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>

</style>
