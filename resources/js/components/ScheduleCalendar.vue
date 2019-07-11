<template>
    <div class="card mt-3 mb-5">
        <div class="row no-gutters">
            <div class="col day" v-for="(day, key) in days.long">
                <div class="day-header">{{ day }}</div>
                <div class="day-body">
                    <div class="schedule" v-for="schedule in schedulesOn(day)">
                        <!--<div class="schedule-studentCount">{{ schedule.students_count }}/{{ schedule.max_students }}</div>-->
                        <div class="schedule-hour">{{ schedule.hour.substring(0, 5) }}</div>
                        <div class="schedule-location">{{ schedule.location }}</div>
                    </div>
                </div>
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
            }
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
            console.log(this.schedules[0])
        },
        methods: {
            schedulesOn: function (day) {
                return this.schedules.filter((schedule) => {
                    return schedule.day === day
                })
            }
        }
    }
</script>

<style scoped>
    /*.card {*/
    /*box-shadow: 0 5px 8px rgba(0, 0, 0, 0.1);*/
    /*}*/

    .day {
        min-height: 15rem;
    }


    .day:nth-child(-n + 6) {
        border-right: 1px solid #edf2f7;
    }


    .day-header {
        padding: 1rem;
        background-color: #edf2f7;
        font-size: .75em;
        font-weight: bold;
        text-transform: uppercase;
        text-align: center;
        color: #a0aec0;
    }


    .schedule {
        font-size: .875em;
        min-height: 3rem;
        margin: .3rem;
        padding: .3rem .5rem;
        color: #718096;
        background-color: #bee3f8;
        border-radius: 10px;
        cursor: pointer;
    }


    .schedule:hover {
        background-color: #90cdf4;
    }


    .schedule-hour {
        font-weight: bold;
    }


    .schedule-location {
        text-transform: capitalize;
    }


    .schedule-studentCount {
        float: right;
    }

</style>