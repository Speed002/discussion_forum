<script setup>
import useCreatePost from '@/Composables/useCreatePost';
import FixedFormWrapper from './FixedFormWrapper.vue';
import InputLabel from '../InputLabel.vue';
import InputError from '../InputError.vue';
import PrimaryButton from '../PrimaryButton.vue';

// invoking the useCreateDiscussion before using it
const { visible, hideCreatePostForm, form, discussion } = useCreatePost() //at this point, we are pulling out the visible item returned from the useCreateDiscusison export function, which we can now use in our application

const createPost = () => {
    form.post(route('posts.store', discussion.value), {
        onSuccess: () => {
            form.reset()
            hideCreatePostForm()
        }
    })
}

</script>

<template>
    <FixedFormWrapper v-if="visible" v-on:submit.prevent="createPost" :form="form">
        <template v-slot:header>
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-medium">Replying to {{ discussion.title }}</h1>
                <button v-on:click="hideCreatePostForm">&times;</button>
            </div>
        </template>

        <template v-slot:main="{ markdownPreviewEnabled }">
            <!-- {{ form }} -->
            <div class="mt-4">
                <InputLabel for="body" value="Body" class="sr-only"/>
                <textarea id="body" v-if="!markdownPreviewEnabled" class="w-full h-48 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-2 align-top" v-model="form.body" rows="6"/>
                <InputError class="mt-2" :message="form.errors.body"/>
            </div>
        </template>

        <template v-slot:button>
            <PrimaryButton>
                Reply
            </PrimaryButton>
        </template>
    </FixedFormWrapper>
</template>

