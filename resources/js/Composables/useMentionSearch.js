import { ref } from 'vue'

const mentionSearchResults = ref([])

export default () => {
    const mentionSearch = ($query) => {
        mentionSearchResults.value = [
            {}
        ]
    }

    return {
        mentionSearch,
        mentionSearchResults
    }
}
