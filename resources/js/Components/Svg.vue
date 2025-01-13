<template>
    <component :is="icon"></component>
</template>

<script setup>
import { defineAsyncComponent } from 'vue';

const props = defineProps({
    name:{
        type:String,
        required:true
    }
})

// importing and defining the components
const icon = defineAsyncComponent(() => import(`../../../resources/svg/${props.name}.svg`))
</script>
