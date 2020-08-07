<template>
  <section class="section">
    <h1 class="title is-4">cat #{{ slug }}</h1>
  </section>
</template>

<script>
export default {
  data() {
    return {
      slug: this.$route.params.slug,
    }
  },
}
</script>
