<template>
  <div class="register-container">
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div>
        <label>Name:</label>
        <input type="text" v-model="name" required />
      </div>

      <div>
        <label>Email:</label>
        <input type="email" v-model="email" required />
      </div>

      <div>
        <label>Password:</label>
        <input type="password" v-model="password" required />
      </div>

      <button type="submit">Register</button>
    </form>

    <p v-if="message">{{ message }}</p>
  </div>
</template>

<script setup>
import { ref } from "vue"

const name = ref("")
const email = ref("")
const password = ref("")
const message = ref("")
async function register() {
  console.log("starting registration with", name.value, email.value, password.value)
  const response = await fetch('http://localhost:8080/api/register', {
    method: 'POST',
     headers:{
    "Content-Type":"application/json"
    },
    body: JSON.stringify({
      name: name.value,
      email: email.value,
      password: password.value
    })
  })

  const data = await response.json()

  if (!response.ok) {
    message.value = data.message || 'Error during registration'
  } else {
    message.value = 'Registered successfully! Your token: ' + data.token
    console.log(data)
  }

}

// export default {
//   name: "Register",
//   data() {
//     return {
//       name: "",
//       email: "",
//       password: "",
//       message: "",
//     };
//   },
//   methods: {
//     async registerUser() {
//       try {
//         const response = await fetch("http://localhost:8080/api/register", {
//           method: "POST",
//           headers: {
//             "Content-Type": "application/json",
//           },
//           body: JSON.stringify({
//             name: this.name,
//             email: this.email,
//             password: this.password,
//           }),
//         });

//         const data = await response.json();

//         if (!response.ok) {
//           this.message = data.message || "Error during registration";
//         } else {
//           this.message = "Registered successfully! Your token: " + data.token;
//           console.log(data);
//         }
//       } catch (error) {
//         console.error(error);
//         this.message = "Network error!";
//       }
//     },
//   },
// };
</script>

<style scoped>
.register-container {
  max-width: 400px;
  margin: auto;
  padding: 20px;
}

input {
  width: 100%;
  margin-bottom: 10px;
  padding: 5px;
}

button {
  padding: 10px;
  width: 100%;
}
</style>
