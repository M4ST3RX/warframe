<template>
    <div class="bg-dark pt-2 pb-1">
        <div class="filter-item" v-for="filter in filters">
            <input type="checkbox" :id="filter.key" :name="filter.key" :value="filter.key" v-model="checkedFilters"/>
            <label v-bind:for="filter.key">{{ filter.name }}</label>
        </div>
    </div>
</template>

<script>
import eventBus from './EventBus';
    export default {
        data: function () {
            return {
                filters: [
                    {
                        key: "hide_requires_forma",
                        name: "Hide Requires Forma"
                    },
                    {
                        key: "hide_mastered",
                        name: "Hide Mastered"
                    },
                    {
                        key: "hide_prime",
                        name: "Hide Prime"
                    },
                    {
                        key: "hide_prisma",
                        name: "Hide Prisma"
                    },
                    {
                        key: "hide_kuva",
                        name: "Hide Kuva"
                    }
                ],
                checkedFilters: []
            }
        },
        watch: {
            checkedFilters: {
                handler: function () {
                    eventBus.$emit('refreshItems', this.checkedFilters);
                },
                deep: true
            }
        },
        created () {

        },
        methods: {

        }
    }
</script>
