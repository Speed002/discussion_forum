<template>
    <Link :href="route('discussion.show', discussion)" class="block bg-white overflow-hidden shadow-sm sm:rounded-md">
        <div class="p-3 text-gray-900 flex items-center space-x-6">
            <div class="flex-grow">
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-0.5 text-sm text-gray-600">
                        {{ discussion.topic.name }}
                    </span>
                    <h3 class="text-md font-medium">
                        <template v-if="discussion.is_pinned">
                            [pinned]
                        </template>
                        {{ discussion.title}}
                    </h3>
                </div>
                <!-- {{ discussion }} -->
                <div class="text-gray-500 text-sm mt-3 line-clamp-1">
                    {{ discussion.post?.body_preview }}
                </div>

                <Link v-if="discussion.latest_post" :href="`${route('discussion.show', discussion)}?post=${discussion.latest_post.id}`" class="text-sm mt-6">
                    Last post by {{ discussion.latest_post?.user?.username }} <time :datetime="discussion.latest_post?.created_at.datetime" :title="discussion.latest_post?.created_at.datetime">{{ discussion.latest_post?.created_at.human }}</time>
                </Link>
            </div>

            <div class="flex-shrink-0">
                <div class="flex flex-col items-end">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-start -space-x-2">
                            <img :src="participant.avatar_url" v-for="participant in participants" :key="participant.id" alt="" class="h-6 w-6 rounded-full ring-2 ring-white first-of-type:w-7 first-of-type:h-7">
                        </div>
                        <span v-if="discussion.participants.length > 2"> + {{ discussion.participants.length - 2 }} more</span>
                    </div>
                    <div class="text-sm">{{ pluralize('reply', discussion.replies_count, true) }} </div>
                </div>
            </div>
        </div>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import pluralize from 'pluralize';

const participants = computed(() => props.discussion.participants.slice(0, 3))
const props = defineProps({
    discussion:Object
})
</script>
