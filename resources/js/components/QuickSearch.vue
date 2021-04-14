<template>
    <div class="d-flex align-items-center justify-content-center w-75 m-auto position-relative">
        <div class="wf-search-form flex-grow-1">
            <input type="text" v-model="term" v-on:focus="listHidden = false" v-on:blur="listHidden = true" v-on:input="search()" placeholder="Search...">
        </div>
        <div class="wf-search-list position-absolute" v-show="!listHidden">
            <ul>
                <li v-on:mousedown="goTo(item.id)" v-for="item in itemsSearched">{{ item.name }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';

    export default {
        data: function () {
            return {
                items: {},
                itemsSearched: {},
                term: "",
                listHidden: true
            }
        },
        mounted() {
            this.getItems();
        },
        methods: {
            async getItems() {
                const { data } = await axios.get('/api/items?types=warframe,primary,secondary,melee,component');
                this.items = data;
                this.itemsSearched = data;
            },
            search() {
                this.itemsSearched = _.filter(this.items, (o) => {
                    return o.name.toLowerCase().includes(this.term);
                });
            },
            goTo(itemId) {
                let foundItem = _.find(this.items, function (item) {
                    return item.id === itemId;
                })
                location.replace(location.protocol + "//" + location.host + "/item/" + foundItem.key);
            }
        }
    }
</script>
