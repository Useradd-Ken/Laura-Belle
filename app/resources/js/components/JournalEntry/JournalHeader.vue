<template>
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-3xl font-bold text-gray-900">
        Journal Entries
      </h1>

      <p class="mt-1 text-sm text-gray-500">
        Record, review, post, and void journal entries.
      </p>
    </div>

    <button
      @click="$emit('create')"
      class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-white font-medium shadow hover:bg-indigo-700 transition"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M12 4v16m8-8H4"
        />
      </svg>

      New Entry
    </button>
  </div>
</template>

<script setup>
defineEmits(["create"]);
</script>