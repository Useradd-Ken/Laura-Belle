<template>
  <div v-if="visible" class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/50 px-4 backdrop-blur-sm">
    <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl">
      <p class="text-sm font-medium text-slate-500">Delete account</p>
      <h3 class="mt-2 text-xl font-semibold text-slate-900">Remove {{ itemName }}?</h3>
      <p class="mt-2 text-sm leading-6 text-slate-600">
        This action removes the account from the current workspace view. The backend delete endpoint is not available in this build, so this is a UI-only confirmation.
      </p>

      <div class="mt-6 flex justify-end gap-3">
        <button type="button" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100" @click="$emit('cancel')">Cancel</button>
        <button type="button" class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700" @click="$emit('confirm')">Delete</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DeleteModal',
  props: {
    visible: Boolean,
    itemName: String
  },
  emits: ['cancel', 'confirm']
};
</script>
