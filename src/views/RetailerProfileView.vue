<script setup>
    import retailerNavBar from '@/components/retailerNavBar.vue';
    import RetailerProfileDetails from '@/components/RetailerProfileDetails.vue';
    import retailerCart from '@/components/retailerCart.vue';
    /* import retailerOrderHistory from '@/components/retailerOrderHistory.vue'; */
    import pageFooter from '@/components/pageFooter.vue';
</script>
<template>
    <retailerNavBar/>
    <RetailerProfileDetails/>
    <retailerCart/>
    <!-- <retailerOrderHistory/> -->
    <pageFooter/>
</template>