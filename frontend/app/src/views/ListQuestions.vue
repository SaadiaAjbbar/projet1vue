<template>
  <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">

      <h2 class="text-3xl font-extrabold text-gray-900 mb-8 border-b pb-4">
        Questions List
      </h2>

      <div v-if="message"
        :class="`mb-4 p-4 rounded-md shadow-sm border-l-4 ${message.includes('✅') || message.includes('successfully') ? 'bg-green-100 text-green-700 border-green-500' : 'bg-red-100 text-red-700 border-red-500'}`">
        {{ message }}
      </div>

      <div class="space-y-8">
        <div v-for="question in questions" :key="question.id"
          class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 transition hover:shadow-lg">

          <div class="p-6">
            <div v-if="editingQuestionId !== question.id">
              <div class="flex justify-between items-start">
                <h3 class="text-xl font-bold text-indigo-600 mb-2 flex-1">{{ question.title }}</h3>

                <button @click="addToFavorites(question.id)"
                  class="ml-4 p-2 rounded-full hover:bg-red-50 group transition duration-200" title="Add to favorites">
                  <svg xmlns="http://www.w3.org/2000/svg"  v-if="question.favorites[0]" class="text-red-500 fill-current group-hover:text-red-600 transition-colors duration-200"
                    :class="['h-6 w-6 transition-colors duration-200', question.is_favorite ? 'text-red-500 fill-current' : 'text-gray-400 group-hover:text-red-400']"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                  <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 group-hover:text-red-400 transition-colors duration-200"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>

                </button>
              </div>

              <p class="text-gray-700 mb-4 leading-relaxed">{{ question.content }}</p>

              <div class="flex items-center justify-between">
                <div class="flex items-center text-sm text-gray-500">
                  <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded mr-2 text-xs font-semibold">Author</span>
                  {{ question.user.name }}
                </div>

                <div v-if="currentUser && Number(currentUser.id) === Number(question.user_id)" class="flex space-x-3">
                  <button @click="startEditQuestion(question)"
                    class="text-blue-500 hover:text-blue-700 text-xs font-medium transition flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                      </path>
                    </svg>
                    Edit
                  </button>
                  <button @click="deleteQuestion(question.id)"
                    class="text-red-500 hover:text-red-700 text-xs font-medium transition flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                      </path>
                    </svg>
                    Delete
                  </button>
                </div>
              </div>
            </div>

            <div v-else class="space-y-3">
              <input v-model="editedTitle"
                class="w-full p-2 border border-indigo-300 rounded-md focus:ring-2 focus:ring-indigo-500 outline-none text-sm mb-2" />
              <textarea v-model="editedContentQuestion"
                class="w-full p-2 border border-indigo-300 rounded-md focus:ring-2 focus:ring-indigo-500 outline-none text-sm"
                rows="3"></textarea>
              <div class="flex space-x-2 mt-2">
                <button @click="updateQuestion(question.id)"
                  class="bg-green-600 text-white px-4 py-1.5 rounded text-xs font-bold hover:bg-green-700 transition">Save
                  Changes</button>
                <button @click="editingQuestionId = null"
                  class="bg-gray-400 text-white px-4 py-1.5 rounded text-xs font-bold hover:bg-gray-500 transition">Cancel</button>
              </div>
            </div>
          </div>

          <div class="bg-gray-50 p-6 border-t border-gray-100">
            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
              Responses
              <span class="ml-2 bg-indigo-200 text-indigo-800 text-xs px-2 py-0.5 rounded-full font-bold">
                {{ question.responses.length }}
              </span>
            </h4>

            <div v-if="question.responses.length > 0" class="space-y-4">
              <div v-for="response in question.responses" :key="response.id"
                class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm relative group">

                <div v-if="editingId !== response.id">
                  <p class="text-gray-800 text-sm mb-2 leading-relaxed">{{ response.content }}</p>
                  <div class="flex justify-between items-center">
                    <small class="text-gray-400 flex items-center">
                      <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                      </svg>
                      {{ response.user.name }}
                    </small>
                    <div v-if="currentUser && Number(currentUser.id) === Number(response.user_id)"
                      class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                      <button @click="startEdit(response)"
                        class="text-blue-500 hover:text-blue-700 text-xs font-medium underline">Edit</button>
                      <button @click="deleteResponse(response.id)"
                        class="text-red-500 hover:text-red-700 text-xs font-medium underline">Delete</button>
                    </div>
                  </div>
                </div>

                <div v-else class="space-y-3">
                  <textarea v-model="editedContent"
                    class="w-full p-2 border rounded-md focus:ring-2 focus:ring-indigo-500 outline-none text-sm"
                    rows="2"></textarea>
                  <div class="flex space-x-2">
                    <button @click="updateResponse(response.id)"
                      class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 transition">Save</button>
                    <button @click="editingId = null"
                      class="bg-gray-400 text-white px-3 py-1 rounded text-xs hover:bg-gray-500 transition">Cancel</button>
                  </div>
                </div>
              </div>
            </div>

            <p v-else class="text-gray-400 italic text-sm text-center py-2">No responses yet. Be the first to answer!
            </p>

            <form @submit.prevent="createResponse(question.id)" class="mt-6 border-t pt-4">
              <textarea v-model="responses[question.id]" placeholder="Write your response..."
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent outline-none text-sm transition placeholder-gray-400"
                rows="2"></textarea>
              <button type="submit"
                class="mt-2 w-full sm:w-auto inline-flex justify-center items-center px-6 py-2 bg-indigo-600 text-white text-sm font-bold rounded-md hover:bg-indigo-700 shadow-sm transition">
                Post Response
              </button>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const questions = ref([])
