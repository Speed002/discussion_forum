import { ref } from "vue"
import { useForm } from "@inertiajs/vue3"

const visible = ref(true) //so that the discussion form will always be on even if we refresh the page

const form = useForm({
    // anything inside an object or a dictionary does not use = it uses :
    topic_id:'',
    title:'',
    body:''
})

export default () =>
{
    const showCreateDiscussionForm = () => {
        visible.value = true
    }

    const hideCreateDiscussionForm = () => {
        visible.value = false
    }
    return {
        form,
        visible,
        showCreateDiscussionForm,
        hideCreateDiscussionForm
    }
}
