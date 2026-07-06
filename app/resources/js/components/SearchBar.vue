<template>
  <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
      <div class="flex flex-1 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 text-slate-400">
          <circle cx="11" cy="11" r="6"></circle>
          <path d="m20 20-4.2-4.2" stroke-linecap="round"></path>
        </svg>
        <input
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          placeholder="Search account code or name"
          class="w-full border-0 bg-transparent text-sm outline-none"
        />
      </div>

      <div class="flex flex-wrap items-center gap-2">
        <select :value="typeFilter" @change="$emit('update:typeFilter', $event.target.value)" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none">
          <option value="all">All Types</option>
          <option v-for="type in typeOptions" :key="type" :value="type">{{ type }}</option>
        </select>

        <select :value="statusFilter" @change="$emit('update:statusFilter', $event.target.value)" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none">
          <option value="all">All Status</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>

        <div class="flex items-center rounded-xl border border-slate-200 bg-white p-1">
          <button
            type="button"
            @click="$emit('update:viewMode', 'tree')"
            class="rounded-lg px-3 py-2 text-sm font-medium transition"
            :class="viewMode === 'tree' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100'"
          >
            Tree
          </button>
          <button
            type="button"
            @click="$emit('update:viewMode', 'table')"
            class="rounded-lg px-3 py-2 text-sm font-medium transition"
            :class="viewMode === 'table' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100'"
          >
            Table
          </button>
        </div>

        <button
          type="button"
          @click="$emit('new-account')"
          class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white transition hover:bg-slate-800"
        >
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
            <path d="M12 5v14" stroke-linecap="round" />
            <path d="M5 12h14" stroke-linecap="round" />
          </svg>
          New
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SearchBar',
  props: {
    modelValue: String,
    typeFilter: String,
    statusFilter: String,
    viewMode: String,
    typeOptions: Array,
    statusOptions: Array
  },
  emits: ['update:modelValue', 'update:typeFilter', 'update:statusFilter', 'update:viewMode', 'new-account']
};
</script>
