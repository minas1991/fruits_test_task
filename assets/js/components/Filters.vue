<template>
  <div class="flex items-center gap-4 p-4">
    <div class="w-full md:w-1/2">
      <label class="block text-gray-700 font-bold mb-2" for="filter">Search By Name:</label>
      <input class="appearance-none border border-gray-400 rounded-md py-2 px-4 leading-tight focus:outline-none focus:shadow-outline w-full"
             type="text" placeholder="Type your filter..." v-model="name" @input="filter()" />
    </div>
    <div class="w-full md:w-1/2" v-if="families">
      <label class="block text-gray-700 font-bold mb-2" for="category">Filter By Family:</label>
      <div class="relative">
        <select class="block appearance-none w-full border border-gray-400 rounded-md py-2 px-4 pr-8 leading-tight focus:outline-none focus:shadow-outline"
                v-model="family" @change="filter()">
          <option value="">-- Please select --</option>
          <option v-for="f in families" :value="f">{{ f }}</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.95 6.95l-3.95 3.95-3.95-3.95-1.414 1.414 3.95 3.95-3.95 3.95 1.414 1.414 3.95-3.95 3.95 3.95 1.414-1.414-3.95-3.95 3.95-3.95-1.414-1.414z"/></svg>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Filters',
  props: {
    name: {
      default: ''
    },
    family: {
      default: ''
    },
    families: {
      default: []
    }
  },
  methods: {
    filter(event) {
      this.$router.push({name: 'Fruits', query: { name: this.name, family: this.family}});
    }
  },
};
</script>