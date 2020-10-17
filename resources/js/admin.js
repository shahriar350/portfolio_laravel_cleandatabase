require('./bootstrap');

window.Vue = require('vue');
Vue.filter('first_cap', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})
//vue bootstrap
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

Vue.component('banner-page', require('./admin/banner').default);
Vue.component('cv-index-page', require('./admin/cv_index').default);
Vue.component('blog-page', require('./admin/blog').default);
Vue.component('user-page', require('./admin/user').default);


const app = new Vue({
    el: '#admin',
});
