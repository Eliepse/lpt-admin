<!--suppress HtmlUnknownTag -->
<template>
    <div class="modal sidebar-modal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="mySmallModalLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-sm">

            <loader ref="loader"/>

            <div class="modal-content">

                <div class="modal-body" v-if="schedule">
                    <form class="form">

                        <div class="form-group">
                            <label for="selectDay">Jour de cours</label>
                            <select class="form-control" id="selectDay" v-model="schedule.day" @change="updateSchedule">
                                <option v-for="day in days.long" :value="day">{{ day }}</option>
                            </select>
                        </div>

                        <!-- TODO(eliepse): add location (waiting for global settings) -->

                        <div class="form-group">
                            <label>Heure de début</label>
                            <input class="form-control" type="time" v-model="buffer.hour" @change="updateSchedule" step="60">
                        </div>

                        <div class="form-group">
                            <label>Période de cours</label>
                            <v-date-picker mode="range" v-model="buffer.study" is-required
                                           :select-attribute="selectDragAttribute"
                                           :drag-attribute="selectDragAttribute"
                                           @input="updateSchedule"
                                           @drag="dragValue = $event"
                            >
                                <div slot="day-popover" slot-scope="{format}">
                                    {{ dragValue ? Math.round(dayjs(dragValue.end).diff(dayjs(dragValue.start), "day") / 7) : 0 }} semaines
                                </div>
                            </v-date-picker>
                        </div>

                        <div class="form-group">
                            <label>Période d'inscription</label>
                            <v-date-picker mode="range" v-model="buffer.signup"
                                           :select-attribute="selectDragAttribute"
                                           :drag-attribute="selectDragAttribute"
                                           @input="updateSchedule"
                                           @drag="dragValue = $event"
                            >
                                <div slot="day-popover" slot-scope="{format}">
                                    {{ dragValue ? Math.round(dayjs(dragValue.end).diff(dayjs(dragValue.start), "day") / 7) : 0 }} semaines
                                </div>
                            </v-date-picker>
                        </div>

                        <div class="form-group">
                            <label for="maxStudents">Effectif maximum</label>
                            <input class="form-control" id="maxStudents" type="number"
                                   v-model="schedule.max_students"
                                   @change="updateSchedule">
                        </div>

                        <div class="form-group">
                            <label>Prix (en €)</label>
                            <input class="form-control" type="number" v-model="schedule.price"
                                   min="0" max="65000" @change="updateSchedule">
                        </div>

