<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="w-full max-w-3xl bg-white rounded-lg shadow-md p-6">
      <h2 class="text-2xl font-bold mb-4 text-center">My Favorite Questions</h2>
      <div v-if="favorites.length === 0" class="text-center text-gray-500">
        You haven't added any questions to your favorites yet.
      </div>
      <ul v-else class="space-y-4">
        <li v-for="favorite in favorites" :key="favorite.id" class="p-4 border rounded-lg bg-gray-50">
          <h3 class="text-lg font-semibold">{{ favorite.question.title }}</h3>
          <p class="text-sm text-gray-600 mt-1">{{ favorite.question.content }}</p>
          <p class="text-xs text-gray-400 mt-2">Asked by {{ favorite.question.user.name }}</p>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
import { ref, onMounted } from 'vue'
export default {
  name: 'Favorites',
  setup() {
    const favorites = ref([])

    async function fetchFavorites() {
      try {
        const res = await fetch('http://localhost:8080/api/favorites', {
          method: 'GET',
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("token")
          }
        })
        if (!res.ok) throw new Error('Failed to load favorites')
        favorites.value = await res.json()

        console.log("Fetched favorites:", favorites.value)
      } catch (err) {
        console.error(err)
      }
    }

    onMounted(fetchFavorites)

    return { favorites }
  }
}

</script>
