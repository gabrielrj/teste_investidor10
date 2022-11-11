<template>
  <div class="card text-center">
    <div class="card-header">
      <h5 class="card-title">Painel inicial</h5>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-sm-4" v-for="(news, news_i) in listAllNews" :key="news_i">
          <CardNew v-bind:p-news="news"></CardNew>
        </div>

      </div>

    </div>
    <div class="card-footer text-muted">
      <div class="row">
        <div class="col">
          <div style="display: inline-block;" class="d-flex justify-content-center">
            <pagination :totalPage="pagination.totalPages"
                        v-model="pagination.currentPage"
                        nextText="Próximo"
                        prevText="Anterior"
                        :withNextPrev="true"
                        :customActiveBGColor="'#000099'"
                        @btnClick="changePage"></pagination>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import newsManager from "@/services/newsManager";
import CardNew from "@/components/news/CardNew";
import Pagination from "@/components/default/Pagination";

export default {
  name: "Dashboard",
  components: {CardNew, Pagination},
  data() {
    return {
      result: [],

      searchingNews: false,

      pagination: {
        regsByPage: 6,
        totalPages: 1,
        totalRegs: 0,
        currentPage: 1,
      }
    }
  },
  computed: {
    listAllNews() {
      if(this.result.length === 0)
        return []

      return this.result.news
    }
  },
  methods: {
    changePage(page) {
      this.pagination.currentPage = page
      this.getAllNews()
    },

    async getAllNews() {
      try {
        this.searchingNews = true

        this.result = await newsManager.getAllNews(null,
            null,
            this.pagination.regsByPage,
            this.pagination.currentPage)

        this.pagination.totalPages = this.result.totalPages
        this.pagination.currentPage = this.result.currentPage
        this.pagination.totalRegs = this.result.totalRegs
      } catch (e) {
        console.log(e)
      } finally {
        this.searchingNews = false
      }
    },
  },
  mounted() {
    this.getAllNews()
  }
}
</script>

<style scoped>

</style>
