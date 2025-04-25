<script setup>
    /* import HomeView from './views/HomeView.vue'; */
   /*  import SignInView from './views/SignInView.vue'; */
    /* import RetailerSignUpView from './views/RetailerSignUpView.vue'; */
    /* import DistributorSignUpView from './views/DistributorSignUpView.vue'; */
    import {RouterView} from 'vue-router';
    import NavBar from './components/NavBar.vue';
    import PageFooter from '/src/components/pageFooter.vue'
</script>

<template>
    <!-- <NavBar/> -->
    <!-- <HomeView/> -->
    <!-- <SignInView/> -->
    <!-- <RetailerSignUpView/> -->
    <!-- <DistributorSignUpView/> -->
    <RouterView/>
    <PageFooter/>
</template>