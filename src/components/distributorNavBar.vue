<script setup>
import { ref ,onMounted, onUnmounted} from 'vue';
import { RouterLink,useRouter } from 'vue-router';
import { useRoute } from 'vue-router';
const routePath = useRoute();
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
const searchTheProduct = () => {
  if (searchedProdName.value.trim() !== '') {
        route.push('/distributor/search/product/page');
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
        <RouterLink to="/distributor/homepage" class="menu-item">Home</RouterLink>
        <div class="dropdown" @click.stop >
            <a
            href="#"
            class="menu-item dropdown-toggle"
            @click.prevent="toggleDropdown"
            >
            Profile
            </a>
            <div v-if="isDropdownVisible" class="dropdown-menu">
            <RouterLink to="/distributor/profile" class="dropdown-item">My Account</RouterLink>
            <RouterLink to="/distributor/myorder" class="dropdown-item">My Order</RouterLink>
            <RouterLink to="/" class="dropdown-item">Log out</RouterLink>
            </div>
            
        </div>
        </div>
    </div>
    </nav>
    <div v-if="routePath.path === '/distributor/homepage'" class="search-box" >
    <input type="text" id="search-box" placeholder="Search products" v-model="searchedProdName"/>
    <button class="search-btn" v-on:click="searchTheProduct">Search</button>
    </div>
    
</template>