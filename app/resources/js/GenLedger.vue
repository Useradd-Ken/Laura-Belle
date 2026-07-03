<template>

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-4xl p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-semibold mb-4">General Ledger</h1>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">Date</th>
                        <th class="border border-gray-300 px-4 py-2">Account</th>
                        <th class="border border-gray-300 px-4 py-2">Debit</th>
                        <th class="border border-gray-300 px-4 py-2">Credit</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample data, replace with dynamic data -->
                    <tr v-for="entry in ledgerEntries" :key="entry.id">
                        <td class="border border-gray-300 px-4 py-2">{{ entry.date }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ entry.account }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ entry.debit }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ entry.credit }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>