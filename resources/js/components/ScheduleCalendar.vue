<!-- TODO(eliepse): add teachers on schedules details -->

<template>
    <div class="row mt-3 mb-5">

        <div class="col">
            <div class="card">
                <div class="row no-gutters">
                    <div class="col day" v-for="(day, key) in days.long">
                        <div class="day-header">{{ day }}</div>
                        <div class="day-body">
                            <div class="schedule"
                                 :class="[{ 'schedule-active' : schedule === activeSchedule }, getBackground(schedule.status)]"
                                 v-for="schedule in schedulesByDay(day)" v-bind:key="schedule.id" ref="schedules"
                                 :data-id="schedule.id" @click="show(schedule)">
                                <!--<div class="schedule-studentCount">{{ schedule.students_count }}/{{ schedule.max_students }}</div>-->
                                <div class="schedule-hour">{{ schedule.hour.format('HH:mm') }}</div>
                                <div class="schedule-location">{{ schedule.location }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <schedule-popup ref="popup"
                        :classroomDuration="classroomDuration"
                        v-on:opened="(s) => {this.activeSchedule = s}"
                        v-on:closed="activeSchedule = undefined"
        />

    </div>
</template>

<script>
    import SchedulePopup from './schedulePopup'

    export default {
        name: "schedule-calendar",
        components: {
            SchedulePopup
        },
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
                activeSchedule: undefined
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
            //cast schedules properties
            this.schedules.forEach((schedule) => {
                schedule.start_at = dayjs(schedule.start_at)
                schedule.end_at = dayjs(schedule.end_at)
                schedule.hour = dayjs(schedule.hour, 'HH:mm:ss')
                schedule.signup_end_at = dayjs(schedule.signup_end_at)
                schedule.signup_start_at = dayjs(schedule.signup_start_at)
                schedule.active = false

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
            show: function (schedule) {
                this.$refs.popup.toggle(schedule)
            },
            // Get schedules on a specific day
            schedulesByDay: function (day) {
                return this.schedules.filter((schedule) => {
                    return schedule.day === day
                })
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