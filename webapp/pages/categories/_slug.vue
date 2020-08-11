<template>
  <div class="columns">
    <aside class="column is-2">
      <ul>
        <li v-for="child in children" :key="child.slug">
          <nuxt-link
            :to="{ name: 'categories-slug', params: { slug: child.slug } }"
          >
            {{ child.name }}
          </nuxt-link>
        </li>
      </ul>
    </aside>

    <div class="column is-10">
      <section>
        <h1 class="title is-4">{{ category.name }}</h1>
        <p>{{ category.description }}</p>
      </section>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  async fetch() {
    if (!this.category || !this.category.id) {
      const cat1 = await this.fetchList({
        slug: this.slug,
        fields: 'id,name,slug,description,keywords,parent_id',
      })

      if (!cat1.length) {
        return this.$nuxt.error({ statusCode: 404, message: 'Not Found' })
      }

      this.category = cat1[0]

      this.children = await this.fetchList({
        parentId: this.category.id,
        fields: 'name,slug',
      })
    }
  },

  // payload comes from nuxt.config.js -> generate
  asyncData({ payload, store, params }) {
    if (payload && payload.roots) {
      store.commit('categories/setRoots', payload.roots)
    }

    return {
      category: payload ? payload.category : {},
      children: payload ? payload.children : [],
    }
  },

  data() {
    return {
      slug: this.$route.params.slug,
      category: {},
      children: [],
    }
  },

  methods: {
    ...mapActions('categories', ['fetchList']),
  },
}
</script>
