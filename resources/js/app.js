require('./bootstrap');

window.Vue = require('vue');

//vue bootstrap
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

import vueNiceScrollbar from 'vue-nice-scrollbar'
Vue.use(vueNiceScrollbar)

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('index-page', require('./components/main_website.vue').default);


const app = new Vue({
    el: '#app',
});
