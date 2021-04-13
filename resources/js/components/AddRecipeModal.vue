<template>
    <div class="modal fade" id="addRecipeModal" tabindex="-1" role="dialog" aria-labelledby="Create Recipe" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Recipe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="js-recipe-body">
                        <span>Output</span>
                        <div class="d-flex justify-content-between py-1">
                            <select class="wf-input" style="width: 68%!important;" name="output-resource">
                                <option value="0" disabled selected>Please Select</option>
                                <optgroup :label="type.capitalize()" v-for="(groupItems, type) in outputItems">
                                    <option :value="item.id" v-for="item in groupItems">{{ item.name.capitalize() }}</option>
                                </optgroup>
                            </select>
                            <input name="output-amount" class="wf-input" style="width: 28%!important;" type="number" placeholder="Amount">
                        </div>
                        <span>Input</span>
                        <div class="d-flex justify-content-between py-1" v-for="row in rows">
                            <select class="wf-input" style="width: 68%!important;" :name="'resource-' + row">
                                <option value="0" disabled selected>Please Select</option>
                                <option :value="item.id" v-for="item in items">{{ item.name }}</option>
                            </select>
                            <input :name="'amount-' + row" class="wf-input" style="width: 28%!important;" type="number" placeholder="Amount">
                        </div>
                    </div>
                    <div class="d-flex float-right mt-2">
                        <button class="btn btn-danger mx-2" v-on:click="rows -= 1">Remove Resource</button>
                        <button class="btn btn-primary" v-on:click="rows += 1">Add New Resource</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="submitRecipe()">Create</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import _ from 'lodash';

const $ = window.jQuery;

export default {
    props: ['blueprint'],
    data: function () {
        return {
            items: [],
            outputItems: {},
            rows: 1
        }
    },
    mounted() {
        this.getItems();
        this.getItems2();
    },
    methods: {
        async getItems() {
            const { data } = await axios.get('/api/items?types=component,resource');
            this.items = _.orderBy(data, 'name');
            console.log(data);
        },
        async getItems2() {
            const { data } = await axios.get('/api/items?types=component,warframe,primary,secondary,melee&group=1&orderBy=name');
            this.outputItems = _.chain(data).flatMap().orderBy('name').groupBy('type').value();
            console.log(this.outputItems);
        },
        submitRecipe() {
            let form = new FormData();
            form.append('blueprint', this.blueprint);

            $('.js-recipe-body').find('select').each(function () {
                form.append($(this).attr('name'), $(this).find(':selected').val());
            });

            $('.js-recipe-body').find('input').each(function () {
                form.append($(this).attr('name'), $(this).val());
            });

            axios.post('/api/recipe/create', form).then(function (response) {
                /*if(response.data.error) {
                    alert(response.data.message);
                }

                location.reload();*/
            })
        }
    }
}
</script>

