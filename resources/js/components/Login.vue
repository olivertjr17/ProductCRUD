<template>
    <div>
        <h1>Login</h1>
        <form @submit.prevent="login">
            <div class="form-group">
                <label for="username">Username or Email:</label>
                <input
                    type="text"
                    v-model="username"
                    class="form-control"
                    id="username"
                    required
                />
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input
                    type="password"
                    v-model="password"
                    class="form-control"
                    id="password"
                    required
                />
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" v-model="rememberMe" /> Remember Me
                </label>
            </div>
            <button type="submit" class="btn btn-primary me-2">Login</button>
            <router-link to="/register"><button type="button" class="btn btn-primary">Register</button></router-link>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            username: "",
            password: "",
            rememberMe: false,
        };
    },
    methods: {
        login() {
            if (!this.username || !this.password) {
                alert("Username and password are required.");
                return;
            }

            const payload = {
                username: this.username,
                password: this.password,
                remember_me: this.rememberMe,
            };

            axios
                .post("/login", payload)
                .then((response) => {
                    localStorage.setItem(
                        "user",
                        JSON.stringify(response.data.user)
                    );

                    this.$router.push("/");
                })
                .catch((error) => {
                    console.error(
                        "There was an error logging in:",
                        error.response.data
                    );
                    if (error.response && error.response.status === 422) {
                        // Handle validation errors (if any)
                        const errors = error.response.data.errors;
                        const errorMessage = Object.values(errors)
                            .flat()
                            .join("\n");
                        alert(`Login failed:\n${errorMessage}`);
                    } else {
                        alert(
                            "Login failed. Please check your credentials and try again."
                        );
                    }
                });
        },
    },
};
</script>

<style scoped>

</style>
