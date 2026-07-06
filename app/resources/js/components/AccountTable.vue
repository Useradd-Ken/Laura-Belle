<template>
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="border-b border-slate-200 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
          <th class="px-3 py-3">Code</th>
          <th class="px-3 py-3">Name</th>
          <th class="px-3 py-3">Type</th>
          <th class="px-3 py-3">Parent</th>
          <th class="px-3 py-3">Status</th>
          <th class="px-3 py-3">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="account in accounts" :key="account.id" class="border-b border-slate-100 transition hover:bg-slate-50">
          <td class="px-3 py-3 font-medium text-slate-700">{{ account.account_number }}</td>
          <td class="px-3 py-3">
            <button type="button" class="font-medium text-slate-800 transition hover:text-slate-900" @click="$emit('select', account)">{{ account.account_name }}</button>
          </td>
          <td class="px-3 py-3">
            <span class="rounded-full px-2.5 py-1 text-xs font-semibold" :class="typeClasses(account.account_type)">{{ account.account_type }}</span>
          </td>
          <td class="px-3 py-3 text-slate-600">{{ getParentName(account.parent_id) || '—' }}</td>
          <td class="px-3 py-3">
            <span class="rounded-full px-2.5 py-1 text-xs font-semibold" :class="account.is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600'">
              {{ account.is_active ? 'Active' : 'Inactive' }}
            </span>
          </td>
          <td class="px-3 py-3">
            <div class="flex flex-wrap gap-2">
              <button type="button" class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-100" @click="$emit('view', account)">View</button>
              <button type="button" class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-100" @click="$emit('edit', account)">Edit</button>
              <button type="button" class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-100" @click="$emit('add-child', account)">Child</button>
              <button type="button" class="rounded-lg border border-rose-200 px-2.5 py-1.5 text-xs font-medium text-rose-600 transition hover:bg-rose-50" @click="$emit('delete', account)">Delete</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'AccountTable',
  props: {
    accounts: Array,
    selectedAccountId: Number
  },
  emits: ['select', 'view', 'edit', 'add-child', 'delete'],
  methods: {
    getParentName(parentId) {
      const parent = this.accounts.find((account) => account.id === parentId);
      return parent ? parent.account_name : '';
    },
    typeClasses(type) {
      const map = {
        Asset: 'bg-emerald-50 text-emerald-700',
        Liability: 'bg-rose-50 text-rose-700',
        Equity: 'bg-violet-50 text-violet-700',
        Revenue: 'bg-sky-50 text-sky-700',
        Expense: 'bg-amber-50 text-amber-700'
      };
      return map[type] || 'bg-slate-100 text-slate-700';
    }
  }
};
</script>
