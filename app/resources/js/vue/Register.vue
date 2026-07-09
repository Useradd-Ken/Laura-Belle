<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 bg-white rounded shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
            <form @submit.prevent="register">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name</label>
                    <input v-model="name" type="text" id="name" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input v-model="email" type="email" id="email" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input v-model="password" type="password" id="password" class="w-full px-3 py-2 border rounded" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Register</button>
            </form>
        </div>
    </div>
</template>

<script>
    
</script>
