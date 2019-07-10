<!-- TODO(eliepse): comment this code -->
<!-- TODO(eliepse): split this code -->
<!-- TODO(eliepse): loader as component -->

<template>
    <div class="row">

        <div class="col-4 panel-side border-right" v-bind:class="{ 'overflow-hidden': loading }">
            <loader :active="loading"></loader>

            <div class="lessonList mt-2" v-bind:class="{'d-none' : editingLesson}">
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

            <div class="lessonEditor" v-bind:class="{'d-none' : !editingLesson}" v-if="editLesson">
                <div class="form-group mt-3">
                    <label for="teacherSelect">Enseignant</label>
                    <select id="teacherSelect" class="form-control" v-model="editingLesson.teacher_id">
                        <option value="">Aucun</option>
                        <option v-for="teacher in teachers" :value="teacher.id">
                            {{ teacher.lastname + ' ' + teacher.firstname }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Durée de la leçon</label>
                    <div class="input-group mb-3">
                        <input type="number" min="0" max="65000" class="form-control text-right"
                               placeholder="Durée de la leçon" aria-label="Lesson's duration"
                               aria-describedby="duration-addon2" v-model.number="editingLesson.duration">
                        <div class="input-group-append">
                            <span class="input-group-text" id="duration-addon2">min</span>
                        </div>
                    </div>
                </div>
                <div class="">
                    <button class="btn btn-secondary" v-on:click="closeEditor()">Fermer</button>
                </div>
            </div>
        </div>

        <main class="flex-fill">
            <form v-on:submit.prevent="save()">
                <div class="container">
                    <loader :active="loading"></loader>

                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="classroomName">Nom de la classe</label>
                                <input type="text" class="form-control" v-bind:class="{'is-invalid' : errors.name}"
                                       v-on:change="errors.name = undefined"
                                       id="classroomName"
                                       aria-describedby="nameHelp"
                                       placeholder="Utilisez un nom qui decrit bien le contenu de cette classe"
                                       v-model="classroom.name">
                                <small id="nameHelp" class="form-text text-muted">
                                    Le nom de la classe sera également affiché aux parents (lors de l'inscription par exemple)
                                </small>
                                <div class="invalid-feedback" v-for="message in errors.name">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                        <div class="card-table">
                            <table class="table table-hover" v-bind:class="{'table-danger' : errors.lessons}">
                                <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Enseignant</th>
                                    <th>Durée</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="lesson in this.classroom.lessons" v-bind:class="{'border-left border-info' : editingLesson.id === lesson.id}">
                                    <td>{{ lesson.name }}</td>
                                    <td>{{ printTeacher(lesson.teacher_id) }}</td>
                                    <td>{{ minToHuman(lesson.duration) }}</td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-icon btn-sm" v-on:click="editLesson(lesson)">
                                            <i class="fe fe-edit-2"></i>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-sm" v-on:click="removeLesson(lesson)">
                                            <i class="fe fe-x"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ minToHuman(totalDuration) }}</td>
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
    import Loader from '../Loader'

    export default {
        name: "classroom-create",
        components: {
            Loader
        },
        data: function () {
            return {
                classroom: {
                    name: '',
                    lessons: []
                },
                lessons: [],
                teachers: [],
                loading: true,
                saving: false,
                editingLesson: false,
                errors: {}
            }
        },
        computed: {
            totalDuration: function () {
                return this.classroom.lessons.reduce((acc, lesson) => {
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
            axios.all([
                axios.get('/lessons'),
                axios.get('/staff', {
                    params: {
                        fields: ['id', 'firstname', 'lastname', 'roles'],
                        has_role: ['teacher']
                    }
                }),])
                .then(axios.spread((lessonsReq, StaffReq) => {
                    this.lessons = lessonsReq.data
                    this.teachers = StaffReq.data
                    this.loading = false
                }))
        },
        methods: {
            addLesson: function (lesson) {
                let new_lesson = {
                    id: lesson.id,
                    name: lesson.name,
                    category: lesson.category,
                    teacher_id: undefined,
                    duration: 30
                }
                this.classroom.lessons.push(new_lesson)
                this.editLesson(new_lesson)
            },
            editLesson: function (lesson) {
                this.editingLesson = lesson
                this.errors.lessons = undefined
            },
            removeLesson: function (lesson) {
                this.classroom.lessons = this.classroom.lessons.filter((el) => {
                    return lesson.id !== el.id
                })

                // Close the editor when deleting the edited element
                if (this.editingLesson.id === lesson.id)
                    this.closeEditor()

                this.errors.lessons = undefined
            },
            printTeacher: function (id) {
                let teacher = this.teachers.find(function (el) { return id === el.id })
                return teacher ? teacher.lastname + ' ' + teacher.firstname : ''
            },
            minToHuman: function (time) {
                return Math.floor(time / 60) + ' h ' + (time % 60) + ' min'
            },
            closeEditor: function () {
                this.editingLesson = false
            },
            save: function () {
                if (this.saving)
                    return

                this.loading = true
                this.saving = true
                axios.post('/classrooms', this.classroom)
                    .then((response) => {
                        window.location = response.data.redirect
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors
                        this.loading = false
                        this.saving = false
                        // TODO(eliepse): manage errors in general (specific treatment for 422, print error message for others)
                    })
            }
        }
    }
</script>

<style type="text/scss" scoped>
    /*.actionBar {*/
    /*position: absolute;*/
    /*bottom: 0;*/
    /*height: 3.5rem;*/
    /*width: 100%;*/
    /*overflow: hidden;*/
    /*}*/

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