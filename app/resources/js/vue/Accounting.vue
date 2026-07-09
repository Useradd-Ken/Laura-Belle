<template>
  <div class="min-h-screen bg-slate-50">

    <!-- Header -->
    <div class="border-b border-slate-200 bg-white">
      <div class="mx-auto max-w-[1800px] px-8 py-6">
        <div class="flex items-center justify-between">

          <div>
            <h1 class="text-3xl font-bold text-slate-900">
              Chart of Accounts
            </h1>

            <p class="mt-1 text-sm text-slate-500">
              Manage your organization's accounting structure.
            </p>
          </div>
          <div class="flex items-center gap-3">
            <div class="rounded-xl border border-slate-200 bg-white px-5 py-3 shadow-sm">
              <p class="text-xs uppercase tracking-wide text-slate-500">
                Total Accounts
              </p>

              <p class="text-2xl font-bold text-slate-900">
                {{ filteredAccounts.length }}
              </p>
            </div>

          </div>

        </div>

        <!-- Search -->
        <div class="mt-6">

          <SearchBar
            v-model="search"

            :typeFilter="typeFilter"
            :statusFilter="statusFilter"
            :viewMode="viewMode"

            :typeOptions="accountTypes"

            @update:typeFilter="typeFilter = $event"
            @update:statusFilter="statusFilter = $event"
            @update:viewMode="viewMode = $event"

            @new-account="openCreateModal"
          />

        </div>

      </div>
    </div>

    <!-- Workspace -->
    <div class="mx-auto max-w-[1800px] px-8 py-6">

      <div class="grid grid-cols-12 gap-6">

        <!-- LEFT -->
        <aside class="col-span-3">

          <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">

              <h2 class="font-semibold text-slate-900">
                Account Tree
              </h2>

              <p class="mt-1 text-sm text-slate-500">
                Browse account hierarchy
              </p>

            </div>

            <div class="max-h-[700px] overflow-y-auto p-4">

              <AccountTree
                :accounts="treeAccounts"
                :selectedAccountId="selectedAccount?.id"
                :expandedIds="expandedIds"

                @select="selectAccount"
                @toggle-expand="toggleExpand"
              />

            </div>

          </div>

        </aside>

        <!-- CENTER -->
        <section class="col-span-6">

          <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">

              <div>

                <h2 class="font-semibold text-slate-900">
                  Accounts
                </h2>

                <p class="text-sm text-slate-500">
                  {{ filteredAccounts.length }} records
                </p>

              </div>

            </div>

            <div v-if="loading" class="p-12 text-center">

              <div class="text-slate-500">
                Loading accounts...
              </div>

            </div>

            <div v-else>

              <AccountTable
                :accounts="filteredAccounts"
                :selectedAccountId="selectedAccount?.id"

                @select="selectAccount"

                @view="selectAccount"

                @edit="openEditModal"

                @add-child="openChildModal"

                @delete="openDeleteModal"
              />

            </div>

          </div>

        </section>

        <!-- RIGHT -->
        <aside class="col-span-3">

          <AccountDetails
            :selectedAccount="selectedAccount"

            @edit="openEditModal"

            @delete="openDeleteModal"

            @add-child="openChildModal"

            @view-ledger="viewLedger"
          />

        </aside>

      </div>

    </div>

    <!-- Account Modal -->

    <AccountModal

      :visible="showAccountModal"

      :mode="modalMode"

      :form="form"

      :accounts="accounts"

      :accountTypes="accountTypes"

      @close="closeAccountModal"

      @submit="saveAccount"

      @update-form="updateForm"

    />

    <!-- Delete -->

    <DeleteModal

      :visible="showDeleteModal"

      :itemName="selectedAccount?.account_name"

      @cancel="closeDeleteModal"

      @confirm="deleteAccount"

    />

  </div>
</template>
<script>
import SearchBar from "../components/SearchBar.vue";
import AccountTree from "../components/AccountTree.vue";
import AccountTable from "../components/AccountTable.vue";
import AccountDetails from "../components/AccountDetails.vue";
import AccountModal from "../components/AccountModal.vue";
import DeleteModal from "../components/DeleteModal.vue";
import "../../css/app.css";

