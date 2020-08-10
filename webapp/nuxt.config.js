import { stringify } from 'querystring'
import axios from 'axios'

export default {
  /*
   ** Nuxt rendering mode
   ** See https://nuxtjs.org/api/configuration-mode
   */
  mode: 'universal',
  /*
   ** Nuxt target
   ** See https://nuxtjs.org/api/configuration-target
   */
  target: 'static',
  /*
   ** Headers of the page
   ** See https://nuxtjs.org/api/configuration-head
   */
  head: {
    title: process.env.npm_package_name || '',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      {
        hid: 'description',
        name: 'description',
        content: process.env.npm_package_description || '',
      },
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', type: 'text/css', href: '/bulma.min.css' },
    ],
  },
  /*
   ** Global CSS
   */
  css: [],
  /*
   ** Plugins to load before mounting the App
   ** https://nuxtjs.org/guide/plugins
   */
  plugins: [],
  /*
   ** Auto import components
   ** See https://nuxtjs.org/api/configuration-components
   */
  components: true,
  /*
   ** Nuxt.js dev-modules
   */
  buildModules: [
    // Doc: https://github.com/nuxt-community/eslint-module
    '@nuxtjs/eslint-module',
  ],
  /*
   ** Nuxt.js modules
   */
  modules: [],
  /*
   ** Build configuration
   ** See https://nuxtjs.org/api/configuration-build/
   */
  build: {},

  loading: false,

  router: {
    base: '/',
    trailingSlash: true,
  },

  generate: {
    dir: '../public-webapp',
    crawler: false,
    async routes() {
      const apiBase = 'http://localhost:8081/api'

      // all categories
      let allCats = []
      const qq = stringify({
        fields: 'id,name,slug,description,keywords,parent_id',
      })
      await axios
        .get(`${apiBase}/categories?${qq}`)
        .then(({ data, status }) => {
          if (status === 200) {
            allCats = data.categories
          }
        })

      // root categories for navbar
      const roots = allCats.filter((el) => el.parent_id === null)

      const result = []

      // Categories pages
      const a = allCats.map((c) => {
        const children = allCats.filter((el) => el.parent_id === c.id)
        return {
          route: `/categories/${c.slug}/`,
          payload: { roots, category: c, children },
        }
      })
      result.push(...a)

      // ADs

      // Articles

      return result
    },
  },
}
