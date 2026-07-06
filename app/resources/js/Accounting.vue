<template>
  <div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">Chart of Accounts</h1>
        <p class="text-sm text-gray-500">Manage the base accounts used by the accounting system.</p>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
      <h2 class="text-lg font-semibold mb-4">Add Account</h2>
      <form @submit.prevent="saveAccount" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
          <input v-model="form.account_number" required class="w-full border rounded-lg px-3 py-2" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Account Name</label>
          <input v-model="form.account_name" required class="w-full border rounded-lg px-3 py-2" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Account Type</label>
          <select v-model="form.account_type" required class="w-full border rounded-lg px-3 py-2">
            <option value="Asset">Asset</option>
            <option value="Liability">Liability</option>
            <option value="Equity">Equity</option>
            <option value="Revenue">Revenue</option>
            <option value="Expense">Expense</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Parent Account ID (optional)</label>
          <input v-model="form.parent_id" type="number" class="w-full border rounded-lg px-3 py-2" />
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
          <textarea v-model="form.description" rows="2" class="w-full border rounded-lg px-3 py-2"></textarea>
        </div>
        <div class="md:col-span-2 flex items-center justify-between">
          <label class="flex items-center gap-2 text-sm text-gray-600">
            <input v-model="form.is_active" type="checkbox" class="rounded" />
            Active
          </label>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Save Account
          </button>
        </div>
      </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold">Accounts</h2>
      </div>
      <div v-if="loading" class="p-6 text-gray-500">Loading accounts...</div>
      <div v-else-if="accounts.length === 0" class="p-6 text-gray-500">No accounts found yet.</div>
      <div v-else class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Number</th>
              <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Name</th>
              <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Type</th>
              <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="account in accounts" :key="account.id" class="hover:bg-gray-50">
              <td class="px-4 py-3 text-sm text-gray-700">{{ account.account_number }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ account.account_name }}</td>
              <td class="px-4 py-3 text-sm text-gray-700">{{ account.account_type }}</td>
              <td class="px-4 py-3 text-sm">
                <span :class="account.is_active ? 'text-green-600' : 'text-red-600'">
                  {{ account.is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      accounts: [],
      loading: true,
      form: {
        account_number: '',
        account_name: '',
        account_type: 'Asset',
        parent_id: '',
        description: '',
        is_active: true
      }
    };
  },
  mounted() {
    this.loadAccounts();
  },
  methods: {
    async loadAccounts() {
      this.loading = true;
      try {
        const response = await fetch('/api/accounts', {
          headers: { 'Accept': 'application/json' },
          credentials: 'same-origin'
        });

        if (!response.ok) {
          throw new Error('Failed to load accounts');
        }

        this.accounts = await response.json();
      } catch (error) {
        console.error(error);
      } finally {
        this.loading = false;
      }
    },
    async saveAccount() {
      try {
        const payload = { ...this.form };
        if (payload.parent_id === '') payload.parent_id = null;

        const response = await fetch('/api/accounts', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
          },
          body: JSON.stringify(payload),
          credentials: 'same-origin'
        });

        if (!response.ok) {
          throw new Error('Unable to save account');
        }

        this.form = {
          account_number: '',
          account_name: '',
          account_type: 'Asset',
          parent_id: '',
          description: '',
          is_active: true
        };
        await this.loadAccounts();
      } catch (error) {
        console.error(error);
        alert('Could not create the account.');
      }
    }
  }
};
</script>