<template>
  <div>
    <h1 class="text-xl font-bold text-gray-800">Favorites</h1>
    <hr class="my-4">

    <div v-if="this.favorites.length">
      <div class="rounded-md shadow-md overflow-hidden">
        <div class="p-6">
          <h2 class="text-xl font-bold text-gray-800">The sum of nutritions facts</h2>
          <ul>
            <li v-for="(val, key) in this.facts">{{ key }}: {{ val.toFixed(2) }}</li>
          </ul>
        </div>
      </div>

      <hr class="my-4">

      <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <FruitItem @removeFavorite="removeFavorite" v-for="fruit in this.favorites" :data="fruit"/>
      </div>
    </div>

  </div>
</template>

<script>

import axios from 'axios';
import FruitItem from "@/components/FruitItem";

export default {
  name: 'Favorites',
  components: {
    FruitItem
  },
  data() {
    return {
      favorites: [],
      facts: {}
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    async init() {
      await this.getFavorites()
    },
    async getFavorites() {
      try {
        const response = await axios.get('/api/fruits/all/favorites');
        this.favorites = response.data['hydra:member'];
        this.getFacts();
      } catch (error) {
        alert('APP Error!');
      }
    },
    async removeFavorite(id) {
      try {
        const response = await axios.delete(`/api/fruits/${id}/favorites`);
        if (response.status === 204) {
          const index = this.favorites.findIndex(item => item.id === id);
          if (index !== -1) {
            this.favorites.splice(index, 1);
            this.getFacts();
          }
        }
      } catch (error) {
        alert('APP Error!');
      }
    },
    getFacts() {
      this.facts = {
        calories: 0,
        fat: 0,
        sugar: 0,
        carbohydrates: 0,
        protein: 0
      }

      this.favorites.forEach(fruit => {
        for (const key in this.facts) {
          if (fruit.nutrition.hasOwnProperty(key)) {
            this.facts[key] += fruit.nutrition[key];
          }
        }
      });
    }
  }
}
</script>
