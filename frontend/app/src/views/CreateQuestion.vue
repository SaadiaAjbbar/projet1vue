<template>
  <div class="min-h-screen bg-slate-50 py-12 px-4">
    <div class="mx-auto max-w-lg w-full bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

      <div class="text-center mb-8">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </div>
        <h2 class="text-2xl font-bold text-slate-900">New Question</h2>
        <p class="text-slate-500 text-sm mt-2">Clear questions get faster answers.</p>
      </div>

      <form @submit.prevent="createQuestion" class="space-y-6">
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Subject</label>
          <input v-model="title" type="text" placeholder="Be brief and descriptive..." required
            class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition outline-none" />
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Detailed Content</label>
          <textarea v-model="content" placeholder="Explain your context here..." rows="6" required
            class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition outline-none resize-none"></textarea>
        </div>

        <button type="submit" :disabled="!title || !content"
          class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-slate-300 text-white font-semibold py-3 rounded-lg transition transform active:scale-[0.98]">
          Publish Question
        </button>
      </form>

      <div v-if="message" :class="['mt-6 p-4 rounded-lg text-sm text-center font-medium', message.includes('Error') ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600']">
        {{ message }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const title = ref('')
const content = ref('')
const message = ref('')

async function createQuestion() {
  try {
    const response = await fetch('http://localhost:8080/api/Createquestion', {
      method: 'POST',
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": "Bearer " + localStorage.getItem("token")
      },
      body: JSON.stringify({ title: title.value, content: content.value })
    })

    const data = await response.json()
    if (!response.ok) {
      message.value = data.message || 'Error creating question'
    } else {
      message.value = 'Question published successfully!'
      title.value = ''
      content.value = ''
    }
  } catch (error) {
    message.value = "Error connecting to server"
  }
}
</script>
