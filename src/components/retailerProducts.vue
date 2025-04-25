<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
const retailerId = localStorage.getItem('userId');

const route = useRouter();
const products = ref([]);
const fetchProducts = async () => {
  try {
    const response = await fetch(`http://localhost/distributorHub/showRetailerHomepageProducts.php?retailerId=${retailerId}`);
    const data = await response.json();

    if (data.success) {
      products.value = data.data;
    } else {
      console.error(data.message);
    }
  } catch (error) {
    console.error('Error fetching products:', error);
  }
};
const selectProduct=(selectedProduct)=>{
  localStorage.setItem('selectedProductId', selectedProduct.prodId);
  route.push('/retailer/product/page');
}
onMounted(() => {
    fetchProducts();
    });
</script>

<template>
  
  <div class="products">
    <h3>Products For your Region</h3>
    <div class="products-cont">
      <!-- Render products dynamically -->
      <div v-for="product in products" :key="product.prodId" class="products-box" v-on:click="selectProduct(product)">
        <div class="products-image">
          <!-- Use the image URL from the database -->
          <img :src="`http://localhost/${product.prodImage}`" alt="Product Image" />

        </div>
        <div class="products-name">
          <p class="main-title">{{ product.prodName }}</p>
          <p class="sub-title">{{ product.prodPerPiecePrice }} tk/pcs</p>
        </div>
      </div>
    </div>
  </div>
</template>
