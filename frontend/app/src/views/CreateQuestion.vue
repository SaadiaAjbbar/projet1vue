<template>

  <div>

    <h2>Create Question</h2>

    <form @submit.prevent="createQuestion">

      <input type="text" placeholder="Title" v-model="title" />

      <br><br>

      <textarea placeholder="Content" v-model="content"></textarea>

      <br><br>

      <button type="submit">
        Create Question
      </button>

    </form>

    <p>{{ message }}</p>

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

      body: JSON.stringify({
        title: title.value,
        content: content.value
      })

    })

    const data = await response.json()

    if (!response.ok) {
      message.value = data.message || 'Error creating question'
    } else {
      message.value = 'Question created successfully'
      title.value = ''
      content.value = ''
      console.log(data)
    }

  } catch (error) {
    message.value = error.message
  }

}

</script>


<style>
input,
textarea {
  width: 300px;
  padding: 8px;
}

button {
  padding: 8px 15px;
}
</style>
