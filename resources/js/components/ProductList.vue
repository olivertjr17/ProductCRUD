<template>
    <div>
        <h1>Products</h1>
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>

        <div class="mb-3">
            <input
                type="text"
                v-model="searchQuery"
                placeholder="Search products..."
                class="form-control"
                @input="fetchProducts"
            />
            <select
                v-model="selectedCategory"
                @change="fetchProducts"
                class="form-control mt-2"
            >
                <option value="">All Categories</option>
                <option
                    v-for="category in categories"
                    :key="category"
                    :value="category"
                >
                    {{ category }}
                </option>
            </select>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Date and Time</th>
                    <th>Images</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products.data" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td>{{ product.category }}</td>
                    <td>{{ product.description }}</td>
                    <td>{{ product.date_and_time }}</td>
                    <td>
                        <div v-for="image in product.images" :key="image.id">
                            <a :href="getImageUrl(image.path)" target="_blank">
                                <img
                                    :src="getImageUrl(image.path)"
                                    alt="Product Image"
                                    class="img-thumbnail"
                                    style="max-width: 50px"
                                />
                            </a>
                        </div>
                    </td>
                    <td>
                        <router-link
                            :to="{ name: 'edit', params: { id: product.id } }"
                            class="btn btn-warning btn-sm"
                            >Edit</router-link
                        >
                        <button
                            @click="deleteProduct(product.id)"
                            class="btn btn-danger btn-sm"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination
            :data="products"
            @pagination-change-page="fetchProducts"
        ></pagination>
    </div>
</template>

<script>
import axios from "axios";
import Pagination from "./Pagination.vue";

export default {
    components: { Pagination },
    data() {
        return {
            products: { data: [], current_page: 1, last_page: 1 },
            successMessage: "",
            searchQuery: "",
            selectedCategory: "",
            categories: [],
        };
    },
    mounted() {
        console.log(this.products);
        this.fetchProducts();
    },
    methods: {
        fetchProducts(page = 1) {
            const params = {
                search: this.searchQuery,
                category: this.selectedCategory,
                page: page,
            };

            axios.get("/products", { params }).then((response) => {
                this.products = response.data.products || {};
                this.categories = response.data.categories || [];
                this.products.current_page = page;
                console.log(this.products);
            });
        },
        deleteProduct(id) {
            if (confirm("Are you sure?")) {
                axios.delete(`/products/${id}`).then((response) => {
                    this.successMessage = response.data.message;
                    this.fetchProducts(this.products.current_page);
                });
            }
        },
        getImageUrl(imagePath) {
            return `/storage/${imagePath}`;
        },
    },
};
</script>

<style scoped>
</style>
