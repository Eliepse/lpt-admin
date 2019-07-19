/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import daysjs from 'dayjs'
import customParseFormat from 'dayjs/plugin/customParseFormat'

require('./bootstrap')

window.dayjs = require('dayjs')
dayjs.extend(customParseFormat)

if (document.querySelector('#app')) {
    require(['vue'], function (Vue) {

        window.Vue = require('vue')

        Vue.use(daysjs);

        Vue.component('classroom-form', function (resolve) {
            require(['./components/ClassroomForm'], resolve)
        })

        Vue.component('schedule-calendar', function (resolve) {
            require(['./components/ScheduleCalendar'], resolve)
        })

        const app = new Vue({
            el: '#app',
        })

    })
}


//window.List = require('list.js')

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//const files = require.context('./', true, /\.vue$/i);
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));