<template>
  <div class="max-w-4xl mx-auto py-10 px-4">
    <header class="mb-8 border-b border-slate-200 pb-4">
      <h2 class="text-3xl font-bold text-slate-800">Latest Questions</h2>
      <div v-if="message" class="mt-4 p-4 rounded-lg bg-red-50 text-red-600 border border-red-200">
        {{ message }}
      </div>
    </header>

    <div class="space-y-6">
      <div v-for="question in questions" :key="question.id"
           class="bg-white rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md hover:border-blue-300 overflow-hidden">

        <div class="p-6">
          <h3 class="text-xl font-semibold text-slate-900 mb-2">{{ question.title }}</h3>
          <p class="text-slate-600 leading-relaxed">{{ question.content }}</p>
        </div>

        <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center gap-3">
          <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold uppercase">
            {{ question.user.name.charAt(0) }}
          </div>
          <span class="text-sm text-slate-600">
            Posted by <strong class="text-slate-900">{{ question.user.name }}</strong>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// Your existing script logic is perfect as is!
import { ref, onMounted } from 'vue'

const questions = ref([])
const message = ref('')

async function fetchQuestions() {
  try {
    const response = await fetch('http://localhost:8080/api/listeQuestions', {
      method: 'GET',
      headers: {
        "Authorization": "Bearer " + localStorage.getItem("token"),
        "Accept": "application/json"
      }
    })

    const data = await response.json()

    if (!response.ok) {
      message.value = data.message || 'Error fetching questions'
    } else {
      questions.value = data
    }
  } catch (error) {
    message.value = 'Failed to connect to the server.'
  }
}

onMounted(fetchQuestions)
</script>
