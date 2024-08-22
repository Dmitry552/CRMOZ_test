<script lang="ts" setup>
import {useForm} from 'vee-validate';
import {string, object, ObjectSchema} from 'yup';
import {computed, ref} from "vue";
import {useStore} from "../store";
import swal from 'sweetalert';
import {useRouter} from "vue-router";
import MyInput from '../components/ui/MyInput.vue'

type TSchema = {
    email: string,
}

const {push} = useRouter();
const store = useStore();

const loading = ref<boolean>(false);

const schema = computed<ObjectSchema<TSchema>>(() => object({
        email: string()
            .required()
            .email(),
    })
);

const {handleSubmit, resetForm} = useForm<TSchema>({
    validationSchema: schema,
    initialValues: {
        email: '',
    }
});

const authUser = (data: TSchema) => store.dispatch('login', data);

const handleLogin = handleSubmit(value => {
    loading.value = true;
    authUser(value as TSchema)
        .then(() => {
            swal({
                title: "Ok!",
                icon: "success",
            }).then(() => {
                push('/form');
            });
        }).catch((err) => {
            swal({
                title: "Ops!",
                text: err.statusText,
                icon: "warning",
            })
    }).finally(() => {
        resetForm();
        loading.value = false
    });
});
</script>

<template>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div
            class="w-full bg-white rounded-lg shadow-md dark:border md:mt-0 sm:max-w-md xl:p-0"
        >
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-500">
                    Sign in to your account
                </h1>
                <form
                    class="space-y-4 md:space-y-6"
                >
                    <div>
                        <my-input
                            title="Your email"
                            type="email"
                            name="email"
                            placeholder="name@company.com"
                            :required="true"
                        />
                    </div>
                    <button
                        @click.prevent="handleLogin"
                        class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base
                                font-semibold text-white outline-none mt-4"
                    >
                        Sign in
                    </button>
                    <p class="text-sm font-light text-gray-500">
                        Don’t have an account yet?
                        <a href="/registration" class="font-medium text-primary-600 hover:underline">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
