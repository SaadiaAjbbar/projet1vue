import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CreateQuestion from '../views/CreateQuestion.vue'
import ListQuestions from '../views/ListQuestions.vue'
import favorites from '../views/favorites.vue'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
    },

    {
      path: '/register',
      name: 'register',
      component: () => import('../views/Register.vue')
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/Login.vue')
    },
    {
      path: '/create-question',
      name: 'create-question',
      component: CreateQuestion
    },
    {
      path: '/ListQuestions',
      name: 'ListQuestions',
      component: ListQuestions
    },
    {
      path: '/favorites',
      name: 'favorites',
      component: favorites
    },

  ],
})

export default router
