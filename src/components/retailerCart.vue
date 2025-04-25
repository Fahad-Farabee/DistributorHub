<script setup>
    import { ref,onMounted } from 'vue';
    const retailerCartProds = ref([]);
    const fetchRetailerCartProducts = async () => {
    const retailerId = localStorage.getItem('userId');
    console.log(retailerId);
  try {
    
    const response = await fetch(`http://localhost/distributorHub/cartShow.php?retailerId=${retailerId}`); // Replace with your actual API URL
    const data = await response.json();
    if (data.success) {
      retailerCartProds.value = data.data; // Assign fetched data to the products array
      console.log(retailerCartProds.value);
    } else {
      console.error(data.message);
    }
  } catch (error) {
    console.error('Error fetching products:', error);
  }
};
// Fetch products when the component is mounted
/* onMounted(fetchRetailerCartProducts); */
onMounted(() => {
  fetchRetailerCartProducts();
});
</script>

<template>
    <div class="retailer-cart-item">
        <h4>My Items</h4>
        <div class="retailer-cart-item-cont">
            <div v-for="product in retailerCartProds" :key="product.prodId" class="retailer-cart-items">
                <div class="retailer-cart-items-image">
                    <img :src="`http://localhost/${product.prodImage}`" alt="product image">
                </div>
                <div class="retailer-cart-items-info">
                    <div class="retailer-cart-item-subtitle"><strong>Product Name: </strong> {{ product.prodName }}</div>
                    <div class="retailer-cart-item-subtitle"><strong>Product Per Piece Price: </strong>{{ product.prodPerPiecePrice }}</div>
                    <div class="retailer-cart-item-subtitle"><strong>Product type: </strong>{{ product.prodType }}</div>
                    <div class="retailer-cart-item-subtitle"><strong>Product category: </strong>{{ product.prodCategory }}</div>
                    <div class="retailer-cart-item-subtitle"><strong>Product minimum quantity: </strong>{{ product.prodMinQtn }}</div>
                    <div class="retailer-cart-item-subtitle"><strong>Product Region: </strong>{{ product.prodRegion }}</div>
                    <div class="retailer-cart-item-subtitle"><strong>Product company: </strong>{{ product.prodCompany }}</div>
                </div>
            </div>
        </div>
        <!-- <button class="retailer-view-more-btn">View More</button> -->
    </div>
</template>