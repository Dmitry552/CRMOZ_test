<script setup lang="ts">
import { RouterView } from 'vue-router';
</script>

<template>
    <Suspense>
        <template #fallback>
            ...Loading
        </template>
        <RouterView/>
    </Suspense>
</template>

<style scoped>

</style>
