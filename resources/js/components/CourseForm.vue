<!-- TODO(eliepse): comment this code -->

<template>
    <div class="row">

        <div class="col-4 panel-side border-right" v-bind:class="{ 'overflow-hidden': loading }">
            <loader :active="loading"></loader>
            <div class="lessonList mt-2">
                <ul class="p-0 mb-5 mt-3" v-for="(lessonGroup, key) in groupedLessons">
                    <h4 class="h-4 text-uppercase text-muted">{{ key }}</h4>
                    <li class="card lessonElement mb-3"
                        v-on:click="addLesson(lesson)"
                        v-for="lesson in lessonGroup">
                        <div class="card-body">
                            <div class="card-title">{{ lesson.name }}</div>
                            <p class="text-muted mb-0">{{ lesson.description }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <main class="col">
            <form v-on:submit.prevent="save()">
                <div class="container">
                    <loader :active="loading"></loader>
                    <div class="card mt-3 mb-3">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="courseName">Nom du cours</label>
                                <input type="text" class="form-control" v-bind:class="{'is-invalid' : errors.name}"
                                       v-on:change="errors.name = undefined"
                                       id="courseName"
                                       aria-describedby="nameHelp"
                                       placeholder="Utilisez un nom qui decrit bien le contenu de ce cours"
                                       v-model="course.name">
                                <small id="nameHelp" class="form-text text-muted">
                                    Le nom du cours sera également affiché aux parents (lors de l'inscription par exemple)
                                </small>
                                <div class="invalid-feedback" v-for="message in errors.name">
                                    {{ message }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="courseDescription">Description du cours</label>
                                <input type="text" class="form-control" v-bind:class="{'is-invalid' : errors.description}"
                                       v-on:change="errors.description = undefined"
                                       id="courseDescription"
                                       aria-describedby="descriptionHelp"
                                       placeholder="Décrivez ce que ce cours apporte aux étudiants qui y participent."
                                       v-model="course.description">
                                <small id="descriptionHelp" class="form-text text-muted">
                                    Le nom du cours sera également affiché aux parents (lors de l'inscription par exemple)
                                </small>
                                <div class="invalid-feedback" v-for="message in errors.description">
                                    {{ message }}
                                </div>
                            </div>

                        </div>
                        <div class="card-table">
                            <table class="table table-hover table-vcenter" v-bind:class="{'table-danger' : errors.lessons}">
                                <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th class="text-right">Durée</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="lesson in this.course.lessons">
                                    <td>
                                        <span class="text-uppercase text-muted" style="font-size: .75em">{{ lesson.category }}</span><br>
                                        {{ lesson.name }}
                                    </td>
                                    <td>
                                        <div class="input-group ml-auto" style="max-width: 15rem">
                                            <input type="number" min="0" max="65000" class="form-control text-right"
                                                   placeholder="Durée de la leçon" aria-label="Lesson's duration"
                                                   aria-describedby="duration-addon2" v-model.number="lesson.duration">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="duration-addon2">min</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-icon" v-on:click="removeLesson(lesson)">
                                            <i class="fe fe-trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td class="text-right">{{ minToHuman(totalDuration) }}</td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="invalid-feedback d-block" v-for="message in errors.lessons">
                                {{ message }}
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
            </form>
        </main>

    </div>
</template>

<script>
    import Loader from "./Loader";

    export default {
        name: "course-form",
        components: {
            Loader
        },
        props: {
            id: {
                type: Number,
                required: false
            }
        },
        data: function () {
            return {
                course: {
                    name: '',
                    description: '',
                    lessons: []
                },
                lessons: [],
                loading: true,
                saving: false,
                errors: {}
            }
        },
        computed: {
            totalDuration: function () {
                return this.course.lessons.reduce((acc, lesson) => {
                    return acc + lesson.duration
                }, 0)
            },
            groupedLessons: function () {
                return _.groupBy(this.lessons, function (lesson) {
                    return lesson.category
                })
            }
        },
        created: function () {
            let requests = []

            requests.push(axios.get('/admin/lessons'))

            if (this.id)
                requests.push(axios.get('/admin/courses/' + this.id))

            axios.all(requests)
                .then(axios.spread((lessonsReq, courseReq) => {
                    this.lessons = lessonsReq.data

                    if (courseReq && courseReq.status === 200) {
                        let course = courseReq.data
                        this.course.name = course.name
                        course.lessons.forEach((lesson) => {
                            this.course.lessons.push({
                                id: lesson.id,
                                name: lesson.name,
                                category: lesson.category,
                                duration: lesson.pivot.duration
                            })
                        })
                    }

                    this.loading = false
                }))
        },
        methods: {
            addLesson: function (lesson) {
                let new_lesson = {
                    id: lesson.id,
                    name: lesson.name,
                    category: lesson.category,
                    duration: 30
                }
                this.course.lessons.push(new_lesson)
            },
            removeLesson: function (lesson) {
                this.course.lessons = this.course.lessons.filter((el) => {
                    return lesson.id !== el.id
                })
                this.errors.lessons = undefined
            },
            minToHuman: function (time) {
                let seconds = time % 60
                return Math.floor(time / 60) + ' h ' + (seconds < 10 ? '0' + seconds : seconds) + ' min'
            },
            save: function () {
                if (this.saving)
                    return

                this.loading = true
                this.saving = true

                axios({
                    method: this.id ? 'put' : 'post',
                    url: this.id ? '/admin/courses/' + this.id : '/admin/courses',
                    data: this.course
                })
                    .then((response) => {
                        window.location = response.data.redirect
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || []
                        this.loading = false
                        this.saving = false
                        // TODO(eliepse): manage errors in general (specific treatment for 422, print error message for others)
                    })
            }
        }
    }
</script>

<style type="text/scss" scoped>
    .lessonEditor {
        z-index: 50;
    }


    .lessonElement {
        cursor: pointer;
        box-shadow: rgba(0, 0, 0, 0.2) 0px 2px 2px;
        transition: box-shadow .2s;
    }


    .lessonElement:hover {
        box-shadow: rgba(0, 0, 0, 0.12) 0px 5px 6px;
    }
</style>
