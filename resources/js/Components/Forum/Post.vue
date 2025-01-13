<script setup>
import useCreatePost from '@/Composables/useCreatePost';
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputLabel from '../InputLabel.vue';
import InputError from '../InputError.vue';
import PrimaryButton from '../PrimaryButton.vue';

const props = defineProps({
    post:Object,
    isSolution:Boolean
})
const { showCreatePostForm } = useCreatePost()

const editing = ref(false) //we reference it later as editing.value since it carries a value of false inside the ref

const editForm = useForm({
    body:props.post.body
})

const updatePost = () => {
    editForm.patch(route('posts.patch', props.post), {
        preserveScroll:true,
        onSuccess: () => {
            editing.value = false
        }
    })
}

const deletePost = () => {
    if(window.confirm("Confirm to delete:")){
        router.delete(route('posts.destroy', props.post), {
            preserveScroll:true
        })
    }
}
</script>
<template>
    <div :id="`post-${post.id}`"
    class="relative bg-white overflow-hidden shadow-sm sm:rounded-lg p-3 text-gray-900 flex items-start space-x-3 border-2 border-transparent"
    :class="{'border-gray-900': isSolution, 'border-transparent': !isSolution}"
    >
        <div class="w-7 flex-shrink-0">
            <img :src="post.user?.avatar_url" class="w-7 h-7 rounded-full" v-if="post.user">
        </div>

        <div class="w-full">
            <div>
                <div>{{ post.user?.username || '[user deleted]' }}</div>
                <div class="text-sm text-gray-500">Posted {{ post.created_at.human }}</div>
            </div>
            <div class="mt-3">
                <!-- show this form if we are editing -->
                <form v-on:submit.prevent="updatePost" v-if="editing">
                    <InputLabel for="body" value="Body" class="sr-only"/>
                    <textarea v-model="editForm.body" id="body" class="w-full h-48 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-2 align-top" rows="8"></textarea>
                    <InputError class="mt-2" :message="editForm.errors.body"/>

                    <div class="flex items-center space-x-3 mt-2">
                        <PrimaryButton >
                            Edit
                        </PrimaryButton>
                        <button v-on:click="editing = false" class="text-sm">Cancel</button>
                    </div>
                </form>

                <div v-else v-html="post.body_markdown" class="markdown"></div>
            </div>

            <ul class="flex items-center space-x-3 mt-6">
                <li v-if="post.discussion.user_can.reply">
                    <button v-on:click="showCreatePostForm(post.discussion)" class="text-indigo-500">Reply</button>
                </li>
                <li v-if="post.user_can.edit">
                    <button v-on:click="editing = true" class="text-indigo-500">Edit</button>
                </li>
                <li v-if="post.user_can.delete">
                    <button v-on:click="deletePost" class="text-indigo-500">Delete</button>
                </li>
                <li v-if="post.discussion.user_can.solve">
                    <button class="text-indigo-500"
                    v-on:click="router.patch(route('discussions.solution.patch', post.discussion), {post_id: isSolution ? 'null' : post.id}, {preserveScroll:true})"
                    >{{ isSolution ? 'Unmark' : 'Mark' }} best solution</button>
                </li>
            </ul>
        </div>

        <div class="absolute right-0 top-0 bg-gray-800 text-gray-100 px-3 py-1 text-xs uppercase tracking-wide font-semibold rounded-bl" v-if="isSolution">Best answer</div>

    </div>
</template>

