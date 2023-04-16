<template>
  <div>
    <h1 class="text-xl font-bold text-gray-800">Fruits</h1>
    <hr class="my-4">

    <div>
      <Filters :name="this.filters.name" :family="this.filters.family" :families="families"/>
      <hr class="my-4">
    </div>

    <div>
      <Pagination :totalItems="this.totalItems" :currentPage="this.currentPage"/>
      <hr class="my-4">
    </div>

    <div v-if="this.fruits" class="grid grid-cols-1 md:grid-cols-3 gap-3">
      <FruitItem @favorite="favorite" @removeFavorite="removeFavorite" v-for="fruit in this.fruits" :data="fruit"/>
    </div>

  </div>
</template>

<script>

import axios from 'axios';
import FruitItem from "@/components/FruitItem";
import Pagination from "@/components/Pagination";
import Filters from "@/components/Filters";

export default {
  name: 'Fruits',
  components: {
    Filters,
    FruitItem,
    Pagination
  },
  data() {
    return {
      currentPage: 1,
      totalItems: 0,
      filters: {
        name: '',
        family: ''
      },
      fruits: [],
      families: [],
    }
  },
  watch: {
    $route(to, from) {
      this.init();
    },
  },
  mounted() {
    this.init();
  },
  methods: {
    async init() {
      await this.getFruits();
      await this.getFamilies();
    },
    async getFruits() {
      try {
        const response = await axios.get(this.getURL());
        this.fruits = response.data['hydra:member'];
        this.totalItems = response.data['hydra:totalItems'];
      } catch (error) {
        alert('APP Error!');
      }
    },
    async getFamilies() {
      try {
        const response = await axios.get('/api/families');
        this.families = response.data;
      } catch (error) {
        //
      }
    },
    async favorite(id) {
      try {
        const response = await axios.post(`/api/fruits/${id}/favorites`);
        if (response.status === 201) {
          const i = this.fruits.findIndex(o => o.id === id);
          if (i !== -1) {
            this.fruits[i].isFavorite = true;
          }
        }
      } catch (error) {
        alert('APP Error!');
      }
    },
    async removeFavorite(id) {
      try {
        const response = await axios.delete(`/api/fruits/${id}/favorites`);
        if (response.status === 204) {
          const i = this.fruits.findIndex(o => o.id === id);
          if (i !== -1) {
            this.fruits[i].isFavorite = false;
          }
        }
      } catch (error) {
        alert('APP Error!');
      }
    },
    getURL() {
      const page = parseInt(this.$route.query.page);
      this.currentPage = Number.isInteger(page) ? page : 1;
      let apiUrl = `/api/fruits?page=${this.currentPage}`;
      this.filters = {
        name: '',
        family: ''
      }
      for (const key in this.filters) {
        if (this.$route.query[key]?.trim()) {
          this.filters[key] = this.$route.query[key];
          apiUrl += `&${key}=${this.filters[key]}`;
        }
      }

      return apiUrl;
    }
  }
}
</script>
