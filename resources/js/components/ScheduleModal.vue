<!--suppress HtmlUnknownTag -->
<template>
    <div class="modal sidebar-modal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="mySmallModalLabel"
         aria-hidden="true"
    >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-body" v-if="schedule">
                    <form class="form">

                        <div class="form-group">
                            <label for="selectDay">Jour de cours</label>
                            <select class="form-control" id="selectDay" v-model="schedule.day">
                                <option v-for="day in days.long" :value="day">{{ day }}</option>
                            </select>
                        </div>

                        <!-- TODO(eliepse): add location (waiting for global settings) -->

                        <div class="form-group">
                            <label>Heure de début</label>
                            <input class="form-control" type="time" v-model="bufferValues.hour" @change="updateSchedule" step="60">
                        </div>

                        <div class="form-group">
                            <label>Période de cours</label>
                            <v-date-picker mode="range" v-model="bufferValues.study" is-required
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
                            <v-date-picker mode="range" v-model="bufferValues.signup"
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
                            <label>Effectif maximum</label>
                            <input class="form-control" type="number" v-model="schedule.max_students" @change="updateSchedule">
                        </div>

                        <div class="form-group">
                            <label>Prix (en €)</label>
                            <input class="form-control" type="number" v-model="schedule.price"
                                   min="0" max="65000" @change="updateSchedule">
                        </div>

                    </form>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-sm btn-link" @click="cancel()">Annuler</button>
                    <button type="button" class="btn btn-sm btn-primary" @click="submit()">Enregistrer</button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "schedule-modal",
        data: function () {
            return {
                schedule: undefined,
                scheduleBackup: {},
                dragValue: null,
                days: {
                    long: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
                    short: ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun']
                },
                bufferValues: {
                    study: {
                        start: null,
                        end: null,
                    },
                    signup: {
                        start: null,
                        end: null,
                    },
                    hour: null
                },
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
            // TODO(eliepse): handle modal events (to cancel automatically)
        },
        methods: {

            open: function (schedule) {
                //this.cancel()

                this.schedule = schedule
                this.schedule.active = true

                this.copyScheduleProperties(this.schedule, this.scheduleBackup)

                this.bufferValues.study.start = this.schedule.study.start.toDate()
                this.bufferValues.study.end = this.schedule.study.end.toDate()
                this.bufferValues.signup.start = this.schedule.signup.start.toDate()
                this.bufferValues.signup.end = this.schedule.signup.end.toDate()
                this.bufferValues.hour = this.schedule.hour.format("HH:mm")

                this.$nextTick(() => {

                    $('.modal').modal('show')

                })

            },

            close: function () {
                this.schedule.active = false
                $('.modal').modal('hide')

                this.schedule = undefined
            },

            cancel: function () {
                this.copyScheduleProperties(this.scheduleBackup, this.schedule)
                this.close()
            },

            submit: function () {
                // TODO(eliepse): ajax submit data
            },

            updateSchedule: function () {
                this.schedule.study.start = dayjs(this.bufferValues.study.start)
                this.schedule.study.end = dayjs(this.bufferValues.study.end)
                this.schedule.hour = dayjs(this.bufferValues.hour, "HH:mm")

                this.schedule.$instance.$forceUpdate()
            },

            copyScheduleProperties: function (schedule, to) {
                to.study = {
                    start: schedule.study.start.clone(),
                    end: schedule.study.end.clone()
                }

                to.signup = {
                    start: schedule.signup.start.clone(),
                    end: schedule.signup.end.clone()
                }

                to.hour = schedule.hour.clone()
                to.day = schedule.day
                to.status = schedule.status
                to.max_students = schedule.max_students
            }

        }
    }
</script>

<style scoped>

</style>