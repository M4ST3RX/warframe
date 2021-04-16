<template>
    <div v-show="isActive"><slot></slot></div>
</template>

<script>
    const $ = window.jQuery;

    export default {
        props: {
            name: { required: true },
            selected: { default: false}
        },
        data: function () {
            return {
                isActive: false
            }
        },
        mounted() {
            this.isActive = this.selected;
        }
    }
</script>
