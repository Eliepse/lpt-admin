<!-- TODO(eliepse): add teachers on schedules details -->

<template>
    <div class="row mt-3 mb-5">
        <div class="col" v-bind:class="">
            <div class="card">
                <div class="row no-gutters">
                    <div class="col day" v-for="(day, key) in days.long">
                        <div class="day-header">{{ day }}</div>
                        <div class="day-body">
                            <div class="schedule"
                                 :class="[{ 'schedule-active' : popSchedule === schedule }, getBackground(schedule.status)]"
                                 v-for="schedule in schedulesOn(day)" v-bind:key="schedule.id" ref="schedules"
                                 :data-id="schedule.id" @click="openPop(schedule)">
                                <!--<div class="schedule-studentCount">{{ schedule.students_count }}/{{ schedule.max_students }}</div>-->
                                <div class="schedule-hour">{{ schedule.hour.format('HH:mm') }}</div>
                                <div class="schedule-location">{{ schedule.location }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="schedule-popup" v-bind:class="{'schedule-popup-hide' : !popSchedule}" ref="schPop">
            <div class="popSchedule-header" v-if="popSchedule">
                <div class="popSchedule-location">{{ popSchedule.location }}</div>
                <div class="popSchedule-hour">
                    <span class="popSchedule-day">{{ popSchedule.day.substring(0, 3) }}</span>
                    {{ popSchedule.hour.format('HH:mm') }} - {{ popSchedule.hour.add(classroomDuration, 'minute').format('HH:mm') }}
                </div>
                <div class="mt-2">
                    <!--<button type="button" class="btn btn-icon btn-sm">-->
                    <!--<i class="fe fe-edit"></i> Edit-->
                    <!--</button>-->
                    <button type="button" class="btn btn-icon btn-sm" @click="closePop()">
                        <i class="fe fe-x"></i> Close
                    </button>
                </div>
            </div>
            <div class="popSchedule-body" v-if="popSchedule">
                <div class="mb-3 popSchedule-period">
                    <span>{{ Math.round(popSchedule.end_at.diff(popSchedule.start_at, 'day') / 7) }} semaines</span><br>
                    {{ popSchedule.start_at.format('YYYY-MM-DD') }} - {{ popSchedule.end_at.format('YYYY-MM-DD') }}
                </div>
                <div class="mb-2">
                    <div class="">{{ popSchedule.students_count }}/{{ popSchedule.max_students }} étudiants</div>
                </div>
            </div>
            <div class="popSchedule-footer"
                 :class="[getBackground(popSchedule.status)]"
                 v-if="popSchedule">
                <div v-if="popSchedule.status === 1">
                    Début dans {{ popSchedule.start_at.diff(dayjs(), 'day') }} jours
                </div>
                <div v-else-if="popSchedule.status === 0">En cours</div>
                <div v-else>Terminé</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "schedule-calendar",
        props: {
            schedules: {
                type: Array,
                required: true
            },
            classroom: {
                type: Object,
                required: true
            }
        },
        data: function () {
            return {
                days: {
                    long: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
                    short: ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun']
                },
                popSchedule: undefined,
                dayjs: dayjs
            }
        },
        computed: {
            // Calculate the duration of the classroom
            classroomDuration: function () {
                return this.classroom.lessons.reduce((acc, lesson) => {
                    return acc + lesson.pivot.duration
                }, 0)
            }
        },
        created: function () {
            // cast schedules properties
            this.schedules.forEach((schedule) => {
                schedule.start_at = dayjs(schedule.start_at)
                schedule.end_at = dayjs(schedule.end_at)
                schedule.hour = dayjs(schedule.hour, 'HH:mm:ss')
                schedule.signup_end_at = dayjs(schedule.signup_end_at)
                schedule.signup_start_at = dayjs(schedule.signup_start_at)

                // Current statut of the schedule
                if (schedule.start_at.isAfter(dayjs()))
                    schedule.status = 1 // In the future
                else if (schedule.end_at.isAfter(dayjs()))
                    schedule.status = 0 // Active
                else
                    schedule.status = -1 // In the past
            })
        },
        mounted: function () {
            // bind html element to schedules
            this.schedules.forEach((schedule) => {
                schedule.$el = this.$refs.schedules.find((el) => {
                    return parseInt(el.dataset.id) === schedule.id
                })
            })
        },
        methods: {
            // Get schedules on a specific day
            schedulesOn: function (day) {
                return this.schedules.filter((schedule) => {
                    return schedule.day === day
                })
            },
            // Open the schedule popup
            openPop: function (schedule) {
                // Toggle the popup when click on the opened schedule
                if (this.popSchedule === schedule) {
                    this.closePop()
                    return
                }

                // activate the popup
                this.popSchedule = schedule

                let popup = this.$refs.schPop
                let popupRect = popup.getBoundingClientRect()
                let scheduleRect = schedule.$el.getBoundingClientRect()

                // Y position according to the space around the schedule element
                popup.style.left = (popupRect.width > scheduleRect.left) ?
                    Math.round(scheduleRect.left + scheduleRect.width) + 'px'
                    : Math.round(scheduleRect.left - popupRect.width) + 'px'

                // X position according to the space around the schedule element
                popup.style.top = (popupRect.height > scheduleRect.top) ?
                    Math.round(scheduleRect.top + scheduleRect.height) + 'px'
                    : Math.round(scheduleRect.top - popupRect.height) + 'px'

            },
            // Close the popup schedule
            closePop: function () {
                // deactivate the popup
                this.popSchedule = undefined
                // reset popup position
                this.$refs.schPop.style.left = ''
                this.$refs.schPop.style.top = ''
            },
            getBackground: function (status) {
                switch (status) {
                    case 0:
                        return 'popSchedule-bgCurrent'
                    case 1:
                        return 'popSchedule-bgSoon'
                    default:
                        return 'popSchedule-bgEnded'
                }
            }
        }
    }
</script>

<style scoped>
</style>