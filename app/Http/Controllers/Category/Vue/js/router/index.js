
import admin from '../pages/admin.vue'
import categories from '../pages/category.vue'
import subcategories from '../pages/subcategory.vue'
import subSubcategories from '../pages/subSubcategory.vue'
import information from '../pages/information.vue'
import edit from '../pages/edit.vue'


const routes = [
    {path : '/admin', component: admin, name: 'admin'},
    {path : '/categories', component: categories, name: 'categories'},
    {path : '/subcategories', component: subcategories, name: 'subcategories'},
    {path : '/sub-subcategories', component: subSubcategories, name: 'sub-subcategories'},
    {path : '/information', component: information, name: 'information'},
    {path : '/profile', component: edit, name: 'edit'},

]

export default routes
