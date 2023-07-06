<template>
    <div v-show="isActive">
        <div class="main-container">
            <div class="row mt-2" style="padding: 0 10px 10px 10px;">
                <div class="col-sm-5ths col-md-5ths col-lg-5ths wf-item-card" v-if="items.length > 0" v-for="item in items" v-show="!item.hidden">
                    <tab-item :item="item" :isLoggedIn="isLoggedIn" @updateMastered="updateMastered"></tab-item>
                </div>
                <div v-else>No content</div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';
    import eventBus from './EventBus';

    const $ = window.jQuery;

    export default {
        props: {
            name: { required: true },
            selected: { default: false},
            isLoggedIn: { required: true, default: false }
        },
        data: function () {
            return {
                isActive: false,
                type: "",
                items: [],
                filters: []
            }
        },
        created () {
            eventBus.$on("refreshItems", filters => {
                this.filters = filters;

                this.items.forEach((item, index) => {
                    item.hidden = false;
                    this.filters.forEach((filter) => {
                        switch (filter) {
                            case 'hide_requires_forma':
                                this.filterItemsWithForma(item, index);
                                break;
                            case 'hide_mastered':
                                this.filterItemsMastered(item, index);
                                break;
                            case 'hide_prime':
                                this.filterItemsPrime(item, index);
                                break;
                            case 'hide_prisma':
                                this.filterItemsPrisma(item, index);
                                break;
                            case 'hide_kuva':
                                this.filterItemsKuva(item, index);
                                break;
                        }
                    });
                });

                this.$forceUpdate();
            });
        },
        mounted() {
            this.isActive = this.selected;
            this.type = this.name;
            this.getItems();
        },
        methods: {
            async getItems() {
                const { data } = await axios.get('/api/items?types=' + this.type.toLowerCase().replace(" ", "_") + '&mastery=true&crafting=true');
                this.items = _.orderBy(data, 'name');
            },
            filterItemsWithForma(item, index) {
                let foundItem = false;

                if(item.recipe !== null) {
                    Object.keys(item.recipe).forEach((recipeItem) => {
                        if(recipeItem === "forma") {
                            foundItem = true;
                        }
                    });
                }

                if(foundItem) {
                    item.hidden = true;
                }

                this.items[index] = item;
            },
            filterItemsMastered(item, index) {
                if(item.isMastered) item.hidden = true;
                this.items[index] = item;
            },
            filterItemsPrime(item, index) {
                if(item.key.includes('_prime')) item.hidden = true;
                this.items[index] = item;
            },
            filterItemsPrisma(item, index) {
                if(item.key.includes('prisma_')) item.hidden = true;
                this.items[index] = item;
            },
            filterItemsKuva(item, index) {
                if(item.key.includes('kuva_')) item.hidden = true;
                this.items[index] = item;
            },
            updateMastered(id, data) {
                this.items.forEach((item, index) => {
                    if(item.id === id) {
                        if(this.filters.includes('hide_mastered')) {
                            item.hidden = data.mastered;
                        }
                        item.isMastered = data.mastered;
                        item.color = data.color;
                        this.items[index] = item;
                    }
                });

                if(this.filters.includes('hide_mastered')) {
                    this.$forceUpdate();
                }
            }
        }
    }
</script>
