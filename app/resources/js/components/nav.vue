<template>
  <nav class="sticky top-5 z-50 flex justify-center">
    <div
      class="flex items-center gap-5 rounded-full bg-white px-6 py-3 shadow-lg"
    >
      <!-- Status Indicator -->
      <div class="flex items-center gap-3">
        <span
          class="h-3 w-3 rounded-full transition-all duration-300"
          :class="indicatorColor"
        ></span>

        <span class="font-medium text-gray-800">
          {{ pageTitle }}
        </span>
      </div>

      <!-- Divider -->
      <div class="h-6 w-px bg-gray-400"></div>

      <!-- Dropdown -->
     <div class="relative">
        <button
          @click="isOpen = !isOpen"
          class="cursor-pointer rounded-full px-3 py-1 transition hover:bg-gray-300"
        >
          Switch View ▾
        </button>

        <div
          v-if="isOpen"
          class="absolute right-0 mt-2 w-60 overflow-hidden rounded-2xl bg-white shadow-xl visible opacity-100 transition-all duration-200 pointer-events-auto"
        >
          <router-link
            to="/ChartOfAccounts"
            @click="isOpen = false"
            class="block items-center gap-3 px-4 py-3 text- text-decoration-none hover:bg-slate-900 hover:text-white"
          >
            <span class="h-2.5 w-2.5 rounded-full bg-green-500 inline-block"></span>
            Chart of Accounts
          </router-link>

          <router-link
            to="/JournalEntry"
            @click="isOpen = false"
            class="block items-center gap-3 px-4 py-3 text-decoration-none hover:bg-slate-900 hover:text-white"
          >
            <span class="h-2.5 w-2.5 rounded-full bg-yellow-500 inline-block"></span>
            Journal Entries
          </router-link>

          <router-link
            to="/GeneralLedger"
            @click="isOpen = false"
            class="block items-center gap-3 px-4 py-3 text-decoration-none hover:bg-slate-900 hover:text-white"
          >
            <span class="h-2.5 w-2.5 rounded-full bg-blue-500 inline-block"></span>
            General Ledger
          </router-link>
        </div>
      </div>
        <div class="h-6 w-px bg-slate-900 text-white"></div>
        <div class="relative">
        <button
          @click="Openis = !Openis"
          class="bg-slate-900 rounded-full px-3 py-1 text-center text-white cursor-pointer hover:bg-slate-700 transition"
        >
            <span>{{ userDisplayName }}</span>
        </button>

        <div v-if="Openis" class="absolute right-0 mt-2 w-60 overflow-hidden rounded-2xl bg-white shadow-xl visible opacity-100 transition-all duration-200 pointer-events-auto">
            <button
                @click="logout"
                class="w-full text-left block items-center gap-3 px-4 py-3 hover:bg-gray-100 text-decoration-none bg-transparent border-none cursor-pointer"
            >
                Logout
            </button>
        </div>
        </div>

    </div>
  </nav>
</template>

<script>
export default {
  name: "Nav",
  data() {
    return {
      isOpen: false,
      Openis: false,
      user: null
    };
  },
  computed: {
    pageTitle() {
      const pages = {
        "Chart of Accounts": "Chart of Accounts",
        "Journal Entry": "Journal Entries",
        "General Ledger": "General Ledger",
        "Laura-Belle": "Laura-Belle"
      };

      return pages[this.$route.meta.title] || this.$route.meta.title;
    },

    indicatorColor() {
      const colors = {
        "Chart of Accounts": "bg-green-500",
        "Journal Entry": "bg-yellow-500",
        "General Ledger": "bg-blue-500",
        "Laura-Belle": "bg-red-500"
      };

      return colors[this.$route.meta.title] || "bg-gray-400";
    },

    userDisplayName() {
      if (!this.user || !this.user.name) return "User";
      const nameParts = this.user.name.trim().split(/\s+/);
      if (nameParts.length >= 2) {
        return `${nameParts[0]} ${nameParts[nameParts.length - 1]}`;
      }
      return nameParts[0];
    }
  },
  methods: {
    async logout() {
      try {
        // Call logout endpoint
        await fetch('/api/logout', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
          }
        });
        // Redirect to login
        window.location.href = '/';
      } catch (error) {
        console.error('Logout failed:', error);
        // Fallback - just redirect
        window.location.href = '/';
      }
    },

    async fetchUser() {
      try {
        const response = await fetch('/api/user');
        if (response.ok) {
          this.user = await response.json();
        }
      } catch (error) {
        console.error('Failed to fetch user:', error);
      }
    }
  },
  mounted() {
    this.fetchUser();
  }
};
</script>