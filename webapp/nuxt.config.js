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
    concurrency: 1,
    async routes() {
      const apiBase = 'http://localhost:8081/api'
      const payload1 = {}

      // root categories for navbar
      const q = stringify({ parentId: 0, fields: 'id,name,slug' })
      await axios.get(`${apiBase}/categories?${q}`).then(({ data, status }) => {
        if (status === 200) {
          payload1.roots = data.categories
        }
      })

      const result = []

      // Categories
      const res1 = await axios.get(`${apiBase}/categories?fields=slug`)
      if (res1.status === 200) {
        const a = res1.data.categories.map((c) => ({
          route: `/categories/${c.slug}/`,
          payload: payload1,
        }))
        result.push(...a)
      }

      // ADs

      // Articles

      return result
    },
  },
}
