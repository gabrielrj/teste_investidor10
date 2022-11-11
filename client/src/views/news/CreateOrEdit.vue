<template>
  <div class="h-100 container">
    <div class="row mt-5">
      <div class="col">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <router-link to="dashboard">Dashboard</router-link>
            </li>
            <li class="breadcrumb-item" aria-current="page">Notícias</li>
            <li class="breadcrumb-item active" aria-current="page">
              {{ form.code == null ? 'Novo notícia' : 'Edição de notícia' }}
            </li>
          </ol>
        </nav>
      </div>
    </div>

    <ErrorAlerts ref="errorAlerts"></ErrorAlerts>

    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              {{ form.code == null ? 'Cadastre uma nova notícia' : `Alteração da notícia ${form.name}` }}</h5>

            <div class="row">
              <div class="col">
                <form @submit.prevent.stop="saveNews" novalidate>
                  <div class="row mb-3">
                    <div class="col">
                      <label for="category" class="form-label">Categoria</label>
                      <select class="form-select" id="category"
                              v-model.number="form.categories_id">
                        <option value="0" disabled>Selecione uma categoria</option>
                        <option v-for="(category, category_i) in form.categories"
                                :key="category_i"
                                :value="category.id">{{ category.name }}
                        </option>
                      </select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col">
                      <label for="title" class="form-label">Título</label>
                      <input type="text" class="form-control" id="title" placeholder="Título da notícia..." v-model="form.title"
                             maxlength="128">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col">
                      <label for="body" class="form-label">Corpo</label>
                      <textarea class="form-control" id="body" placeholder="Corpo da notícia..." v-model="form.body"
                                style="min-height: 250px;"
                                maxlength="1024"></textarea>
                    </div>
                  </div>

                  <div class="mb-3">
                    <button type="submit" :class="{'disabled' : form.sending}" class="btn btn-primary">Salvar</button>
                    &nbsp;
                    <button type="button" :class="{'disabled' : form.sending}" class="btn btn-danger"
                            @click="cancelOperation">Cancelar
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import newsManager from "@/services/newsManager";
import Swal from "sweetalert2";
import router from "@/router";
import ErrorAlerts from "@/components/default/ErrorAlerts";

export default {
  name: "CreateOrEdit",
  components: {ErrorAlerts},
  data() {
    return {
      form: {
        categories: [],

        code: null,
        title: null,
        body: null,
        categories_id: 0,

        sending: false,
      },
    }
  },
  methods: {
    cancelOperation() {
      router.back()
    },

    async findNewsForUpdate(code) {
      const news = await newsManager.findNewsByCode(code)

      this.form.code = news.code
      this.form.title = news.title
      this.form.body = news.body
      this.form.categories_id = news.categories_id
    },

    async getCategoriesToSelect() {
      this.form.categories = await newsManager.getAllCategories()
    },

    async saveNews() {
      this.form.sending = true
      const payload = {
        title: this.form.title,
        body: this.form.body,
        categories_id: this.form.categories_id,
      }

      if (!this.form.code) {
        await newsManager.createNews(payload)
            .then(() => {
              router.push({name: 'News', params: {msg: 'Notícia cadastrada com sucesso.'}})
            })
            .catch(error => {
              // eslint-disable-next-line no-prototype-builtins
              if (error.response.data.hasOwnProperty('validation_errors')) {
                this.$refs.errorAlerts.showMessages(error.response.data.validation_errors)
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops! Ocorreu um erro.',
                  text: error.response.message,
                  footer: '<b>' + error.response.exception + '</b>'
                })
              }
            }).finally(() => {
              this.form.sending = false
            })
      } else {
        await newsManager.updateNews(payload, this.form.code)
            .then(() => {
              router.push({name: 'News', params: {msg: 'Notícia alterada com sucesso.'}})
            })
            .catch(error => {
              // eslint-disable-next-line no-prototype-builtins
              if (error.response.data.hasOwnProperty('validation_errors')) {
                this.$refs.errorAlerts.showMessages(error.response.data.validation_errors)
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops! Ocorreu um erro.',
                  text: error.response.message,
                  footer: '<b>' + error.response.exception + '</b>'
                })
              }
            }).finally(() => {
              this.form.sending = false
            })
      }
    }
  },

  mounted() {
    this.getCategoriesToSelect()

    // eslint-disable-next-line no-prototype-builtins
    if (this.$route.params.hasOwnProperty('newsEditId'))
      this.findNewsForUpdate(this.$route.params.newsEditId)
  }
}
</script>

<style scoped>

</style>
