<template>
  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">{{ news ? news.title : null }}</h5>
      <h6 class="card-subtitle mb-2 text-muted">{{ news ? news.category : null }}</h6>
      <p class="card-text">{{
          news ? textTruncate(news.body, 250) : null
        }}</p>
      <router-link :to="{ name: 'NewsEdit', params: { newsEditId: news.code }}" class="card-link">Acessar</router-link>
    </div>
  </div>
</template>

<script>

import lodash from 'lodash';

export default {
  name: "CardNew",
  props: {
    pNews: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      news: this.pNews
    }
  },
  watch: {
    pNews(newValue) {
      this.news = newValue
    }
  },
  methods: {
    textTruncate(text, maxCaracteres = 10){
      // eslint-disable-next-line no-undef
      return lodash.truncate(text, {
        'omission': ' [...]',
        'length': maxCaracteres,
      })
    },
  },
}
</script>

<style scoped>

</style>