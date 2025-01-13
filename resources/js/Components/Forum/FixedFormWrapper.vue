<script setup>
// import axios from 'axios'; is by default imported already
import { ref, watch } from 'vue';
import MarkdownShortcutToolbar from './MarkdownShortcutToolbar.vue';

const markdownPreviewEnabled = ref(false)

const markdownPreviewHtml = ref('')

const markdownPreviewLoading = ref(false)

const props = defineProps({
    form:Object
})

// we are watching the markdownPreviewEnabled to see any changes so we can enable or disable markdownPreviewHtml
watch(markdownPreviewEnabled, (toggled) => {
    if(!toggled){
        return
    }
    markdownPreviewLoading.value = true
    axios.post(route('markdown'), {body:props.form.body}).then((response) => {
        markdownPreviewHtml.value = response.data.html
        markdownPreviewLoading.value = false
    })

})
</script>

<template>
    <form  class="fixed bottom-0 w-full bg-white p-6 border-t-4 border-gray-100 space-y-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <slot name="header"/>
            </div>
            <div class="mt-4">
                <slot name="main" :markdownPreviewEnabled="markdownPreviewEnabled"/>
                <!-- only shows when the markdown preview is enabled -->
                <div class="h-48 bg-gray-100 rounded-lg px-3 py-2 overflow-y-scroll border border-gray-300 shadow-sm" v-if="markdownPreviewEnabled" v-html="markdownPreviewHtml" :class="{'opacity-50': markdownPreviewLoading}">

                </div>

                <div class="flex items-center justify-between">

                    <MarkdownShortcutToolbar for="body"/>

                    <button type="button" class="text-sm text-indigo-500" v-on:click="markdownPreviewEnabled = !markdownPreviewEnabled">{{ markdownPreviewEnabled ? 'Turn Off' : 'Turn on' }} markdown preview</button>
                </div>
            </div>

            <div class="mt-4">
                <slot name="button"/>
            </div>
        </div>
    </form>
</template>

