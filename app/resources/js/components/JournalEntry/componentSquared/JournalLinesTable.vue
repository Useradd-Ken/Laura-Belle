<template>
  <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
    <!-- Header -->
    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
      <div>
        <h3 class="text-lg font-semibold text-gray-900">
          Journal Lines
        </h3>
        <p class="text-sm text-gray-500">
          Debits must equal credits before posting.
        </p>
      </div>

      <button
        @click="addRow"
        type="button"
        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
      >
        + Add Line
      </button>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="w-[35%] px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
              Account
            </th>

            <th class="w-[15%] px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
              Debit
            </th>

            <th class="w-[15%] px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
              Credit
            </th>

            <th class="w-[25%] px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
              Memo
            </th>

            <th class="w-[10%] px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
              Action
            </th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-100 bg-white">

          <tr
            v-for="(line,index) in localLines"
            :key="index"
            class="hover:bg-gray-50"
          >

            <!-- ACCOUNT -->
            <td class="px-4 py-2">

              <select
                v-model="line.account_id"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
              >
                <option :value="null">
                  Select Account
                </option>

                <option
                  v-for="account in accounts"
                  :key="account.id"
                  :value="account.id"
                >
                  {{ account.account_number }}
                  -
                  {{ account.account_name }}
                </option>

              </select>

            </td>

            <!-- DEBIT -->
            <td class="px-4 py-2">

              <input
                v-model.number="line.debit"
                @input="onDebitInput(line)"
                type="number"
                min="0"
                step="0.01"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-right text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
              />

            </td>

            <!-- CREDIT -->
            <td class="px-4 py-2">

              <input
                v-model.number="line.credit"
                @input="onCreditInput(line)"
                type="number"
                min="0"
                step="0.01"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-right text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
              />

            </td>

            <!-- MEMO -->
            <td class="px-4 py-2">

              <input
                v-model="line.memo"
                type="text"
                placeholder="Optional memo..."
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
              />

            </td>

            <!-- DELETE -->
            <td class="px-4 py-2 text-center">

              <button
                @click="removeRow(index)"
                :disabled="localLines.length===1"
                class="rounded-md px-3 py-2 text-red-600 hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-40"
              >
                Delete
              </button>

            </td>

          </tr>

        </tbody>

        <tfoot class="bg-gray-50">

          <tr>

            <td
              colspan="1"
              class="px-4 py-3 text-right font-semibold text-gray-700"
            >
              Totals
            </td>

            <td class="px-4 py-3 text-right font-bold">
              {{ formatCurrency(totalDebit) }}
            </td>

            <td class="px-4 py-3 text-right font-bold">
              {{ formatCurrency(totalCredit) }}
            </td>

            <td colspan="2"></td>

          </tr>

          <tr>

            <td
              colspan="5"
              class="px-4 py-3"
            >

              <div
                class="flex items-center justify-between rounded-lg border px-4 py-3"
                :class="balanced
                  ? 'border-green-200 bg-green-50'
                  : 'border-red-200 bg-red-50'"
              >

                <div>

                  <p class="font-semibold">
                    Difference:
                    {{ formatCurrency(difference) }}
                  </p>

                  <p
                    class="text-sm"
                    :class="balanced ? 'text-green-700' : 'text-red-700'"
                  >
                    {{ balanced ? 'Balanced' : 'Out of Balance' }}
                  </p>

                </div>

              </div>

            </td>

          </tr>

        </tfoot>

      </table>
    </div>
  </div>
</template>

<script setup>
import { computed, watch, ref } from "vue";

const props = defineProps({
  modelValue: {
    type: Array,
    default: () => [],
  },

  accounts: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits([
  "update:modelValue",
]);

const emptyRow = () => ({
  account_id: null,
  debit: 0,
  credit: 0,
  memo: "",
});

const localLines = ref([]);

watch(
  () => props.modelValue,
  (value) => {
    localLines.value = value?.length
      ? JSON.parse(JSON.stringify(value))
      : [emptyRow()];
  },
  {
    immediate: true,
    deep: true,
  }
);const addRow = () => {
  localLines.value.push(emptyRow());
};

const removeRow = (index) => {
  if (localLines.value.length === 1) return;

  localLines.value.splice(index, 1);
};

const onDebitInput = (line) => {
  line.debit = Number(line.debit) || 0;

  if (line.debit > 0) {
    line.credit = 0;
  }
};

const onCreditInput = (line) => {
  line.credit = Number(line.credit) || 0;

  if (line.credit > 0) {
    line.debit = 0;
  }
};

const totalDebit = computed(() =>
  localLines.value.reduce(
    (sum, line) => sum + Number(line.debit || 0),
    0
  )
);

const totalCredit = computed(() =>
  localLines.value.reduce(
    (sum, line) => sum + Number(line.credit || 0),
    0
  )
);

const difference = computed(() =>
  Math.abs(totalDebit.value - totalCredit.value)
);

const balanced = computed(() =>
  totalDebit.value === totalCredit.value &&
  totalDebit.value > 0
);

watch(
  localLines,
  (value) => {
    emit(
      "update:modelValue",
      JSON.parse(JSON.stringify(value))
    );
  },
  {
    deep: true,
  }
);

const formatCurrency = (value) => {
  return Number(value || 0).toLocaleString(undefined, {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });
};
</script>