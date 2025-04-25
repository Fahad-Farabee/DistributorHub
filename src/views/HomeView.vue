<script setup>
    import categroies from '@/components/categroies.vue';
    import company from '@/components/company.vue';
    import NavBar from '@/components/NavBar.vue';
    import products from '@/components/products.vue';
    import hompageFooter from '@/components/homepageFooter.vue';
    import productCategories from '@/components/productCategories.vue';
</script>

<template>
    <NavBar/>
    <company/>
    <!-- <categroies/> -->
    <productCategories/>
    <products/>
    <hompageFooter/>
</template>