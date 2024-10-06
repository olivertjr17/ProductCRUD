<template>
    <div class="sidebar">
        <nav>
            <ul>
                <li><router-link to="/">Products</router-link></li>
                <li>
                    <router-link to="/product/create"
                        >Create Product</router-link
                    >
                </li>
                <li><router-link to="/videos">Videos</router-link></li>
                <li>
                    <button @click="logout" class="btn btn-danger">
                        Logout
                    </button>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import axios from "axios";
import { useRouter } from "vue-router";

export default {
    setup() {
        const router = useRouter();

        const logout = async () => {
            try {
                await axios.post("/logout", {}, { withCredentials: true });
                router.push("/login");
            } catch (error) {
                console.error("Logout failed:", error);
                alert("Error during logout. Please try again.");
            }
        };

        return {
            logout,
        };
    },
};
</script>

<style scoped>
.sidebar {
    background: #f8f9fa;
    width: 250px;
    height: 100vh;
    position: fixed;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}
nav ul {
    list-style: none;
    padding: 0;
}
nav ul li {
    margin: 15px 0;
}
</style>
