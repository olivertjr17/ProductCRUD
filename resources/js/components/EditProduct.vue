<template>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Edit Product</h1>
        <form
            @submit.prevent="nextStep"
            class="card p-4 shadow"
            enctype="multipart/form-data"
        >
            <div v-if="currentStep === 1">
                <h3 class="mb-3">Step 1: Basic Information</h3>
                <div class="form-group mb-3">
                    <label for="name">Product Name</label>
                    <input
                        id="name"
                        v-model="product.name"
                        class="form-control"
                        placeholder="Enter product name"
                        required
                    />
                </div>
                <div class="form-group mb-3">
                    <label for="category">Category</label>
                    <select
                        id="category"
                        v-model="product.category"
                        class="form-select"
                        required
                    >
                        <option value="" disabled>Select Category</option>
                        <option
                            v-for="cat in categories"
                            :key="cat"
                            :value="cat"
                        >
                            {{ cat }}
                        </option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea
                        id="description"
                        v-model="product.description"
                        class="form-control"
                        rows="4"
                        placeholder="Enter product description"
                        required
                    ></textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="nextStep"
                    >
                        Next
                    </button>
                </div>
            </div>

            <div v-if="currentStep === 2">
                <h3 class="mb-3">Step 2: Upload Images</h3>
                <div class="form-group mb-3">
                    <label for="images">Select Images</label>
                    <input
                        id="images"
                        type="file"
                        class="form-control"
                        @change="handleFileUpload"
                        multiple
                    />
                </div>
                <div class="d-flex justify-content-between">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="prevStep"
                    >
                        Back
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="nextStep"
                    >
                        Next
                    </button>
                </div>
            </div>

            <div v-if="currentStep === 3">
                <h3 class="mb-3">Step 3: Set Date & Time</h3>
                <div class="form-group mb-3">
                    <label for="dateTime">Date & Time</label>
                    <input
                        id="dateTime"
                        type="datetime-local"
                        v-model="product.date_and_time"
                        class="form-control"
                        required
                    />
                </div>
                <div class="d-flex justify-content-between">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="prevStep"
                    >
                        Back
                    </button>
                    <button type="submit" class="btn btn-success">
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            product: {
                name: "",
                category: "",
                description: "",
                date_and_time: "",
            },
            images: [],
            currentStep: 1,
            categories: ["Category 1", "Category 2", "Category 3"],
        };
    },
    mounted() {
        this.fetchProduct();
    },
    methods: {
        fetchProduct() {
            const id = this.$route.params.id;
            axios.get(`/products/${id}`).then((response) => {
                this.product = response.data;
                console.log(this.product);
            });
        },
        handleFileUpload(event) {
            this.images = Array.from(event.target.files);
        },
        nextStep() {
            if (this.currentStep === 1) {
                if (!this.product.name || !this.product.category || !this.product.description) {
                    alert("Please fill out all fields.");
                    return;
                }
            } else if (this.currentStep === 2) {
                if (this.images.length === 0) {
                    alert("Please upload at least one image.");
                    return;
                }
            }
            if (this.currentStep < 3) {
                this.currentStep++;
            } else {
                this.updateProduct();
            }
        },
        prevStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
            }
        },
        updateProduct() {
            const id = this.$route.params.id;
            const formData = new FormData();
            formData.append("name", this.product.name);
            formData.append("category", this.product.category);
            formData.append("description", this.product.description);

            this.images.forEach((image) => {
                formData.append("images[]", image);
            });

            formData.append("date_and_time", this.product.date_and_time);
            formData.append("_method", "PUT");

            axios
                .post(`/products/${id}`, formData)
                .then(() => {
                    this.$router.push({ name: "products" });
                })
                .catch((error) => {
                    console.error("Error updating product:", error);
                });
        },
    },
};
</script>

<style scoped>
.card {
    max-width: 600px;
    margin: 0 auto;
}
</style>
