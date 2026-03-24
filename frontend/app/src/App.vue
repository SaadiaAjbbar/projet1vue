<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <div class="min-h-screen bg-slate-50 font-sans text-slate-900">
    <header class="sticky top-0 z-50 w-full border-b bg-white/80 backdrop-blur-md">
      <div class="container mx-auto flex h-16 items-center justify-between px-4">

        <div class="flex items-center gap-8">
          <RouterLink to="/" class="flex items-center gap-2 text-xl font-bold text-blue-600">
            <span class="text-2xl">💬</span>
            <span class="hidden sm:block">LocalMind</span>
          </RouterLink>

          <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
            <RouterLink to="/ListQuestions" class="hover:text-blue-600 transition">Questions</RouterLink>
            <RouterLink to="/favorites" class="hover:text-blue-600 transition">My Favorites</RouterLink>
          </nav>
        </div>

        <div class="flex items-center gap-4">
          <div class="relative hidden sm:block">
            <input
              type="text"
              placeholder="Search questions..."
              class="h-9 w-64 rounded-md border border-slate-200 bg-slate-100 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20"
            />
          </div>

          <RouterLink
            to="/create-question"
            class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition"
          >
            Ask Question
          </RouterLink>

          <button class="h-9 w-9 rounded-full border border-slate-200 bg-slate-100 text-sm">
            👤
          </button>
        </div>
      </div>
    </header>

    <div class="container mx-auto grid grid-cols-1 gap-8 px-4 py-8 lg:grid-cols-12">

      <aside class="hidden lg:col-span-2 lg:block">
        <div class="sticky top-24 space-y-4">
          <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400">Personal</h3>
          <ul class="space-y-2 text-sm text-slate-600">
            <li><RouterLink to="/my-posts" class="block rounded-md px-2 py-1 hover:bg-slate-200">Your Questions</RouterLink></li>
            <li><RouterLink to="/my-answers" class="block rounded-md px-2 py-1 hover:bg-slate-200">Your Answers</RouterLink></li>
          </ul>
        </div>
      </aside>

      <main class="lg:col-span-7">
        <RouterView />
      </main>
    </div>

    <footer class="mt-auto border-t bg-white py-10 text-center text-sm text-slate-500">
      <p>&copy; 2026 LocalMind Project. Built with Vue & Tailwind.</p>
    </footer>
  </div>
</template>

<style>
.router-link-active:not(.text-xl) {
  @apply text-blue-600 font-bold;
}
</style>
