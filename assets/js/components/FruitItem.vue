<template>
  <div class="rounded-md shadow-md overflow-hidden">
    <div class="p-4">
      <h2 class="text-xl font-bold text-gray-800">{{ title }}</h2>
      <ul>
        <li v-for="(val, key) in values">{{ key }}: {{ val }}</li>
      </ul>
      <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
              v-if="!data.isFavorite" @click="favorite(id)">Add To Favorites</button>
      <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
              v-else @click="removeFavorite(id)">Remove From Favorites</button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FruitItem',
  props: {
    data: {
      default: {}
    }
  },
  computed: {
    id() {
      return this.data.id;
    },
    title() {
      return this.data.name;
    },
    values() {
      return {
        family: this.data.family,
        order: this.data.order,
        genus: this.data.genus,
        calories: this.data.nutrition?.calories,
        fat: this.data.nutrition?.fat,
        sugar: this.data.nutrition?.sugar,
        carbohydrates: this.data.nutrition?.carbohydrates,
        protein: this.data.nutrition?.protein,
      }
    }
  },
  methods: {
    favorite(id) {
      this.$emit('favorite', id);
    },
    removeFavorite(id) {
      this.$emit('removeFavorite', id);
    }
  }
}
</script>