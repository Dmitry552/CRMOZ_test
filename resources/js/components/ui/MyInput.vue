<script lang="ts" setup>
import {useField} from "vee-validate";

type TInputTextProps = {
    title?: string,
    type?: string,
    name: string,
    placeholder?: string,
    required: boolean
}

const props = withDefaults(defineProps<TInputTextProps>(), {
    title: '',
    type: 'text',
    placeholder: '',
    required: false
});

const { value, errorMessage} = useField<string | boolean>(props.name);
</script>

<template>
    <label
        v-if="props.title"
        :for="props.name"
        class="block mb-2 text-sm font-medium text-gray-500"
    >
        {{ props.title }}
        <span
            v-if="props.required"
            :class="[props.required ? 'ml-0.5 text-red-500' : '']"
        >*</span>
    </label>
    <div>
        <input
            :type="props.type"
            v-model="value"
            :id="props.name"
            :placeholder="props.placeholder"
            class="bg-gray-50 border border-gray-300 text-gray-900
                sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
            :class="{['border-red-500']: errorMessage}"
        />
    </div>
    <span v-if="errorMessage" class="text-sm text-red-500">{{errorMessage}}</span>
</template>

<style scoped>

</style>

