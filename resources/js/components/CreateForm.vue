<script setup lang="ts">
import {useForm} from "vee-validate";
import {computed, ref, toRefs, watch} from "vue";
import {object} from "yup";
import swal from "sweetalert";
import useInputGenerate from "../composables/useInputGenerate";
import useDataForForm from "../composables/useDataForForm";
import {useStore} from "../store";
import {IGetField} from "../store/modules/fields/types";

type TProps = {
    createDeal: boolean,
    createAccount: boolean,
    defaultsFields: any
}

type TEmits = {
    (e: 'submit', value): void,
    (e: 'setLoading', value): void
}

const {
    getInputFields,
    fieldsForm
} = useInputGenerate();
const {getDataForForm, dataForForm} = useDataForForm()
const store = useStore();

const links = ref(false);

const props = defineProps<TProps>();
const emits = defineEmits<TEmits>();

const getFields = (data) => store.dispatch('getFields', data);
const fields = computed<IGetField[]>(() => store.getters.getFields);

const {handleSubmit, errors, handleReset, setFieldValue} = useForm({
    validationSchema: computed(() => object(dataForForm.value.validationSchema)),
    initialValues: dataForForm.value.initialValues
});

setFieldValue('link', false);

watch(() => [props.createDeal, props.createAccount], async ([valueDeal, valueAccount]) => {
    try {
        if (valueDeal && !valueAccount) {
            emits('setLoading', true);
            await getFields({deal: props.defaultsFields.deal});
            await getInputFields(fields.value);
            await getDataForForm(fields.value);
        } else if (!valueDeal && valueAccount) {
            emits('setLoading', true);
            await getFields({account: props.defaultsFields.account});
            await getInputFields(fields.value);
            await getDataForForm(fields.value);
        } else if (valueDeal && valueAccount) {
            emits('setLoading', true);
            await getFields(props.defaultsFields);
            await getInputFields(fields.value);
            await getDataForForm(fields.value);
        }
    } catch (err) {
        swal({
            title: "Ops!",
            text: err.data.error,
            icon: "warning",
        })
    } finally {
        emits('setLoading', false);
    }
})

const handleCreate = handleSubmit(value => {
    handleReset();
    links.value = false;
    emits('submit', value);
});

watch(links, () => {
    setFieldValue('link', links.value);
})
</script>

<template>
    <div v-if="props.createDeal && props.createAccount">
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
            <input v-model="links" type="checkbox" name="link" id="link">
            <label
                for="link"
            >
                Link Account to Deal
            </label>
            <div>
                <button
                    @click.prevent="handleCreate"
                    class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base
                                    font-semibold text-white outline-none mt-4">
                    Create
                </button>
            </div>
        </form>
    </div>
    <div v-if="props.createAccount && !props.createDeal">
        <form
            class="mt-4 space-y-4 lg:mt-5 md:space-y-5 "
        >
            <h3 class="mb-2 text-center text-lg font-bold text-gray-500">Account</h3>
            <div v-for="(field, index) in fieldsForm.account" :key="index">
                <component :is="field.component" v-bind="field.props"/>
            </div>
            <div>
                <button
                    @click.prevent="handleCreate"
                    class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base
                                    font-semibold text-white outline-none mt-4">
                    Create
                </button>
            </div>
        </form>
    </div>
    <div v-if="props.createDeal && !props.createAccount">
        <form
            class="mt-4 space-y-4 lg:mt-5 md:space-y-5 "
        >
            <h3 class="mb-2 text-center text-lg font-bold text-gray-500">Deal</h3>
            <div v-for="(field, index) in fieldsForm.deal" :key="index">
                <component :is="field.component" v-bind="field.props"/>
            </div>
            <div>
                <button
                    @click.prevent="handleCreate"
                    class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base
                                    font-semibold text-white outline-none mt-4">
                    Create
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
