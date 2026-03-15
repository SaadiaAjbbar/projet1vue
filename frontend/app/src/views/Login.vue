<template>

<form @submit.prevent="login">

<input v-model="email" placeholder="Email" />

<input v-model="password" type="password" placeholder="Password" />

<button type="submit">Login</button>

<p>{{ message }}</p>

</form>

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
