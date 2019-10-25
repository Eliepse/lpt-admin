<template>
    <div class="schedule-popup">

        <div v-if="schedule">
            <div class="popSchedule-header">
                <div class="popSchedule-location">{{ schedule.campus.location }}</div>
                <div class="popSchedule-hour">
                    <span class="popSchedule-day">
                        {{ schedule.day.substring(0, 3) }}</span>{{ schedule.hour.format("HH:mm") }}
                </div>
                <div class="">
                    {{ schedule.price }}&nbsp;€
                </div>
            </div>

            <div class="popSchedule-body">
                <div class="mb-3 popSchedule-period">
                    <span>{{ Math.round(schedule.study.end.diff(schedule.study.start, "day") / 7) }} semaines</span><br/>
                    {{ schedule.study.start.format("YYYY-MM-DD") }} - {{ schedule.study.end.format("YYYY-MM-DD") }}
                </div>
                <div class="mb-3">
                    <div class>
                        {{ schedule.subscriptions_count }}/{{ schedule.max_students }} étudiants
                    </div>
                </div>
                <div v-if="schedule.teachers.length">
                    <h6>Enseignants :</h6>
                    <ul class="pl-2 list-unstyled">
                        <li v-for="teacher in schedule.teachers">
                            {{ teacher.lastname }} {{ teacher.firstname }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="popSchedule-footer" :class="[background]">
                <div v-if="status === 1">
                    Début dans {{ schedule.study.start.diff(dayjs(), "day") }} jours
                </div>
                <div v-else-if="status === 0">En cours</div>
                <div v-else>Terminé</div>
            </div>
        </div>

    </div>
</template>

<script>
    import dayjs from 'dayjs'

    export default {
        name: "schedule-popup",
        data: function () {
            return {
                schedule: undefined,
                position: {x: 0, y: 0},
                closing: false,
                dayjs: dayjs
            };
        },
        computed: {

            status() {
                if (this.schedule.study.start.isAfter(dayjs()))
                    return 1
                else if (this.schedule.study.end.isAfter(dayjs()))
                    return 0
                else
                    return -1
            },

            background() {
                if (this.schedule.study.start.isAfter(dayjs()))
                    return 'popSchedule-bgSoon'
                else if (this.schedule.study.end.isAfter(dayjs()))
                    return 'popSchedule-bgCurrent'
                else
                    return 'popSchedule-bgEnded'
            }
        },
        methods: {
            toggle: function (schedule) {
                if (this.schedule === schedule) {
                    this.close()
                    return
                }

                this.open(schedule)
            },

            open: function (schedule) {

                this.schedule = schedule

                this.closing = false

                this.$nextTick(() => {

                    let popupRect = this.$el.getBoundingClientRect()
                    let scheduleRect = this.schedule.$el.getBoundingClientRect()

                    // Y position according to the space around the schedule element
                    this.$el.style.left = (popupRect.width > scheduleRect.left) ?
                        Math.round(scheduleRect.left + scheduleRect.width) + 'px'
                        : Math.round(scheduleRect.left - popupRect.width) + 'px'

                    // X position according to the space around the schedule element
                    this.$el.style.top = (popupRect.height > scheduleRect.top) ?
                        Math.round(scheduleRect.top + scheduleRect.height) + 'px'
                        : Math.round(scheduleRect.top - popupRect.height) + 'px'

                    this.$el.style.opacity = 1

                    this.$emit('opened', schedule)
                })

            },

            close: function () {
                this.closing = true

                this.$el.style.opacity = 0

                setTimeout(() => {
                    if (!this.closing)
                        return

                    this.schedule = undefined

                    this.$emit('closed')
                }, 200)

            },
        }
    };
</script>

<style scoped>
</style>
