<template>
  <div class="space-y-2">
    <div v-for="node in treeData" :key="node.id" class="space-y-1">
      <button
        type="button"
        class="flex w-full items-center justify-between rounded-xl px-3 py-2 text-left transition"
        :class="selectedAccountId === node.id ? 'bg-slate-900 text-white' : 'bg-slate-50 text-slate-700 hover:bg-slate-100'"
        @click="selectNode(node)"
      >
        <span class="flex items-center gap-2">
          <button v-if="node.children.length" type="button" class="rounded p-1" @click.stop="$emit('toggle-expand', node.id)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
              <path v-if="isExpanded(node.id)" d="m8 10 4 4 4-4" stroke-linecap="round" stroke-linejoin="round"></path>
              <path v-else d="m10 8 4 4-4 4" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </button>
          <svg v-else viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 opacity-70">
            <path d="M4 7h6l2 2h8v8H4z" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
          <span class="font-medium">{{ node.account_name }}</span>
        </span>
        <span class="text-xs uppercase tracking-wide" :class="selectedAccountId === node.id ? 'text-slate-300' : 'text-slate-400'">{{ node.account_number }}</span>
      </button>

      <div v-if="node.children.length && isExpanded(node.id)" class="ml-4 space-y-1 border-l border-slate-200 pl-3">
        <button
          v-for="child in node.children"
          :key="child.id"
          type="button"
          class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left transition"
          :class="selectedAccountId === child.id ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-50'"
          @click="selectNode(child)"
        >
          <span class="flex items-center gap-2">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 opacity-70">
              <path d="M4 7h6l2 2h8v8H4z" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span>{{ child.account_name }}</span>
          </span>
          <span class="text-xs uppercase tracking-wide" :class="selectedAccountId === child.id ? 'text-slate-300' : 'text-slate-400'">{{ child.account_number }}</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AccountTree',
  props: {
    accounts: Array,
    selectedAccountId: Number,
    expandedIds: Array
  },
  emits: ['select', 'toggle-expand'],
  computed: {
    treeData() {
      return this.accounts || [];
    }
  },
  methods: {
    isExpanded(id) {
      return this.expandedIds.includes(id);
    },
    selectNode(account) {
      this.$emit('select', account);
    }
  }
};
</script>
