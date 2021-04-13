/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import axios from 'axios';

String.prototype.capitalize = function() {
    let words = this.split(' ');
    words.forEach((word, index) => {
        words[index] = word.charAt(0).toUpperCase() + word.slice(1);
    })
    return words.join(' ');
}

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('quick-search', require('./components/QuickSearch.vue').default);
Vue.component('tabs', require('./components/tabs.vue').default);
Vue.component('tab', require('./components/tab.vue').default);
Vue.component('add-item-modal', require('./components/AddItemModal.vue').default);
Vue.component('add-recipe-modal', require('./components/AddRecipeModal.vue').default);
Vue.component('wf-inventory', require('./components/Inventory.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

$(function() {
    $(".card-top").on('mouseenter', function() {
        $(this).children('.mastered-btn').removeClass('d-none');
        $(this).children('.mastered-btn').addClass('d-block');
    }).on('mouseleave', function() {
        $(this).children('.mastered-btn').removeClass('d-block');
        $(this).children('.mastered-btn').addClass('d-none');
    });

    $('.mastered-btn').on('click', function () {
        let self = $(this);
        const form = new FormData();
        form.append('action', 'mastered');
        axios.post(`/api/item/${self.data('id')}/update`, form).then(function (response) {
            let cardBody = self.parent().siblings('.card-body');

            if (response.error) alert(response.message);

            if(response.data.data.mastered) {
                cardBody.removeClass('bg-red');
                cardBody.addClass('bg-green');
            } else {
                cardBody.removeClass('bg-green');
                cardBody.addClass('bg-red');
            }
        })

    });
});

