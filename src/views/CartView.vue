<script setup>
    import NavBar from '@/components/NavBar.vue';
    import cartItems from '@/components/cartItems.vue';
    import pageFooter from '@/components/pageFooter.vue';
    import retailerNavBar from '@/components/retailerNavBar.vue';
</script>

<template>
    <!-- <NavBar/> -->
    <retailerNavBar/>
    <cartItems/>
    <pageFooter/>
</template>