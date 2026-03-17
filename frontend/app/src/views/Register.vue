<template>
  <div class="flex min-h-[50vh] items-center justify-center p-4">
    <div class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-8 shadow-lg">
      <h2 class="mb-6 text-2xl font-bold text-slate-900">Create an Account</h2>

      <form @submit.prevent="register" class="space-y-4">
        <div>
          <label class="mb-1 block text-sm font-medium text-slate-700">Name</label>
          <input v-model="name" type="text" required
            class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
        </div>

        <div>
          <label class="mb-1 block text-sm font-medium text-slate-700">Email</label>
          <input v-model="email" type="email" required
            class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
        </div>

        <div>
          <label class="mb-1 block text-sm font-medium text-slate-700">Password</label>
          <input v-model="password" type="password" required
            class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
        </div>

        <button type="submit" :disabled="loading"
          class="w-full rounded-lg bg-blue-600 py-2 font-semibold text-white transition hover:bg-blue-700 disabled:opacity-50">
          {{ loading ? 'Processing...' : 'Register' }}
        </button>
      </form>

      <p v-if="message" :class="['mt-4 p-3 rounded-md text-sm', isError ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600']">
        {{ message }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue"

const name = ref("")
const email = ref("")
const password = ref("")
const message = ref("")
const loading = ref(false)
const isError = ref(false)

async function register() {
  loading.value = true
  isError.value = false

  try {
    const response = await fetch('http://localhost:8080/api/register', {
      method: 'POST',
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        name: name.value,
        email: email.value,
        password: password.value
      })
    })

    const data = await response.json()

    if (!response.ok) {
      isError.value = true
      message.value = data.message || 'Error during registration'
    } else {
      message.value = 'Registered successfully! Welcome aboard.'
      // Optionally redirect or clear fields
    }
  } catch (err) {
    isError.value = true
    message.value = 'Server connection failed.'
  } finally {
    loading.value = false
  }
}
</script>
