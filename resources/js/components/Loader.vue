<template>
    <div class="loaderScreen" v-show="active">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div v-if="!message">{{ message.label }}</div>
        <div v-if="message" :class="{ 'text-danger' : message.type === 'error' }">{{ message.label }}</div>
    </div>
</template>

<script>
    export default {
        name: "loader",
        data: function () {
            return {
                active: false,
                message: {
                    label: 'Chargement...',
                    type: undefined
                }
            }
        },
        methods: {
            open: function (label, type) {
                this.active = true
                this.message.label = label ? label : 'Chargement...'
                this.message.type = type
            },
            close: function () {
                this.active = false
                this.message.label = 'Chargement...'
                this.message.type = undefined
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