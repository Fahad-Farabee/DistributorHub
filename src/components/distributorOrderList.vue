<script setup>
import { ref, onMounted } from 'vue';

const retailerMyOrderProds = ref([]);

const fetchRetailerMyOrderProducts = async () => {
  try {
    const distributorId = localStorage.getItem('userId');
    console.log(typeof(retailerId));
    const response = await fetch(`http://localhost/distributorHub/showDistributorOrderedProduct.php?distributorId=${distributorId}`);
    const data = await response.json();
    if (data.success) {
      retailerMyOrderProds.value = data.data;
      console.log(data);
    } else {
      console.error(data.message);
    }
  } catch (error) {
    console.error('Error fetching products:', error);
  }
};

// Fetch products when the component is mounted
onMounted(()=>{
  fetchRetailerMyOrderProducts();
});
</script>

<template>
  <div class="retailer-my-order">
    <div class="retailer-my-order-cont">
      <h1>Orders:</h1>
      <div v-for="product in retailerMyOrderProds" :key="product.prodId" class="retailer-my-order-box">
        <div class="retailer-my-order-image">
          <img :src="`http://localhost/${product.prodImage}`" :alt="`Image of ${product.prodName}`">
        </div>
        <div class="retailer-my-order-details">
          <div class="retailer-my-order-subtitle"><strong>Product Name: </strong> {{ product.prodName }}</div>
          <div class="retailer-my-order-subtitle"><strong>Product Quantity: </strong> {{ product.quantity }}</div>
          <div class="retailer-my-order-subtitle"><strong>Product Price: </strong> {{ product.totalPrice }}</div>
          <div class="retailer-my-order-subtitle"><strong>Distributing Region: </strong> {{ product.prodRegion }}</div>
          <div class="retailer-my-order-subtitle"><strong>Product Type: </strong> {{ product.prodType }}</div>
          <div class="retailer-my-order-subtitle"><strong>Product's Company: </strong> {{ product.prodCompany }}</div>
          <div class="retailer-my-order-subtitle"><strong>Retailer's Name: </strong> {{ product.userName }}</div>
          <div class="retailer-my-order-subtitle"><strong>Retailer's Store Name: </strong> {{ product.storeName }}</div>
          <div class="retailer-my-order-subtitle"><strong>Retailer's Store Address: </strong> {{ product.storeAddress }}</div>
          <div v-if="product.prodRegion !== product.region" class="retailer-my-order-subtitle"><strong>Retailer's Contact Number: </strong> {{ product.contactNumber }} (Owner is not in your region please contact with him)</div>
        </div>
      </div>
    </div>
  </div>
</template>
