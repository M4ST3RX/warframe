<template>
    <div class="container">
        <div class="row mt-2" style="padding: 0 10px;">
            <div v-if="items.length === 0">No content</div>
            <div class="col-md-5ths wf-item-card" v-for="item in items">
                <div class="card bg-success">
                    <img class="card-img-top" :src="'storage/'+item.url" :alt="item.name" />
                    <div class="card-body bg-blue">
                        <h5 class="card-title">{{ item.name }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="floating-btn">
            <button type="button" class="inventory-add" data-toggle="modal" data-target="#addItemToInv">
                <svg height="48pt" viewBox="0 0 512 512" width="48pt" xmlns="http://www.w3.org/2000/svg">
                    <path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm0 0" fill="#2196f3"/>
                    <path d="m368 277.332031h-90.667969v90.667969c0 11.777344-9.554687 21.332031-21.332031 21.332031s-21.332031-9.554687-21.332031-21.332031v-90.667969h-90.667969c-11.777344 0-21.332031-9.554687-21.332031-21.332031s9.554687-21.332031 21.332031-21.332031h90.667969v-90.667969c0-11.777344 9.554687-21.332031 21.332031-21.332031s21.332031 9.554687 21.332031 21.332031v90.667969h90.667969c11.777344 0 21.332031 9.554687 21.332031 21.332031s-9.554687 21.332031-21.332031 21.332031zm0 0" fill="#fafafa"/>
                </svg>
            </button>
        </div>

        <div class="modal fade" id="addItemToInv" tabindex="-1" role="dialog" aria-labelledby="Add Item" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <add-item-modal v-on:updateInventoryParent="updateInventory">
                </add-item-modal>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';

    export default {
        data: function () {
            return {
                items: []
            }
        },
        mounted() {
            this.getItems();
        },
        methods: {
            async getItems() {
                const { data } = await axios.get('/api/inventory');
                this.items = _.orderBy(data, 'name');

            },
            updateInventory(item) {
                this.items.push(item);
                let items = _.chain(this.items).uniqBy('id').value();
                this.items = _.orderBy(items, 'name');
            }
        }
    }
</script>
