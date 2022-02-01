
import admin from '../pages/admin.vue'
import categories from '../pages/category.vue'
import edit from '../pages/edit.vue'
import twitter from '../pages/twitter.vue'


const routes = [
    {path : '/users', component: admin, name: 'users'},
    {path : '/twitter_users', component: categories, name: 'twitter_users'},
    { path: '/', component: twitter, name: 'twitter'},
    {path : '/profile', component: edit, name: 'edit'},
    {path : '/twitter', component: twitter, name: 'twitter'}

]

export default routes
