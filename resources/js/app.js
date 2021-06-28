require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './Pages/Home';


// Register Vue Components
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.filter('string', function (value) {
    if (typeof value == 'object') {
        return value.join(", ");
    } else {
        return value;
    }
})
// Vue.use(VueRouter);
export const bus = new Vue();
// Initialize Vue
const app = new Vue({
    el: '#app',
    render: h => h(Home)
});