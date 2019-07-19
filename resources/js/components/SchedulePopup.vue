<template>
    <div class="schedule-popup">

        <div v-if="schedule">
            <div class="popSchedule-header">
                <div class="popSchedule-location">{{ schedule.location }}</div>
                <div class="popSchedule-hour">
                    <span class="popSchedule-day">{{ schedule.day.substring(0, 3) }}</span>
                    {{ schedule.hour.format("HH:mm") }} - {{ schedule.hour.add(classroomDuration, "minute").format("HH:mm") }}
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-icon btn-sm" @click="mode = 'edit'">
                        <i class="fe fe-edit"></i> Edit
                    </button>
                    <button type="button" class="btn btn-icon btn-sm" @click="close()">
                        <i class="fe fe-x"></i> Close
                    </button>
                </div>
            </div>

            <div class="popSchedule-body">
                <div class="mb-3 popSchedule-period">
                    <span>{{ Math.round(schedule.end_at.diff(schedule.start_at, "day") / 7) }} semaines</span><br/>
                    {{ schedule.start_at.format("YYYY-MM-DD") }} - {{ schedule.end_at.format("YYYY-MM-DD") }}
                </div>
                <div class="mb-3">
                    <div class>
                        {{ schedule.students_count }}/{{ schedule.max_students }} étudiants
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

            <div class="popSchedule-footer" :class="[getBackground(schedule.status)]">
                <div v-if="schedule.status === 1">
                    Début dans {{ schedule.start_at.diff(dayjs(), "day") }} jours
                </div>
                <div v-else-if="schedule.status === 0">En cours</div>
                <div v-else>Terminé</div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "schedule-popup",
        props: {
            classroomDuration: {
                type: Number,
                required: true
            }
        },
        data: function () {
            return {
                mode: '',
                schedule: undefined,
                position: {x: 0, y: 0},
                dayjs: dayjs
            };
        },
        methods: {
            toggle: function (schedule) {
                if (this.schedule === schedule) {
                    this.close()
                    return
                }

                this.open(schedule)
            },
            open: function (schedule, mode = 'show') {

                this.schedule = schedule
                schedule.active = true
                this.mode = mode

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
                this.$el.style.opacity = 0

                setTimeout(() => {
                    this.schedule.active = false
                    this.schedule = undefined
                    this.mode = ''

                    this.$emit('closed')
                }, 200)


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
    };
</script>

<style scoped>
</style>