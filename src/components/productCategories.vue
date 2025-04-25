<script setup>
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const routePath = useRoute();

const showProducts = async (category) => {
  // Store the selected category in localStorage
  localStorage.setItem('productCategory', category);
  // Navigate to the products page
  if (routePath.path === '/') {
    router.push('/category/products/page');
  }
};
</script>

<template>
  <div class="categories">
    <h3>Categories</h3>
    <div class="categories-cont">
      <div class="categories-box" @click="showProducts('Dairy Items')">
        <div class="categories-image">
          <img src="/src/assets/img/dairy-eggs.webp" />
        </div>
        <div class="categories-name">
          <p>Dairy Items</p>
        </div>
      </div>
      <div class="categories-box" @click="showProducts('Sausces and Pickles')">
        <div class="categories-image">
          <img src="/src/assets/img/sauces-pickles.webp" />
        </div>
        <div class="categories-name">
          <p>Sauces and Pickles</p>
        </div>
      </div>
      <div class="categories-box" @click="showProducts('Cooking')">
        <div class="categories-image">
          <img src="/src/assets/img/cooking.webp" />
        </div>
        <div class="categories-name">
          <p>Cooking</p>
        </div>
      </div>
      <div class="categories-box" @click="showProducts('Candy and Chocolate')">
        <div class="categories-image">
          <img src="/src/assets/img/candy-chocolate.webp" />
        </div>
        <div class="categories-name">
          <p>Candy and Chocolate</p>
        </div>
      </div>
      <div class="categories-box" @click="showProducts('Snacks')">
        <div class="categories-image">
          <img src="/src/assets/img/snacks.webp" />
        </div>
        <div class="categories-name">
          <p>Snacks</p>
        </div>
      </div>
    </div>
  </div>
</template>
