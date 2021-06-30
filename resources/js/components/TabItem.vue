<template>
        <div class="card bg-success">
            <div class="card-top" @mouseover="showMasteryButton = true" @mouseleave="showMasteryButton = false">
                <button :data-id="item['id']" class="mastered-btn" v-show="showMasteryButton" @click="clickMasteryButton" v-if="isLoggedIn">Mastered</button>
                <img class="card-img-top" :src="'/storage/' + item['url']" :alt="item['name']" />
            </div>
            <div class="card-body" :class="item['color']">
                <h5 class="card-title">{{ item['name'] }}</h5>
            </div>
        </div>
</template>

<script>
export default {
    data: function () {
        return {
            showMasteryButton: false,
            currentItem: null,
        }
    },
    props: {
        item: { required: true },
        isLoggedIn: { required: true, default: false }
    },
    mounted () {
        this.currentItem = this.item;
    },
    methods: {
        clickMasteryButton() {
            const form = new FormData();
            form.append('action', 'mastered');
            axios.post(`/api/item/${this.currentItem.id}/update`, form).then((response) => {

                if (response.error) alert(response.message);

                this.$emit('updateMastered', this.currentItem.id, response.data.data);
            });
        }
    }
}
</script>

