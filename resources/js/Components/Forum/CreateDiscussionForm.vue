<script setup>
import useCreateDiscussion from '@/Composables/useCreateDiscussion';
import FixedFormWrapper from './FixedFormWrapper.vue';
import TextInput from '../TextInput.vue';
import InputLabel from '../InputLabel.vue';
import InputError from '../InputError.vue';
import Select from '../Select.vue';
import Textarea from './Textarea.vue';
import PrimaryButton from '../PrimaryButton.vue';
import { Mentionable } from 'vue-mention';

// invoking the useCreateDiscussion before using it
const { visible, hideCreateDiscussionForm, form } = useCreateDiscussion() //at this point, we are pulling out the visible item returned from the useCreateDiscusison export function, which we can now use in our application

const createDiscussion = () => {
    form.post(route('discussion.store'), {
        onSuccess: () => {
            form.reset()
            hideCreateDiscussionForm()
        }
    })
}

</script>

<template>
    <FixedFormWrapper v-if="visible" v-on:submit.prevent="createDiscussion" :form="form">
        <template v-slot:header>
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-medium">New Discussion</h1>
                <button v-on:click="hideCreateDiscussionForm">&times;</button>
            </div>
        </template>

        <template v-slot:main="{ markdownPreviewEnabled }">
            <!-- {{ form }} -->
            <div class="flex items-start space-x-3">
                <div class="flex-grow">
                    <div>
                        <InputLabel for="title" value="Title" class="sr-only"/>
                        <TextInput type="text" class="w-full" v-model="form.title"/>
                        <InputError class="mt-2" :message="form.errors.title"/>
                    </div>
                </div>

                <div>
                    <select id="topic" v-model="form.topic_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-2">
                        <option value="">Choose topic</option>
                        <option
                        :value="topic.id"
                        v-for="topic in $page.props.topics"
                        :key="topic.id"
                        :selected="$page.props.query?.filter?.topic == topic.slug"
                        >
                            {{ topic.name }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.topic_id"/>
                </div>
            </div>
            <div class="mt-4">
                <InputLabel for="body" value="Body" class="sr-only"/>

                <Mentionable :keys="['@']" offset="6" :items="[{label:'Alex (@alex)', value:'alex'}, {label:'Mabel (@mabel)', value:'mabel'}]">
                    <textarea id="body" v-if="!markdownPreviewEnabled" class="w-full h-48 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-2 align-top" v-model="form.body" rows="6"/>
                </Mentionable>

                <InputError class="mt-2" :message="form.errors.body"/>
            </div>
        </template>

        <template v-slot:button>
            <PrimaryButton>
                Create discussion
            </PrimaryButton>
        </template>
    </FixedFormWrapper>
</template>

