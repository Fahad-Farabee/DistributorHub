<script setup>
    import productNavBar from '@/components/productNavBar.vue';
    import productOrder from '@/components/productOrder.vue';
    import productDetails from '@/components/productDetails.vue';
    import NavBar from '@/components/NavBar.vue';
</script>

<template>
    <!-- <productNavBar/> -->
     <NavBar/>
    <productOrder/>
    <productDetails/>
</template>