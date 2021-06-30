<template>
    <div class="bg-dark">
        <ul class="nav nav-tabs">
            <li class="nav-item" v-for="tab in tabs">
                <a class="nav-link" :class="{'active': tab.isActive}" @click="selectTab(tab)">{{ tab.name }}</a>
            </li>
        </ul>

        <div class="panels">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                tabs: [],
                selectedTab: 0
            }
        },
        created () {
            this.tabs = this.$children;
        },
        methods: {
            selectTab(selectedTab) {
                this.tabs.forEach((tab, index) => {
                    tab.isActive = (tab.name === selectedTab.name);
                    this.selectedTab = index;
                });
            }
        }
    }
</script>
