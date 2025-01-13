<script setup>
import ForumLayout from '@/Layouts/ForumLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Post from '@/Components/Forum/Post.vue';
import Pagination from '@/Components/Forum/Pagination.vue';
import Navigation from '@/Components/Forum/Navigation.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import useCreatePost from '@/Composables/useCreatePost';
import { onMounted, onUpdated, nextTick } from 'vue';
import VueScrollTo from 'vue-scrollto'


const { showCreatePostForm } = useCreatePost()

const props = defineProps({
    discussion:Object,
    posts:Object,
    query:Object,
    postId:Number
})

const scrollToPost = (postId) => {
    if(!props.postId){
        return
    }

    nextTick(() => {
        VueScrollTo.scrollTo(`#post-${postId}`, 500, {offset: -50})
    })
}

onMounted(() => {
    scrollToPost(props.postId)
})
// onUpdated(() => {
//     scrollToPost(props.postId)
// })

// deleting a discussion
const deleteDiscussion = () => {
    if(window.confirm("Confirm to delete:")){
        router.delete(route('discussions.destroy', props.discussion), {
            // preserveScroll:true
        })
    }
}

</script>

<template>
    <Head :title="discussion.title" />

    <ForumLayout>
        <template #side>
            <!-- v-if="$page.props.auth.user"> -->
            <PrimaryButton v-on:click="showCreatePostForm(discussion)"
            class="w-full flex justify-center h-10"
            v-if="discussion.user_can.reply">
                Reply to discussion
            </PrimaryButton>
            <Navigation :query="query"/>
        </template>
        <div class="space-y-3">
            <!-- this stands as the default slot -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- {{ discussion.solution }} -->
                <div class="p-3 text-gray-900">
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-0.5 text-sm text-gray-600">
                            <!-- For this topic name to be shown, the topic relationship has to be loaded using: -->
                             <!-- $discussion->load('topic') and if there are other relationships depended on to display the data: we do these in an array $discussion->load([...]) -->
                            {{ discussion.topic.name }}

                        </span>

                        <h3 class="text-md font-medium">
                            <template v-if="discussion.is_pinned">
                                [pinned]
                            </template>
                            {{ discussion.title}}
                        </h3>

                        <ul>
                            <li v-if="discussion.user_can.delete">
                                <button class="text-indigo-700 text-sm" v-on:click="deleteDiscussion">Delete</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <template v-if="posts.data.length">
                <Post v-for="post in posts.data" :key="post.id" :post="post" :isSolution="discussion.solution?.id === post.id"/>
                <Pagination class="!mt-6" :pagination="posts.meta" />
            </template>

        </div>
    </ForumLayout>
</template>

