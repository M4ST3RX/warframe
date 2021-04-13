<template>
    <div v-show="isActive"><slot></slot></div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';
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
