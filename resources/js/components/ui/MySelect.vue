<script setup lang="ts">
import {useField} from "vee-validate";

type TProps = {
    title?: string,
    name: string,
    type: string
    positions: object[],
    required: boolean
}

const props = withDefaults(defineProps<TProps>(), {
    title: '',
});

const { value, errorMessage} = useField<string | boolean>(props.name);
</script>

<template>
    <div class="mb-5">
        <label
            v-if="props.title"
            :for="props.name"
            class="block mb-2 text-sm font-medium text-gray-500"
        >
            {{ props.title }}
            <span
                v-if="props.required"
                :class="[props.required ? 'ml-0.5 text-red-500' : 'display:none']"
            >*</span>
        </label>
        <select
            v-model="value"
            :id="props.name"
            class="bg-gray-50 border border-gray-300 text-gray-900
                sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
            :class="{['border-red-500']: errorMessage}"
        >
            <option
                v-for="(position, key) in props.positions"
                :value="position"
                :key="key"
            >
                {{position}}
            </option>
        </select>
        <span v-if="errorMessage" class="text-sm text-red-500">{{errorMessage}}</span>
    </div>
</template>

<style scoped>

</style>
