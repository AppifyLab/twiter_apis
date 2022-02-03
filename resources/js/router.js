import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import register from './components/auth/register'
import twitterUsers from './pages/twitter_users'
import edit from './pages/edit.vue'
import twitter from './pages/twitter.vue'

// import categories from '../../app/Http/Controllers/Category/Vue/js/router'
 const mainRoutes = [
    { path: '/register', component: register, name: 'register'},
    {path : '/twitter_users', component: twitterUsers, name: 'twitter_users'},
    {path : '/twitter', component: twitter, name: 'twitter'},
    {path : '/profile', component: edit, name: 'edit'},
    { path: '/', component: twitter, name: 'twitter'},
    
]

var routes = []
routes = routes.concat(
    mainRoutes,
)


export default new VueRouter({

	mode: 'history',
	routes,
})





