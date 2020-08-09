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
import { mapState } from 'vuex'

export default {
  name: 'AppNavbar',

  computed: {
    ...mapState({
      roots: (state) => state.categories.roots,
    }),
  },
}
</script>
