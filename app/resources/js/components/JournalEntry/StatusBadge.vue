<template>
  <span
    class="rounded-full px-3 py-1 text-xs font-semibold"
    :class="badgeClass"
  >
    {{ status }}
  </span>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  status: String,
});

const badgeClass = computed(() => {
  switch (props.status) {
    case "Posted":
      return "bg-green-100 text-green-700";

    case "Voided":
      return "bg-red-100 text-red-700";

    default:
      return "bg-yellow-100 text-yellow-700";
  }
});
</script>