require('./bootstrap');

window.Vue = require('vue');

Vue.component('homepage', require('./components/Homepage.vue').default);
Vue.component('chart-temperature', require('./components/ChartTemperature.vue').default);

const app = new Vue({
    el: '#app',
});
