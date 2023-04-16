<template>
  <nav class="flex items-center" aria-label="Pagination">
    <ul class="flex">
      <li v-for="page in pagesCount" @click="changePage(page)"
          :class="{'bg-gray-400': page == currentPage, 'text-white': page == currentPage}"
          class="cursor-pointer block border border-gray-400 rounded-full py-2 px-4 mr-2 text-gray-700 hover:text-white hover:bg-gray-400">{{ page }}</li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: 'Pagination',
  props: {
    perPage: {
      default: 10
    },
    totalItems: {
      default: 0
    },
    currentPage: {
      default: 1
    }
  },
  computed: {
    pagesCount() {
      return Math.ceil(this.totalItems / this.perPage);
    },
  },
  methods: {
    changePage(page) {
      if (page == this.currentPage) {
        return false;
      }

      const query = { ...this.$route.query, page: page };
      this.$router.replace({ query: query });

    }
  }
}
</script>