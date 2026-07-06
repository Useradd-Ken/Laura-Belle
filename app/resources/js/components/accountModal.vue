<template>
  <div v-if="visible" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm">
    <div class="absolute right-0 top-0 flex h-full w-full max-w-xl flex-col border-l border-slate-200 bg-white shadow-2xl">
      <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
        <div>
          <p class="text-sm font-medium text-slate-500">{{ mode === 'edit' ? 'Edit Account' : 'New Account' }}</p>
          <h3 class="text-lg font-semibold text-slate-900">{{ mode === 'edit' ? 'Update account details' : 'Create a new chart account' }}</h3>
        </div>
        <button type="button" class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700" @click="$emit('close')">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5">
            <path d="M6 6l12 12M18 6 6 18" stroke-linecap="round" />
          </svg>
        </button>
      </div>

      <form class="flex-1 overflow-y-auto px-6 py-6" @submit.prevent="$emit('submit')">
        <div class="grid grid-cols-1 gap-4">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Account Number</label>
            <input :value="form.account_number" @input="$emit('update-form', { ...form, account_number: $event.target.value })" required class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none ring-0 focus:border-slate-400" />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Account Name</label>
            <input :value="form.account_name" @input="$emit('update-form', { ...form, account_name: $event.target.value })" required class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none ring-0 focus:border-slate-400" />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Account Type</label>
            <select :value="form.account_type" @change="$emit('update-form', { ...form, account_type: $event.target.value })" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-slate-400">
              <option v-for="type in accountTypes" :key="type" :value="type">{{ type }}</option>
            </select>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Parent Account</label>
            <select :value="form.parent_id" @change="$emit('update-form', { ...form, parent_id: $event.target.value })" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-slate-400">
              <option value="">No parent</option>
              <option v-for="account in accounts" :key="account.id" :value="account.id">{{ account.account_name }}</option>
            </select>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Description</label>
            <textarea :value="form.description" @input="$emit('update-form', { ...form, description: $event.target.value })" rows="4" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-slate-400"></textarea>
          </div>

          <label class="flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-3 text-sm text-slate-700">
            <input :checked="form.is_active" @change="$emit('update-form', { ...form, is_active: $event.target.checked })" type="checkbox" class="rounded border-slate-300" />
            Active account
          </label>
        </div>

        <div class="mt-8 flex items-center justify-end gap-3 border-t border-slate-200 pt-4">
          <button type="button" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100" @click="$emit('close')">Cancel</button>
          <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">{{ mode === 'edit' ? 'Save Changes' : 'Create Account' }}</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AccountModal',
  props: {
    visible: Boolean,
    mode: String,
    form: Object,
    accounts: Array,
    accountTypes: Array
  },
  emits: ['close', 'submit', 'update-form']
};
</script>
