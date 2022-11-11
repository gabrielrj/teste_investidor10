import ajaxCall from "@/services/ajaxCall";

export default {
      async getAllCategories() {
            // eslint-disable-next-line no-useless-catch
            try {
                  let result = null

                  await ajaxCall.callApi('/news/categories/all', null, true, 'GET')
                  .then(response => {
                        result = response.data.data.categories
                  })

                  return result
            }catch (e) {
                  throw e;
            }
      },

      async getAllNews(categoryId = null, newsTitle = null, regsByPage = 5, page = 1) {
            // eslint-disable-next-line no-useless-catch
            try {
                  newsTitle = newsTitle !== '' ? newsTitle : null;

                  let result = null

                  await ajaxCall.callApi(`/news/all/${categoryId}/${newsTitle}/${regsByPage}/${page}`, null, true, 'GET')
                  .then(response => {
                        result = response.data.data.result
                  })

                  return result
            }catch (e) {
                  throw e;
            }
      },

      async findNewsByCode(code) {
            // eslint-disable-next-line no-useless-catch
            try {
                  let result = null

                  await ajaxCall.callApi('/news/show/' + code, null, true, 'GET')
                  .then(response => {
                        result = response.data.data.news
                  })

                  return result
            }catch (e) {
                  throw e;
            }
      },

      async createNews(payload) {
            // eslint-disable-next-line no-useless-catch
            try {
                  return await ajaxCall.callApi('/news/store', payload, true, 'POST')
            }catch (e) {
                  throw e;
            }
      },

      async updateNews(payload, code) {
            // eslint-disable-next-line no-useless-catch
            try {
                  return await ajaxCall.callApi(`/news/update/${code}`, payload, true, 'PUT')
            }catch (e) {
                  throw e;
            }
      },

      async deleteNews(id) {
            // eslint-disable-next-line no-useless-catch
            try {
                  return await ajaxCall.callApi(`/news/delete/${id}`, null, true, 'DELETE')
            }catch (e) {
                  throw e;
            }
      }
}
