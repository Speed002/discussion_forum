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

// invoking the useCreateDiscussion before using it from this composable
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

// MEILISEARCH...
// this value searchQuery is binded to v-model="searchQuery" in the search input field
const searchQuery = ref(props.query.search || '')

// debouncing helps to delay the execution of a function by a specific timeframe
const handleSearchInput = _debounce((query) => {
    // the router reload makes a request to the same page, without changing us on another page, its like refreshing the page with new data
    router.reload({
        // this is the data we pass to the controller to search for, and as we accept it there,
        // we accept it as $request->search, because the data passed on to the controller is search which is
        // coming from data.search
        data:{
            search: query
        },
        preserveScroll:true
    })
}, 500)
// here, we are watching any changes inside the searchQuery watch(searchQuery, () => {}), when we use watch(), we expect a call back
// watch is waiting to hear any changes inside the value searchQuery, andit will return a callback to inform us incase there's any
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