<!--                        <div class="form-group">-->
<!--                            <label>Enseignants</label>-->
<!--                            <div class="form-check" v-for="teacher in teachers">-->
<!--                                <input class="form-check-input" type="checkbox" @change="updateSchedule"-->
<!--                                       :value="teacher.id" :id="'t-' + teacher.id"-->
<!--                                       v-model="buffer.teachers">-->
<!--                                <label class="form-check-label" :for="'t-' + teacher.id">-->
<!--                                    {{ teacher.lastname }} {{ teacher.firstname }}-->
<!--                                </label>-->
<!--                            </div>-->
<!--                        </div>-->

                    </form>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-sm btn-link" @click="cancel">Annuler</button>
                    <button type="button" class="btn btn-sm btn-primary" @click="submit">Enregistrer</button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import Loader from '../Loader'
    import dayjs from 'dayjs'

    export default {
        name: "schedule-modal",
        components: {
            Loader
        },
        data: function () {
            return {
                submitting: false,
                schedule: undefined,
                scheduleBackup: {},
                dragValue: null,
                days: {
                    long: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
                    short: ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun']
                },
                buffer: {
                    study: {start: null, end: null,},
                    signup: {start: null, end: null,},
                    hour: null,
                    //teachers: []
                },
                //teachers: [],
                dayjs: dayjs
            }
        },
        computed: {
            selectDragAttribute: function () {
                return {
                    popover: {
                        visibility: 'hover',
                        isInteractive: false,
                    },
                };
            },
        },
        mounted: function () {
            $('.modal').on('hide.bs.modal', this.cancel)

            //this.$refs.loader.open('Chargement des enseignants...')
            //
            //axios.get('/staff', {params: {'has_role': ['teacher']}})
            //    .catch(response => {
            //        this.$refs.loader.open('Failed to load teachers', 'error')
            //    })
            //    .then(response => {
            //        this.teachers = response.data
            //        this.$refs.loader.close()
            //    })
        },
        methods: {
            open: function (schedule) {
                this.schedule = schedule
                this.schedule.active = true

                this.copyScheduleProperties(this.schedule, this.scheduleBackup)

                // Prepare the form by hydrating the buffer
                this.buffer.study.start = schedule.study.start ? schedule.study.start.toDate() : null
                this.buffer.study.end = schedule.study.end ? schedule.study.end.toDate() : null
                this.buffer.signup.start = schedule.signup.start ? schedule.signup.start.toDate() : null
                this.buffer.signup.end = schedule.signup.end ? schedule.signup.end.toDate() : null
                this.buffer.hour = schedule.hour.format("HH:mm")
                //this.buffer.teachers = schedule.teachers.reduce((acc, teacher) => {
                //    acc.push(teacher.id)
                //    return acc
                //}, [])

                this.$nextTick(() => {
                    $('.modal').modal('show')
                })
            },

            close: function () {

                if (!this.submitting)
                    this.cancel()

                this.schedule.active = false

                $('.modal').modal('hide')

                this.schedule = undefined
                this.scheduleBackup = {}
            },

            cancel: function () {
                this.copyScheduleProperties(this.scheduleBackup, this.schedule)
            },

            submit: function () {
                if (this.submitting)
                    return

                this.submitting = true
                this.$refs.loader.open("Envoi des données...")

                let data = {
                    day: this.schedule.day,
                    hour: this.schedule.hour.format('HH:mm'),
                    price: this.schedule.price,
                    max_students: this.schedule.max_students,
                    //teachers: this.schedule.teachers.reduce((acc, el) => {
                    //    acc.push(el.id);
                    //    return acc
                    //}, []),
                    start_at: this.schedule.study.start.format('YYYY-MM-DD'),
                    end_at: this.schedule.study.end.format('YYYY-MM-DD'),
                    signup_start_at: this.schedule.signup.start ? this.schedule.signup.start.format('YYYY-MM-DD') : null,
                    signup_end_at: this.schedule.signup.end ? this.schedule.signup.end.format('YYYY-MM-DD') : null,
                }

                axios.put('/schedules/' + this.schedule.id, data)
                    .catch(response => {
                        this.$refs.loader.setMessage("Erreur", "error")
                        setTimeout(this.$refs.loader.close, 1500)
                        this.submitting = false
                    })
                    .then(response => {
                        this.$refs.loader.setMessage(response.data['alerts'][0].message)
                        setTimeout(() => {
                            this.$refs.loader.close()
                            this.close()
                            this.submitting = false
                        }, 1500)
                    })
            },

            updateSchedule: function () {
                this.schedule.study.start = dayjs(this.buffer.study.start)
                this.schedule.study.end = dayjs(this.buffer.study.end)

                this.schedule.signup.start = this.buffer.signup.start ?
                    dayjs(this.buffer.signup.start) : undefined
                this.schedule.signup.end = this.buffer.signup.end ?
                    dayjs(this.buffer.signup.end) : undefined

                this.schedule.hour = dayjs(this.buffer.hour, "HH:mm")

                //this.schedule.teachers = this.buffer.teachers.reduce((acc, input_id) => {
                //    acc.push(this.teachers.find((teacher) => input_id === teacher.id))
                //    return acc
                //}, [])

                //this.schedule.$instance.$forceUpdate()
                this.$parent.$forceUpdate()
            },

            copyScheduleProperties: function (schedule, to) {
                to.study = {}
                to.study.start = schedule.study.start.clone()
                to.study.end = schedule.study.end.clone()

                to.signup = {}
                to.signup.start = schedule.signup.start ? schedule.signup.start.clone() : null
                to.signup.end = schedule.signup.end ? schedule.signup.end.clone() : null

                to.hour = schedule.hour.clone()
                to.day = schedule.day
                to.status = schedule.status
                to.max_students = schedule.max_students

                //to.teachers = schedule.teachers
            }
        }
    }
</script>

<style type="text/scss" scoped>
</style>