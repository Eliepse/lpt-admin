<template>
    <div class="loaderScreen" v-show="active">
        <div v-if="message.type !== 'error'" class="spinner-border" role="status">
            <span class="sr-only">Loading...</span></div>
        <div :class="{ 'text-danger' : message.type === 'error' }">{{ message.label }}</div>
    </div>
</template>

<script>
    export default {
        name: "loader",
        props: {
            active: {
                type: Boolean,
                required: false,
                default: false,
            }
        },
        data: function () {
            return {
                //active: false,
                message: {
                    label: 'Chargement...',
                    type: undefined
                }
            }
        },
        methods: {
            open: function (label, type) {
                this.active = true
                this.setMessage(label, type)
            },

            close: function () {
                this.active = false
                this.setMessage('Chargement...')
            },

            setMessage: function (label, type) {
                this.message.label = label
                this.message.type = type
            }
        }
    }
</script>

<style scoped>
    .loaderScreen {
        display: flex;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: #ffffff;
        opacity: .7;
        z-index: 100;
    }
</style>
