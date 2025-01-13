<template>
    <markdown-toolbar class="flex items-center">
        <md-bold class="cursor-pointer py-1.5 px-1">
            <Svg name="zip-file"></Svg>
        </md-bold>
        <md-italic class="cursor-pointer py-1.5 px-1">
            Italic
        </md-italic>
        <md-code class="cursor-pointer py-1.5 px-1">code</md-code>
        <md-link class="cursor-pointer py-1.5 px-1">link</md-link>
    </markdown-toolbar>
</template>

<script setup>
import Svg from '../Svg.vue';

</script>
