<template>
    <div class="modal-content modal-dark">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="position-relative" style="margin-bottom: 0.5rem;">
                <label for="itemSelect">Select Item</label>
                <input type="text" id="itemSelect" autocomplete="off" class="wf-input" v-on:focus="hidden = false" v-on:blur="hidden = true" v-on:input="search" placeholder="Enter item name" v-model="term">
                <div class="items-contents" v-if="!hidden">
                    <div class="d-block list-group" v-for="(itemArray, type) in itemsSearched">
                        {{ type.capitalize() }}
                        <div class="list-item" v-for="item in itemArray" v-on:mousedown="selectItem(item.id, $event)">
                            {{ item.name.capitalize() }}
                        </div>
                    </div>
                </div>
            </div>
            <label class="wf-label" for="amount">Amount</label>
            <input id="amount" class="wf-input" type="number" placeholder="Amount" :value="amount">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" v-on:click="addItem">Add</button>
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
                selectedItem: null,
                term: "",
                hidden: true,
                amount: 1
            }
        },
        mounted() {
            this.getItems();
        },
        methods: {
            async getItems() {
                const { data } = await axios.get('/api/items?group=1');
                this.items = data;
                this.itemsSearched = data;
            },
            search() {
                if(this.term === "") {
                    this.itemsSearched = this.items;
                    return;
                }

                this.itemsSearched = _.chain(this.items)
                    .flatMap()
                    .filter((o) => {
                        return o.name.toLowerCase().includes(this.term);
                    })
                    .groupBy('type')
                    .value();
            },
            selectItem(id) {
                let item = _.chain(this.itemsSearched).flatMap().find(function (item) {
                    return item.id === id;
                }).value();
                this.selectedItem = item.id;
                this.term = item.name.capitalize();
            },
            addItem() {
                let self = this;
                let formData = new FormData();
                formData.append('item_id', this.selectedItem);
                formData.append('amount', this.amount);
                axios.post('/api/inventory/add', formData).then(function (response) {
                    if(response.data.error) {
                        alert(response.data.message);
                        return;
                    }

                    self.$emit('updateInventoryParent', response.data.data.item);
                })
            }
        }
    }
</script>
