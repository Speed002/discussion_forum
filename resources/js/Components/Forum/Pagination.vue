<template>
    <nav class="relative flex justify-center">
        <Link v-for="link in pagination.links"
        :key="link.label"
        :href="link.url ?? ''"
        class="flex items-center justify-center px-3 py-2 text-sm rounded-lg text-gray-600"
        :class="{ 'bg-gray-200' :link.active, 'opacity-50' : !link.url }"
        >
            {{ link.label }}
        </Link>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    pagination:Object
})
</script>
