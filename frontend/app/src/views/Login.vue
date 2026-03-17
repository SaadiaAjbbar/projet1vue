<template>
  <div class="flex min-h-[50vh] items-center justify-center p-4">
    <div class="w-full max-w-sm rounded-xl border border-slate-200 bg-white p-8 shadow-lg">
      <h2 class="mb-6 text-2xl font-bold text-slate-900">Welcome Back</h2>

      <form @submit.prevent="login" class="space-y-4">
        <input
          v-model="email"
          type="email"
          placeholder="Email Address"
          required
          class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
        />

        <input
          v-model="password"
          type="password"
          placeholder="Password"
          required
          class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
        />

        <button
          type="submit"
          class="w-full rounded-lg bg-blue-600 py-2 font-semibold text-white transition hover:bg-blue-700"
        >
          Login
        </button>
      </form>

      <p v-if="message" class="mt-4 text-center text-sm text-red-600">{{ message }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const message = ref('')
const router = useRouter() // Import router to move user after login

async function login() {
  try {
    const res = await fetch('http://localhost:8080/api/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        email: email.value,
        password: password.value
      })
    })

    const data = await res.json()

    if (!res.ok) {
      message.value = data.message || 'Login failed'
    } else {
      // 1. Save Token
      localStorage.setItem("token", data.token)

      // 2. Redirect to home page
      router.push('/')
    }
  } catch (err) {
    message.value = 'Server error. Please try again later.'
  }
}
</script>
