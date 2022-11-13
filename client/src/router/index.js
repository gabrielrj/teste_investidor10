import {createRouter, createWebHistory} from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Dashboard from "@/views/Dashboard.vue";
import UserIndex from "@/views/users/Index.vue";
import ListNews from "@/views/news/Index.vue";
import CreateOrUpdateNews from "@/views/news/CreateOrEdit.vue";
import  NProgress  from 'nprogress/nprogress.js';
import 'nprogress/nprogress.css';
import Guard from "@/services/middleware";

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard
  },
  {
    path: '/users',
    name: 'Users',
    component: UserIndex
  },
  {
    path: '/news',
    name: 'News',
    component: ListNews
  },

  {
    path: '/news/create',
    name: 'NewsCreate',
    component: CreateOrUpdateNews
  },

  {
    path: '/news/edit/:id',
    name: 'NewsEdit',
    component: CreateOrUpdateNews
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeResolve((to, from, next) => {
  // If this isn't an initial page load.
  if (to.name) {
    // Start the route progress bar.
    NProgress.start()
  }

  if(to.name !== 'Login')
    Guard.verifyUserAuthenticated(to, from, next)

  next()
})

router.afterEach(() => {
  // Complete the animation of the route progress bar.
  NProgress.done()
})

export default router