export default {
  name: "Accounting",

  components: {
    SearchBar,
    AccountTree,
    AccountTable,
    AccountDetails,
    AccountModal,
    DeleteModal,
  },

  data() {
    return {
      loading: true,
      // API
      accounts: [],
      // UI
      search: "",
      typeFilter: "all",
      statusFilter: "all",
      viewMode: "tree",
      // Tree
      expandedIds: [],
      // Selected Account
      selectedAccount: null,
      // Modals
      showAccountModal: false,
      showDeleteModal: false,
      modalMode: "create",
      // Types
      accountTypes: [
        "Asset",
        "Liability",
        "Equity",
        "Revenue",
        "Expense",
      ],
      // Form
      form: {
        account_number: "",
        account_name: "",
        account_type: "Asset",
        parent_id: "",
        description: "",
        is_active: true,
      },
    };
  },

  mounted() {
    this.loadAccounts();
  },

  computed: {
    filteredAccounts() {
      let list = [...this.accounts];

      // Search
      if (this.search.trim() !== "") {
        const keyword = this.search.toLowerCase();

        list = list.filter((account) => {
          return (
            account.account_number.toLowerCase().includes(keyword) ||
            account.account_name.toLowerCase().includes(keyword)
          );
        });
      }

      // Type Filter
      if (this.typeFilter !== "all") {
        list = list.filter(
          (account) => account.account_type === this.typeFilter
        );
      }

      // Status Filter
      if (this.statusFilter !== "all") {
        list = list.filter((account) => {
          if (this.statusFilter === "active")
            return account.is_active;

          return !account.is_active;
        });
      }

      return list;
    },

    treeAccounts() {
      const map = {};

      this.accounts.forEach((account) => {
        map[account.id] = {
          ...account,
          children: [],
        };
      });

      const roots = [];

      Object.values(map).forEach((account) => {
        if (account.parent_id && map[account.parent_id]) {
          map[account.parent_id].children.push(account);
        } else {
          roots.push(account);
        }
      });

      return roots;
    },
  },

  methods: {
    async loadAccounts() {
      this.loading = true;

      try {
        const response = await fetch("/api/accounts", {
          headers: {
            Accept: "application/json",
          },
          credentials: "same-origin",
        });

        if (!response.ok) {
          throw new Error("Failed to load accounts");
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

        if (payload.parent_id === "") {
          payload.parent_id = null;
        }

        const response = await fetch("/api/accounts", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN":
              document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content") || "",
          },
          body: JSON.stringify(payload),
          credentials: "same-origin",
        });

        if (!response.ok) {
          throw new Error("Unable to save account");
        }

        this.closeAccountModal();

        await this.loadAccounts();
      } catch (error) {
        console.error(error);
        alert("Unable to save account.");
      }
    },

    updateForm(value) {
      this.form = value;
    },

    selectAccount(account) {
      this.selectedAccount = account;
    },

    toggleExpand(id) {
      if (this.expandedIds.includes(id)) {
        this.expandedIds = this.expandedIds.filter((item) => item !== id);
      } else {
        this.expandedIds.push(id);
      }
    },

    resetForm() {
      this.form = {
        account_number: "",
        account_name: "",
        account_type: "Asset",
        parent_id: "",
        description: "",
        is_active: true,
      };
    },

    openCreateModal() {
      this.modalMode = "create";

      this.resetForm();

      this.showAccountModal = true;
    },

    openEditModal(account) {
      this.modalMode = "edit";

      this.selectedAccount = account;

      this.form = {
        account_number: account.account_number,
        account_name: account.account_name,
        account_type: account.account_type,
        parent_id: account.parent_id || "",
        description: account.description || "",
        is_active: account.is_active,
      };

      this.showAccountModal = true;
    },

    openChildModal(parent) {
      this.modalMode = "create";

      this.resetForm();

      this.form.parent_id = parent.id;

      this.showAccountModal = true;
    },

    closeAccountModal() {
      this.showAccountModal = false;

      this.resetForm();
    },

    openDeleteModal(account) {
      this.selectedAccount = account;

      this.showDeleteModal = true;
    },

    closeDeleteModal() {
      this.showDeleteModal = false;
    },

    deleteAccount() {
      /*
        Backend DELETE endpoint
        not yet implemented.
      */

      this.showDeleteModal = false;

      // alert(
      //   "Delete endpoint has not been implemented yet."
      // );
    },

    viewLedger(account) {
      // console.log("Open ledger:", account);

      // Future:
      // this.$router.push(`/ledger/${account.id}`)
    },
  },
};
</script>
