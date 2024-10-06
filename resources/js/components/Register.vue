<template>
    <div>
        <h1>Register</h1>
        <form @submit.prevent="register">
            <div class="form-group">
                <label for="name">Name:</label>
                <input
                    type="text"
                    v-model="name"
                    class="form-control"
                    id="name"
                    required
                />
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input
                    type="text"
                    v-model="username"
                    class="form-control"
                    id="username"
                    required
                />
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input
                    type="email"
                    v-model="email"
                    class="form-control"
                    id="email"
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
                <label for="password_confirmation">Confirm Password:</label>
                <input
                    type="password"
                    v-model="password_confirmation"
                    class="form-control"
                    id="password_confirmation"
                    required
                />
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            username: "",
            email: "",
            password: "",
            password_confirmation: "",
        };
    },
    methods: {
        register() {
            if (!this.name || !this.username || !this.email || !this.password) {
                alert("All fields are required.");
                return;
            }

            const payload = {
                name: this.name, 
                username: this.username,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
            };

            axios
                .post("/register", payload)
                .then((response) => {
                    console.log("Registration successful:", response.data);
                    this.$router.push("/login");
                    alert("Registration successful! You can now log in.");
                })
                .catch((error) => {
                    // Handle error response
                    console.error(
                        "There was an error registering:",
                        error.response.data
                    );
                    if (error.response && error.response.status === 422) {
                        // Handle validation errors (if any)
                        const errors = error.response.data.errors;
                        const errorMessage = Object.values(errors)
                            .flat()
                            .join("\n");
                        alert(`Registration failed:\n${errorMessage}`);
                    } else {
                        alert("Registration failed. Please try again.");
                    }
                });
        },
    },
};
</script>

<style scoped>

</style>
