<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="modelValue"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-6"
      >
        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="opacity-100 scale-100"
          leave-to-class="opacity-0 scale-95"
        >
          <div
            v-if="modelValue"
            class="flex max-h-[95vh] w-full max-w-7xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl"
          >
            <!-- Header -->
            <div
              class="flex items-center justify-between border-b border-gray-200 px-8 py-5"
            >
              <div>
                <h2 class="text-2xl font-bold text-gray-900">
                  {{ isEditing ? "Edit Journal Entry" : "New Journal Entry" }}
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                  Record a balanced accounting transaction.
                </p>
              </div>

              <button
                @click="close"
                class="rounded-lg p-2 text-gray-500 hover:bg-gray-100"
              >
                ✕
              </button>
            </div>

            <!-- Body -->
            <div class="flex-1 overflow-y-auto px-8 py-6 space-y-6">

              <JournalForm
                v-model:reference_no="form.reference_no"
                v-model:entry_date="form.entry_date"
                v-model:description="form.description"
              />

              <JournalLinesTable
                v-model="form.lines"
                :accounts="accounts"
              />

              <JournalTotals
                :lines="form.lines"
              />

            </div>

            <!-- Footer -->
            <JournalFooter
              :loading="loading"
              :balanced="balanced"
              :is-editing="isEditing"
              @cancel="close"
              @save="saveDraft"
              @post="postEntry"
            />

          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { computed, reactive, watch } from "vue";

import JournalForm from "./componentSquared/JournalForm.vue";
import JournalLinesTable from "./componentSquared/JournalLinesTable.vue";
import JournalTotals from "./componentSquared/JournalTotal.vue";
import JournalFooter from "./componentSquared/JournalFooter.vue";

const props = defineProps({
  modelValue: Boolean,

  journal: {
    type: Object,
    default: () => null,
  },

  accounts: {
    type: Array,
    default: () => [],
  },

  loading: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits([
  "update:modelValue",
  "save",
  "post",
]);

const emptyLine = () => ({
  account_id: null,
  debit: 0,
  credit: 0,
  memo: "",
});

const emptyForm = () => ({
  id: null,
  reference_no: "",
  entry_date: new Date().toISOString().substring(0, 10),
  description: "",
  status: "Draft",
  lines: [emptyLine()],
});

const form = reactive(emptyForm());

watch(
  () => props.journal,
  (value) => {
    if (!value) {
      Object.assign(form, emptyForm());
      return;
    }

    form.id = value.id ?? null;
    form.reference_no = value.reference_no ?? "";
    form.entry_date = value.entry_date ?? "";
    form.description = value.description ?? "";
    form.status = value.status ?? "Draft";

    form.lines = value.lines?.length
      ? value.lines.map((line) => ({
          account_id: line.account_id,
          debit: Number(line.debit),
          credit: Number(line.credit),
          memo: line.memo ?? "",
        }))
      : [emptyLine()];
  },
  {
    immediate: true,
    deep: true,
  }
);

const totalDebit = computed(() =>
  form.lines.reduce((sum, line) => sum + Number(line.debit || 0), 0)
);

const totalCredit = computed(() =>
  form.lines.reduce((sum, line) => sum + Number(line.credit || 0), 0)
);

const balanced = computed(() => totalDebit.value === totalCredit.value);

const close = () => {
  emit("update:modelValue", false);
};

const saveDraft = () => {
  emit("save", JSON.parse(JSON.stringify(form)));
};

const postEntry = () => {
  emit("post", JSON.parse(JSON.stringify(form)));
};

const isEditing = computed(() => !!form.id);
</script>