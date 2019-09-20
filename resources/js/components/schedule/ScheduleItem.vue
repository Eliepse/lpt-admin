<template>
    <div class="schedule" :class="[{ 'schedule-active' : schedule.active }, background]">
        <div class="schedule-body">
            <!--<div class="schedule-studentCount">{{ schedule.subscriptions_count }}/{{ schedule.max_students }}</div>-->
            <div class="schedule-hour">{{ schedule.hour.format('HH:mm') }}</div>
            <div class="schedule-location">{{ schedule.office.name }} <small>{{ schedule.room }}</small></div>
        </div>
    </div>
</template>

<script>
    import dayjs from 'dayjs'

    export default {
        name: "ScheduleItem",
        props: {
            schedule: {
                type: Object,
                required: true
            }
        },
        data: function () {
            return {
                dayjs: dayjs,
                active: false
            }
        },
        computed: {
            background() {
                if (this.schedule.study.start.isAfter(dayjs()))
                    return 'popSchedule-bgSoon'
                else if (this.schedule.study.end.isAfter(dayjs()))
                    return 'popSchedule-bgCurrent'
                else
                    return 'popSchedule-bgEnded'
            }
        },
        mounted: function () {
            this.schedule.$instance = this
            this.schedule.$el = this.$el
        }
    }
</script>

<style scoped>

</style>
