<template>
  <div
    class="bg-white rounded-xl border border-gray-200 p-4 flex flex-wrap gap-4 items-center justify-between mb-6"
  >
    <input
      :value="search"
      @input="$emit('update:search', $event.target.value)"
      type="text"
      placeholder="Search reference or description..."
      class="w-72 rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none"
    />

    <div class="flex gap-3">
      <select
        :value="status"
        @change="$emit('update:status', $event.target.value)"
        class="rounded-lg border border-gray-300 px-4 py-2"
      >
        <option value="">All Status</option>
        <option>Draft</option>
        <option>Posted</option>
        <option>Voided</option>
      </select>

      <input
        type="date"
        :value="from"
        @input="$emit('update:from', $event.target.value)"
        class="rounded-lg border border-gray-300 px-4 py-2"
      />

      <input
        type="date"
        :value="to"
        @input="$emit('update:to', $event.target.value)"
        class="rounded-lg border border-gray-300 px-4 py-2"
      />
    </div>
  </div>
</template>

<script setup>
defineProps({
  search: String,
  status: String,
  from: String,
  to: String,
});

defineEmits([
  "update:search",
  "update:status",
  "update:from",
  "update:to",
]);
</script>