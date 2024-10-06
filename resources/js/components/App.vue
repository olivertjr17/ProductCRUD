<template>
    <div class="app-container">
        <Sidebar v-if="showSidebar" />
        <div class="content" :class="{ 'full-width': !showSidebar }">
            <router-view />
        </div>
    </div>
</template>

<script>
import Sidebar from "./Sidebar.vue";

export default {
    components: {
        Sidebar,
    },
    computed: {
        showSidebar() {
            return !["/login", "/register"].includes(this.$route.path);
        },
    },
    methods: {
        logout() {
            axios
                .post("/logout")
                .then((response) => {
                    console.log("Logout successful:", response.data);
                    localStorage.removeItem("user");
                    this.$router.push("/login");
                    alert("Logout successful!");
                })
                .catch((error) => {
                    console.error(
                        "There was an error logging out:",
                        error.response.data
                    );
                    alert("Logout failed. Please try again.");
                });
        },
    },
};
</script>

<style scoped>
.app-container {
    display: flex;
}

.content {
    padding: 20px;
}

.full-width {
    margin-left: 0;
}

.content:not(.full-width) {
    margin-left: 250px;
}
</style>
