<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ForumLayout from '@/Layouts/ForumLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Select from '@/Components/Select.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Discussion from '@/Components/Forum/Discussion.vue';
import Pagination from '@/Components/Forum/Pagination.vue';
import Navigation from '@/Components/Forum/Navigation.vue';
import { ref, watch } from 'vue';
// importing loadash to help clear out the urls incase any filter is not being used or empty
import _omitBy from 'lodash.omitby';
import _isEmpty from 'lodash.isempty';
import _debounce from 'lodash.debounce';
// composable
import useCreateDiscussion from '@/Composables/useCreateDiscussion';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    discussions:Object,
    query:Object
})

// invoking the useCreateDiscussion before using it
const { showCreateDiscussionForm } = useCreateDiscussion() //at this point, we are pulling out the visible item returned from the useCreateDiscusison export function, which we can now use in our application

const filterTopic = (e) => {
    router.visit('/', {
        // using the omit and empty to clear the url incase any filter is empty
        data:_omitBy({
        // initiating a filter topic
        'filter[topic]' : e.target.value
        }, _isEmpty),
        preserveScroll:true
    })
}

const searchQuery = ref(props.query.search || '')

const handleSearchInput = _debounce((query) => {
    router.reload({
        data:{search: query},
        preserveScroll:true
    })
}, 500)
// here, we are watching any changes inside the searchQuery watch(searchQuery, () => {}), when we use watch(), we expect a call back
watch(searchQuery, (query) => {
    handleSearchInput(query)
})

</script>

<template>
    <Head title="Forum" />

    <ForumLayout>
        <template #side>
            <PrimaryButton v-on:click="showCreateDiscussionForm" class="w-full flex justify-center h-10" v-if="$page.props.auth.user">
                start a discussion
            </PrimaryButton>
            <Navigation :query="query"/>
        </template>
        <div class="space-y-6">
            <!-- this stands as the default slot -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 text-gray-900 flex items-center space-x-3">
                    <div class="flex-grow">
                        <InputLabel for="search" value="Search" id="search" class="sr-only"/>
                        <TextInput type="search" id="search" class="w-full" v-model="searchQuery" placeholder="Search discussions..."/>
                    </div>
                    <div>
                        <InputLabel for="topic" value="Topic" id="topic" class="sr-only"/>
                        <Select id="topic" v-on:change="filterTopic"    >
                            <option value="">All topics</option>
                            <option
                            :value="topic.slug"
                            v-for="topic in $page.props.topics"
                            :key="topic.id"
                            :selected="$page.props.query.filter?.topic == topic.slug"
                            >
                                {{ topic.name }}
                            </option>
                        </Select>
                    </div>
                </div>
            </div>
            <!-- {{ discussions.meta }} -->
            <div class="space-y-3">
                <template v-if="discussions.data.length">
                    <Discussion v-for="discussion in discussions.data" :key="discussion.id" :discussion="discussion"/>
                    <Pagination :pagination="discussions.meta"/>
                </template>
            </div>
        </div>
    </ForumLayout>
</template>

