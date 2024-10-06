<template>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li v-if="data.current_page > 1" class="page-item">
                <a class="page-link" @click="changePage(data.current_page - 1)"
                    >Previous</a
                >
            </li>
            <li
                v-for="page in totalPages"
                :key="page"
                class="page-item"
                :class="{ active: page === data.current_page }"
            >
                <a class="page-link" @click="changePage(page)">{{ page }}</a>
            </li>
            <li v-if="data.current_page < data.last_page" class="page-item">
                <a class="page-link" @click="changePage(data.current_page + 1)"
                    >Next</a
                >
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        data: Object,
    },
    computed: {
        totalPages() {
            const pages = [];
            for (let i = 1; i <= this.data.last_page; i++) {
                pages.push(i);
            }
            return pages;
        },
    },
    methods: {
        changePage(page) {
            this.$emit("pagination-change-page", page);
        },
    },
};
</script>

<style scoped>

</style>
