<script setup>
import { ref ,onMounted, onUnmounted} from 'vue';
import { RouterLink,  useRouter, useRoute } from 'vue-router';


const isDropdownVisible = ref(false);

const searchedProdName = ref("");
const route = useRouter();
const routePath = useRoute();

const searchTheProduct = () => {
  if (searchedProdName.value.trim() !== '') {
        route.push('/retailer/search/product/page');
        localStorage.setItem('searchedProduct',searchedProdName.value);
  } else {
    alert('Please enter a product name before searching.');
  }
};


const toggleDropdown = () => {
    isDropdownVisible.value = !isDropdownVisible.value;
};
const handleOutsideClick = (event) =>{
    if(!event.target.closest('.dropdown')){
        isDropdownVisible.value=false;
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
 
    <nav class="navbar">
    <div class="nav-cont">
        <div class="logo-section">
        <div class="logo"></div>
        <span class="brand-name">Distributor's Hub</span>
        </div>
        <div class="menu">
        <RouterLink to="/retailer/cart" class="menu-item">Cart</RouterLink>
        <RouterLink to="/retailer/homepage" class="menu-item">Home</RouterLink>
        <div class="dropdown" @click.stop >
            <a
            href="#"
            class="menu-item dropdown-toggle"
            @click.prevent="toggleDropdown"
            >
            Profile
            </a>
            <div v-if="isDropdownVisible" class="dropdown-menu">
            <RouterLink to="/retailer/profile" class="dropdown-item">My Account</RouterLink>
            <RouterLink to="/retailer/myorder" class="dropdown-item">My Order</RouterLink>
            <RouterLink to="/" class="dropdown-item">Log out</RouterLink>
            </div>
            
        </div>
        </div>
    </div>
    </nav>

    <div v-if="routePath.path === '/retailer/homepage'" class="search-box">
    <input type="text" id="search-box" placeholder="Search products" v-model="searchedProdName" />
    <button class="search-btn" v-on:click="searchTheProduct">Search</button>
    </div>
    
</template>