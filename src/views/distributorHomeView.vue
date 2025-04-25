<script setup>
   import distributorNavBar from '@/components/distributorNavBar.vue';
   import categroies from '@/components/categroies.vue';
   import company from '@/components/company.vue';
   import products from '@/components/products.vue';
   import distributorProduct from '@/components/distributorProduct.vue';
   import distributorCategories from '@/components/distributorCategories.vue';
</script>

<template>
   <distributorNavBar/>
   <company/>
   <!-- <categroies/> -->
    <distributorCategories/>
   <distributorProduct/>
</template>