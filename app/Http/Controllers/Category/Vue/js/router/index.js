
import admin from '../pages/admin.vue'
import categories from '../pages/category.vue'
import edit from '../pages/edit.vue'
import twitter from '../pages/twitter.vue'


const routes = [
    {path : '/admin', component: admin, name: 'admin'},
    {path : '/categories', component: categories, name: 'categories'},
    {path : '/profile', component: edit, name: 'edit'},
    {path : '/twitter', component: twitter, name: 'twitter'}

]

export default routes
