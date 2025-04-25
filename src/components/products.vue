<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
const route = useRouter();
// Define a reactive array to hold product data
const products = ref([]);
const fetchProducts = async () => {
  try {
    const response = await fetch('http://localhost/distributorHub/showProducts.php'); // Replace with your actual API URL
    const data = await response.json();

    if (data.success) {
      products.value = data.data; // Assign fetched data to the products array
      /* console.log(data); */
    } else {
      console.error(data.message);
    }
  } catch (error) {
    console.error('Error fetching products:', error);
  }
};
const selectProduct=(selectedProduct)=>{
  localStorage.setItem('selectedProductId', selectedProduct.prodId);
  route.push('/product/page');
}

// Fetch products when the component is mounted
onMounted(fetchProducts);
</script>

<template>
  
  <div class="products">
    <h3>Products For you</h3>
    <!-- <button class="arrow-left-btn"><i class="arrow left"></i></button> -->
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
  <!--   <button class="arrow-right-btn"><i class="arrow right"></i></button> -->
  </div>
</template>
