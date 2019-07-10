<template>
    <div class="loaderScreen" :class="{'d-flex' : active}">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div v-if="!message">{{ label }}</div>
        <div v-if="message" :class="{ 'text-danger' : message.type === 'error' }">Envoie des données...</div>
    </div>
</template>

<script>
    export default {
        name: "loader",
        props: {
            active: {
                type: Boolean,
                required: true
            },
            label: {
                type: String,
                required: false,
                default: 'Chargement...'
            },
            message: {
                type: Object,
                required: false,
                validator: function (message) {
                    return message.type
                }

            }
        }
    }
</script>

<style scoped>
    .loaderScreen {
        display: none;
        /*display: flex;*/
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