<template>
  <div class="bg-white shadow p-4 flex mb-4">
    <span class="w-auto flex justify-end items-center text-gray-500 p-2">
      <i class="material-icons text-3xl">search</i>
    </span>
    <input
      class="w-full rounded p-2 focus:outline-none focus:text-gray-500"
      type="text"
      placeholder="Try 'Author Name'"
      v-model="searchQuery"
      @keyup="handleSearch"
    />
    <button
      class="
        bg-gray-500
        hover:bg-gray-300
        rounded
        hover:text-black
        text-white
        p-2
        px-4
      "
      @click="handleSearch"
    >
      <p class="font-semibold text-xs">Search</p>
    </button>
  </div>
</template>

<script>
import { bus } from "../app";
export default {
  data() {
    return {
      searchQuery: "",
    };
  },
  methods: {
    handleSearch() {
      bus.$emit("tableSearch", this.searchQuery);
    },
  },
};
</script>