import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../views/UserPage.vue';
import AdminDashboard from '../views/AdminDashboard.vue';
import Home from '../views/Home.vue';
import PostPage from '../views/PostPage.vue';

const routes = [
  { path: '/users', component: HomePage },
  { path: '/admin', component: AdminDashboard },
  { path: '/home', component: Home },
  { path: '/', redirect: '/posts' },
  { path: '/posts', component: PostPage },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
