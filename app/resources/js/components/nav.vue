<template>
  <nav class="sticky top-0 flex justify-center bg-white shadow-md py-3">
    <div class="rounded-full bg-gray-200 px-6 py-2 flex space-x-4 items-center">
      <router-link to="/dashboard" class="hover:text-blue-600">Journal Entries</router-link>
      <router-link to="/settings" class="hover:text-blue-600">General Ledger</router-link>

      <!-- Dropdown -->
      <div class="relative group">
        <button class="hover:text-blue-600">x</button>
        <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-md mt-2">
          <router-link to="/dashboard" class="block px-4 py-2 hover:bg-gray-100">Journal Entries</router-link>
          <router-link to="/settings" class="block px-4 py-2 hover:bg-gray-100">General Ledger</router-link>
        </div>
      </div>
    </div>
  </nav>
</template>