const responses = ref({})
const message = ref('')
const currentUser = JSON.parse(localStorage.getItem("user") || "null")

// ================= FETCH QUESTIONS =================
async function fetchQuestions() {
  try {
    const res = await fetch('http://localhost:8080/api/listeQuestions', {
      headers: {
        "Authorization": "Bearer " + localStorage.getItem("token"),
        "Accept": "application/json"
      }
    })
    const data = await res.json()
    questions.value = data
    console.log("Fetched questions:", data)
  } catch (err) { message.value = "Failed to load questions." }
}

// ================= FAVORITE LOGIC =================
async function addToFavorites(questionId) {
  try {
    const res = await fetch('http://localhost:8080/api/favorites/toggle/' + questionId, {
      method: 'POST',
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": "Bearer " + localStorage.getItem("token")
      }
    })

    const data = await res.json()
    if (!res.ok) {
      message.value = data.message || 'Error with favorite'
    } else {
      message.value = data.message
      fetchQuestions() // Refresh list to show updated state
    }
  } catch (error) {
    message.value = "Network error while favoriting"
  }
}

// ================= EDIT RESPONSE =================
const editingId = ref(null)
const editedContent = ref('')

function startEdit(response) {
  editingId.value = response.id
  editedContent.value = response.content
}

async function updateResponse(id) {
  try {
    const res = await fetch(`http://localhost:8080/api/updateResponse/${id}`, {
      method: 'PUT',
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": "Bearer " + localStorage.getItem("token")
      },
      body: JSON.stringify({ content: editedContent.value })
    })
    const data = await res.json()
    if (!res.ok) message.value = data.message || 'Error updating'
    else {
      message.value = 'Response updated ✅'
      editingId.value = null
      fetchQuestions()
    }
  } catch (error) { message.value = error.message }
}

// ================= DELETE RESPONSE =================
async function deleteResponse(id) {
  if (!confirm("Are you sure you want to delete this response?")) return
  try {
    const res = await fetch(`http://localhost:8080/api/deleteResponse/${id}`, {
      method: 'DELETE',
      headers: {
        "Authorization": "Bearer " + localStorage.getItem("token"),
        "Accept": "application/json"
      }
    })
    const data = await res.json()
    if (!res.ok) message.value = data.message || 'Error deleting'
    else {
      message.value = 'Response deleted 🗑️'
      fetchQuestions()
    }
  } catch (error) { message.value = error.message }
}

// ================= CREATE RESPONSE =================
async function createResponse(questionId) {
  if (!responses.value[questionId]) return;
  try {
    const res = await fetch('http://localhost:8080/api/CreateResponse', {
      method: 'POST',
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": "Bearer " + localStorage.getItem("token")
      },
      body: JSON.stringify({ content: responses.value[questionId], question_id: questionId })
    })
    const data = await res.json()
    if (!res.ok) message.value = data.message || 'Error'
    else {
      message.value = 'Response added successfully ✅'
      responses.value[questionId] = ''
      fetchQuestions()
    }
  } catch (error) { message.value = error.message }
}

// ================= EDIT / DELETE QUESTION =================
const editingQuestionId = ref(null)
const editedTitle = ref('')
const editedContentQuestion = ref('')

function startEditQuestion(question) {
  editingQuestionId.value = question.id
  editedTitle.value = question.title
  editedContentQuestion.value = question.content
}

async function updateQuestion(id) {
  try {
    const res = await fetch(`http://localhost:8080/api/updateQuestion/${id}`, {
      method: 'PUT',
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": "Bearer " + localStorage.getItem("token")
      },
      body: JSON.stringify({ title: editedTitle.value, content: editedContentQuestion.value })
    })
    const data = await res.json()
    if (!res.ok) message.value = data.message || 'Error updating question'
    else {
      message.value = 'Question updated ✅'
      editingQuestionId.value = null
      fetchQuestions()
    }
  } catch (error) { message.value = error.message }
}

async function deleteQuestion(id) {
  if (!confirm("Are you sure you want to delete this question?")) return
  try {
    const res = await fetch(`http://localhost:8080/api/deleteQuestion/${id}`, {
      method: 'DELETE',
      headers: {
        "Authorization": "Bearer " + localStorage.getItem("token"),
        "Accept": "application/json"
      }
    })
    const data = await res.json()
    if (!res.ok) message.value = data.message || 'Error deleting question'
    else {
      message.value = 'Question deleted 🗑️'
      fetchQuestions()
    }
  } catch (error) { message.value = error.message }
}

onMounted(() => { fetchQuestions() })
</script>
