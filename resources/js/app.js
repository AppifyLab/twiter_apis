require('./bootstrap');
import Vue from 'vue';

Vue.config.productionTip=false;

// Vue.component('header-section', require('./components/inc/header.vue').default);
// Vue.component('sidebar-section', require('./components/inc/sidebar.vue').default);
Vue.component('main-content', require('./components/master.vue').default);
// Vue.component('footer-section', require('./components/inc/footer.vue').default);


//iview-start
import ViewUI from 'view-design';
import locale from 'view-design/dist/locale/en-US'
Vue.use(ViewUI, { locale });
//iview-end

//commons api, alert-start
import common from './common';
Vue.mixin(common);
//commons api, alert-start

//store vuex -start
import store from './store'
//store vuex -end

//vue router -start
import router from './router';
//vue router -end

const app = new Vue({
    el: '#app',
    router,
    store
});
