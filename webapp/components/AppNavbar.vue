<template>
  <nav class="navbar header has-shadow is-light">
    <div class="container">
      <div class="navbar-brand">
        <nuxt-link :to="{ name: 'index' }" class="navbar-item">
          <img src="~assets/logo.png" alt="Brand Logo" height="28" />
        </nuxt-link>
      </div>

      <div class="navbar-menu">
        <div class="navbar-start">
          <nuxt-link
            v-for="cat in roots"
            :key="cat.id"
            :to="{ name: 'categories-slug', params: { slug: cat.slug } }"
            class="navbar-item"
            exact-active-class="is-active"
          >
            {{ cat.name }}
          </nuxt-link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
// import axios from 'axios'
// import { mapState, mapActions } from 'vuex'

export default {
  name: 'AppNavbar',

  // serverCacheKey() {
  //   return 'AppNavbar'
  // },

  // async fetch() {
  //   if (this.roots.length === 0) {
  //     const res = await axios.get(
  //       'http://localhost:8081/api/categories?parent_id=0'
  //     )
  //     this.roots = res.data.categories
  //   }

  //   // if (this.rootsList.length === 0) {
  //   //   await this.categoriesFetchRoots()
  //   // }
  // },

  data: () => ({
    roots: [
      { id: 2550, name: 'Community', slug: 'community' },
      { id: 2549, name: 'For Sale', slug: 'for-sale' },
      { id: 2553, name: 'Jobs', slug: 'jobs' },
      { id: 2551, name: 'Motors', slug: 'cars-vans-motorbikes' },
      { id: 2526, name: 'Pets', slug: 'pets' },
      { id: 10201, name: 'Property', slug: 'flats-houses' },
      { id: 2554, name: 'Services', slug: 'business-services' },
    ],
  }),

  // computed: {
  //   ...mapState({
  //     rootsList: (state) => state.categories.roots,
  //   }),
  // },

  // methods: {
  //   ...mapActions('categories', { categoriesFetchRoots: 'fetchRoots' }),
  // },
}
</script>
