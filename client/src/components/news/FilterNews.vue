<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title">Filtro</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="category" class="form-label">Categoria</label>
                        <select class="form-select" id="category"
                                v-model.number="categorySelected">
                            <option value="0">Todos</option>
                            <option v-for="(category, category_i) in categories"
                                    :key="category_i"
                                    :value="category.id">{{ category.name }}</option>
                        </select>
                    </div>

                    <div class="col">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="title" placeholder="Título da notícia..."
                               v-model="titleSelected"
                               maxlength="128">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <button type="button" class="btn btn-primary" @click="searchNews">Buscar</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
import newsManager from "@/services/newsManager";

export default {
    name: "FilterNews",
    props: {
        pCategorySelected: {
            type: Number,
            default: 0,
        },

        pFileTypeSelected: {
            type: String,
            default: '0',
        },

        pTitleSelected: {
            type: String,
            default: null,
        },
    },
    data() {
        return {
            categories: [],

            categorySelected: this.pCategorySelected,
            titleSelected: this.pTitleSelected,
        }
    },
    watch: {
        pCategorySelected(newValue) {
            this.categorySelected = newValue
        },

        categorySelected(newValue){
            this.$emit('update:pCategorySelected', newValue)
        },

        pTitleSelected(newValue) {
            this.titleSelected = newValue
        },

        titleSelected(newValue){
            this.$emit('update:pTitleSelected', newValue)
        },
    },
    methods: {
        async getCategoriesToSelect(){
            this.categories = await newsManager.getAllCategories()
        },

        searchNews() {
            this.$emit('searchNews')
        }

    },
    mounted() {
        this.getCategoriesToSelect()
    }
}
</script>

<style scoped>

</style>
