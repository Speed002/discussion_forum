import { ref } from "vue"
import { useForm } from "@inertiajs/vue3"

const visible = ref(false) //so that the discussion form will always be on even if we refresh the page

const discussion = ref('')

const form = useForm({
    // anything inside an object or a dictionary does not use = it uses :
    body:''
})

export default () =>
{
    const showCreatePostForm = (discussionContext) => {
        discussion.value = discussionContext
        visible.value = true
    }

    const hideCreatePostForm = () => {
        visible.value = false
    }
    return {
        form,
        visible,
        showCreatePostForm,
        hideCreatePostForm,
        discussion
    }
}
