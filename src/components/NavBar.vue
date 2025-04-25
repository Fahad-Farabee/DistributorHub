<script setup>
import { ref ,onMounted, onUnmounted} from 'vue';
import { RouterLink,useRoute,useRouter } from 'vue-router';



// Reactive state to manage dropdown visibility
const isDropdownVisible = ref(false);

// Toggle dropdown visibility
const toggleDropdown = () => {
    isDropdownVisible.value = !isDropdownVisible.value;
};
const handleOutsideClick = (event) =>{
    if(!event.target.closest('.dropdown')){
        isDropdownVisible.value=false;
    }
};

//searching product.
const searchedProdName = ref("");
const route = useRouter();
const routePath = useRoute();
const searchTheProduct = () => {
  if (searchedProdName.value.trim() !== '') {
        route.push('/search/product/page');
        localStorage.setItem('searchedProduct',searchedProdName.value);
  } else {
    alert('Please enter a product name before searching.');
  }
};


onMounted(()=>{
    document.addEventListener('click', handleOutsideClick);
});
onUnmounted(()=>{
    document.removeEventListener('click', handleOutsideClick);
});
</script>
<template>
    <!-- Navbar -->
    <nav class="navbar">
    <div class="nav-cont">
        <div class="logo-section">
        <div class="logo"></div>
        <span class="brand-name">Distributor's Hub</span>
        </div>
        <div class="menu">
        <!-- <RouterLink to="/cart" class="menu-item">Cart</RouterLink> -->
        <RouterLink to="/" class="menu-item">Home</RouterLink>
        <RouterLink to="/signin" class="menu-item">SignIn</RouterLink>
        <div class="dropdown" @click.stop >
            <a
            href="#"
            class="menu-item dropdown-toggle"
            @click.prevent="toggleDropdown"
            >
            SignUp
            </a>
            <div v-if="isDropdownVisible" class="dropdown-menu">
            <RouterLink to="/signup/Distributor" class="dropdown-item">Distributor</RouterLink>
            <RouterLink to="/signup/Retailer" class="dropdown-item">Retailer</RouterLink>
            </div>
            
        </div>
        </div>
    </div>
    </nav>

    <!-- Searchbox -->
    <div v-if="routePath.path==='/' " class="search-box">
    <input type="text" id="search-box" placeholder="Search products" v-model="searchedProdName"/>
    <button class="search-btn" v-on:click="searchTheProduct">Search</button>
    </div>
</template>