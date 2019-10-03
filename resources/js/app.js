/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import customParseFormat from "dayjs/plugin/customParseFormat";
import VCalendar from "v-calendar";
import DatePeriodInput from "./components/DatePeriodInput";
import Loader from "./components/Loader";
import CourseForm from "./components/CourseForm";
import ScheduleCalendar from "./components/schedule/ScheduleCalendar";
import List from "list.js";
import xray from "x-ray";

//import feather from "feather-icons";

require("./bootstrap");

window.dayjs = require("dayjs");
window.dayjs.extend(customParseFormat);
window.Vue = require("vue");

Vue.use(VCalendar, {firstDayOfWeek: 2});

Vue.use(window.dayjs);

//Vue.component("course-form", function (resolve) {
//    require(["./components/CourseForm"], resolve);
//});
//
//Vue.component("schedule-calendar", function (resolve) {
//    require(["./components/schedule/ScheduleCalendar"], resolve);
//});

const app = new Vue({
    el: "#app",
    components: {
        DatePeriodInput,
        CourseForm,
        ScheduleCalendar,
        Loader
    }
});

xray.init();

// Initialize list.js in the page (only one instance)
if (document.querySelector(".listjs")) {
    let listEl = document.querySelector(".listjs");
    new List(listEl.closest(".listjs-container"), {
        valueNames: listEl.dataset.names.split(",")
    });
}

//feather.replace();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//const files = require.context('./', true, /\.vue$/i);
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
