<!-- TODO(eliepse): add teachers on schedules details -->

<template>
    <div class="row mt-3 mb-5">

        <div class="col">
            <div class="card">
                <div class="row no-gutters">
                    <div class="col day" v-for="(day, key) in days.long">
                        <div class="day-header">{{ day }}</div>
                        <div class="day-body">
                            <schedule-item
                                    v-for="(schedule, key) in schedulesByDay(day)"
                                    :key="key"
                                    ref="schedules"
                                    :schedule="schedule"
                                    @mouseenter.native="show(schedule)"
                                    @mouseleave.native="hide(schedule)"
                                    @click.native="edit(schedule)"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <schedule-popup ref="popup"/>
        <schedule-modal ref="modal"></schedule-modal>
        <loader ref="loader"/>

    </div>
</template>

<script>
    import ScheduleItem from './ScheduleItem'
    import SchedulePopup from './SchedulePopup'
    import ScheduleModal from './ScheduleModal'
    import Loader from '../Loader'

    export default {
        name: "schedule-calendar",
        components: {
            ScheduleModal,
            ScheduleItem,
            SchedulePopup,
            Loader
        },
        props: {
            schedules: {
                type: Array,
                required: true
            },
        },
        data: function () {
            return {
                days: {
                    long: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
                    short: ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun']
                }
            }
        },
        created: function () {
            console.log(this.schedules)
            this.schedules.forEach((schedule) => {

                this.$set(schedule, 'active', false)

                schedule.hour = dayjs(schedule.hour)

                this.$set(schedule, 'study', {})
                this.$set(schedule.study, 'start', dayjs(schedule.start_at))
                this.$set(schedule.study, 'end', dayjs(schedule.end_at))

                this.$set(schedule, 'signup', {})
                this.$set(schedule.signup, 'start', schedule.signup_start_at ? dayjs(schedule.signup_start_at) : undefined)
                this.$set(schedule.signup, 'end', schedule.signup_end_at ? dayjs(schedule.signup_end_at) : undefined)

            })
        },
        methods: {
            show: function (schedule) {
                this.$refs.popup.open(schedule)
            },

            hide: function () {
                this.$refs.popup.close()
            },

            edit: function (schedule) {
                this.$refs.modal.open(schedule)
            },

            // Get schedules on a specific day
            schedulesByDay: function (day) {
                return this.schedules.filter((schedule) => {
                    return schedule.day === day
                })
            }
        }
    }
</script>

<style scoped>
</style>