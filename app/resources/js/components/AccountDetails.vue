<template>
  <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="flex items-start justify-between gap-4">
      <div>
        <p class="text-sm font-medium text-slate-500">Account Details</p>
        <h2 class="mt-1 text-xl font-semibold text-slate-900">{{ selectedAccount?.account_name || 'No account selected' }}</h2>
      </div>
      <span v-if="selectedAccount" class="rounded-full px-2.5 py-1 text-xs font-semibold" :class="typeClasses(selectedAccount.account_type)">
        {{ selectedAccount.account_type }}
      </span>
    </div>

    <div v-if="selectedAccount" class="mt-6 space-y-4">
      <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
          <p class="text-xs uppercase tracking-wide text-slate-500">Code</p>
          <p class="mt-1 font-semibold text-slate-800">{{ selectedAccount.account_number }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
          <p class="text-xs uppercase tracking-wide text-slate-500">Status</p>
          <p class="mt-1 font-semibold" :class="selectedAccount.is_active ? 'text-emerald-600' : 'text-slate-600'">
            {{ selectedAccount.is_active ? 'Active' : 'Inactive' }}
          </p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
          <p class="text-xs uppercase tracking-wide text-slate-500">Parent</p>
          <p class="mt-1 font-semibold text-slate-800">{{ selectedAccount.parent_id || '—' }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
          <p class="text-xs uppercase tracking-wide text-slate-500">Normal Balance</p>
          <p class="mt-1 font-semibold text-slate-800">{{ normalBalance(selectedAccount.account_type) }}</p>
        </div>
      </div>

      <div class="rounded-xl border border-slate-200 p-4">
        <p class="text-sm font-semibold text-slate-800">Description</p>
        <p class="mt-2 text-sm leading-6 text-slate-600">{{ selectedAccount.description || 'No description added yet.' }}</p>
      </div>

      <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div class="rounded-xl border border-slate-200 p-3 text-sm text-slate-600">
          <p class="font-semibold text-slate-800">Created</p>
          <p class="mt-1">{{ formatDate(selectedAccount.created_at) }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 p-3 text-sm text-slate-600">
          <p class="font-semibold text-slate-800">Updated</p>
          <p class="mt-1">{{ formatDate(selectedAccount.updated_at) }}</p>
        </div>
      </div>

      <div class="flex flex-wrap gap-2 pt-2">
        <button type="button" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100" @click="$emit('edit', selectedAccount)">Edit</button>
        <button type="button" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100" @click="$emit('add-child', selectedAccount)">Add Child</button>
        <button type="button" class="rounded-xl border border-rose-200 px-3 py-2 text-sm font-medium text-rose-600 transition hover:bg-rose-50" @click="$emit('delete', selectedAccount)">Delete</button>
        <button type="button" class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-medium text-white transition hover:bg-slate-800" @click="$emit('view-ledger', selectedAccount)">View Ledger</button>
      </div>
    </div>

    <div v-else class="mt-6 rounded-xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
      Select an account from the list to view its profile and activity.
    </div>
  </div>
</template>

<script>
export default {
  name: 'AccountDetails',
  props: {
    selectedAccount: Object
  },
  emits: ['edit', 'delete', 'add-child', 'view-ledger'],
  methods: {
    typeClasses(type) {
      const map = {
        Asset: 'bg-emerald-50 text-emerald-700',
        Liability: 'bg-rose-50 text-rose-700',
        Equity: 'bg-violet-50 text-violet-700',
        Revenue: 'bg-sky-50 text-sky-700',
        Expense: 'bg-amber-50 text-amber-700'
      };
      return map[type] || 'bg-slate-100 text-slate-700';
    },
    normalBalance(type) {
      return type === 'Asset' || type === 'Expense' ? 'Debit' : 'Credit';
    },
    formatDate(value) {
      if (!value) return '—';
      return new Date(value).toLocaleDateString();
    }
  }
};
</script>
