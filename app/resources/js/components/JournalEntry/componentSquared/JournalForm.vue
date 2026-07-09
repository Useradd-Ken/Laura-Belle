<template>
  <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    <div class="mb-6">
      <h3 class="text-lg font-semibold text-gray-900">
        Journal Information
      </h3>

      <p class="mt-1 text-sm text-gray-500">
        Enter the basic information for this journal entry.
      </p>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

      <!-- Reference Number -->
      <div>
        <label
          class="mb-2 block text-sm font-medium text-gray-700"
        >
          Reference Number
        </label>

        <input
          :value="reference_no"
          @input="$emit('update:reference_no', $event.target.value)"
          type="text"
          placeholder="JE-000001"
          class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
        />
      </div>

      <!-- Entry Date -->
      <div>
        <label
          class="mb-2 block text-sm font-medium text-gray-700"
        >
          Entry Date
        </label>

        <input
          :value="entry_date"
          @input="$emit('update:entry_date', $event.target.value)"
          type="date"
          class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
        />
      </div>

    </div>

    <!-- Description -->
    <div class="mt-6">
      <label
        class="mb-2 block text-sm font-medium text-gray-700"
      >
        Description
      </label>

      <textarea
        :value="description"
        @input="$emit('update:description', $event.target.value)"
        rows="3"
        placeholder="Enter journal description..."
        class="w-full resize-none rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
      ></textarea>
    </div>
  </div>
</template>

<script setup>
defineProps({
  reference_no: {
    type: String,
    default: "",
  },

  entry_date: {
    type: String,
    default: "",
  },

  description: {
    type: String,
    default: "",
  },
});

defineEmits([
  "update:reference_no",
  "update:entry_date",
  "update:description",
]);
</script>