<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
      <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800">Merhba bik</h1>
        <p class="text-gray-500 mt-2">Dkhel l-macloumat dyalk bach t-connecta</p>
      </div>

      <form @submit.prevent="login" class="space-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            v-model="email"
            type="email"
            placeholder="example@mail.com"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input
            v-model="password"
            type="password"
            placeholder="••••••••"
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all"
          />
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors duration-300 shadow-md"
        >
          Login
        </button>
      </form>

      <p v-if="message" class="mt-6 text-center text-sm font-medium text-red-500 animate-pulse">
        {{ message }}
      </p>
    </div>
  </div>
</template>
<script setup >
import { ref } from 'vue'

const email = ref('')
const password = ref('')
const message = ref('')

async function login() {
  try {
    const res = await fetch('http://localhost:8080/api/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: email.value, password: password.value })
    })

    const data = await res.json()

    if (!res.ok) {
      message.value = 'Login failed'
    } else {
      message.value = 'Logged in! Token: ' + data.token
      console.log(data)

    }
  } catch (err) {
    message.value = 'password or email is incorrect';
  }
}
</script>
