<template>
    <div>
        <v-date-picker
                mode="range"
                v-model="range"
                :is-required="required"
                :select-attribute="selectDragAttribute"
                :drag-attribute="selectDragAttribute"
                :input-props="{
                    disabled: true,
                    placeholder: placeholder,
                    class: 'form-control ' + classes.join(' ')
                }"
                @drag="dragValue = $event"
        >
            <div slot="day-popover" slot-scope="{format}">
                {{ dragValue ? Math.round(dayjs(dragValue.end).diff(dayjs(dragValue.start), "day") / 7) : 0 }} semaines
            </div>
        </v-date-picker>

        <input type="hidden" :name="names[0]" :required="required" v-model="range.start"/>
        <input type="hidden" :name="names[1]" :required="required" v-model="range.end"/>
    </div>
</template>

<script>
    import dayjs from 'dayjs'

    export default {
        name: "date-period-input",
        props: {
            names: {
                type: Array,
                required: true
            },
            defaults: {
                type: Array,
                required: false,
                default: [undefined, undefined]
            },
            required: {
                type: Boolean,
                required: false,
                default: true
            },
            placeholder: {
                type: String,
                required: false,
                default: "Select a period of time"
            },
            classes: {
                type: Array,
                required: false,
                default: []
            }
        },
        data: function () {
            return {
                dragValue: {start: undefined, end: undefined},
                range: {
                    start: this.defaults[0] ? new Date(this.defaults[0]) : undefined,
                    end: this.defaults[1] ? new Date(this.defaults[1]) : undefined
                },
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
        }
    }
</script>

<style scoped>

</style>