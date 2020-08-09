<template>
  <section class="section">
    <h1 class="title is-4">cat #{{ slug }}</h1>
  </section>
</template>

<script>
export default {
  async asyncData({ payload, store }) {
    if (payload) {
      store.commit('categories/setRoots', payload.roots)
      return { roots: payload.roots }
    } else {
      await store.dispatch('categories/fetchRoots')
    }
  },

  data() {
    return {
      slug: this.$route.params.slug,
    }
  },
}
</script>
