<template>
    <div class="h-100 container">
        <div class="row mt-5">
            <div class="col">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><router-link to="dashboard">Dashboard</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">Notícias</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <FilterNews v-model:p-category-selected="categorySelected"
                             v-model:p-title-selected="titleSelected"
                             @searchNews="searchNews"></FilterNews>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <ListAllNews ref="listAllNews"></ListAllNews>
            </div>
        </div>

    </div>

</template>

<script>

import ListAllNews from "@/components/news/ListAllNews";
import FilterNews from "@/components/news/FilterNews";

export default {
    name: "Index",
    components: {FilterNews, ListAllNews},
    data() {
        return {
          categorySelected: 0,
          titleSelected: null,
        }
    },
    methods: {
        searchNews() {
            this.$refs.listAllNews.filter.categorySelected = this.categorySelected
            this.$refs.listAllNews.filter.titleSelected = this.titleSelected
            this.$refs.listAllNews.getAllNews()
        }
    },

}
</script>

<style scoped>

</style>
