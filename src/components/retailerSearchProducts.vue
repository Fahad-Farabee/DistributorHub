 <script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
const retailerId = localStorage.getItem('userId');
const searchedProduct = ref(localStorage.getItem('searchedProduct'));
const route = useRouter();
const products = ref([]);
const fetchProducts = async () => {
  try {
    const response = await fetch(`http://localhost/distributorHub/searchProductByName.php?prodname=${searchedProduct.value}`);
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
    <h3 v-if="products.length>0">Showing Results For "{{ searchedProduct}}"</h3>
    <h3 v-else>OOPs No Product has been found</h3>
    <div class="products-cont">

      <div v-for="product in products" :key="product.prodId" class="products-box" v-on:click="selectProduct(product)">
        <div class="products-image">
          <img :src="`http://localhost/${product.prodImage}`" alt="Product Image" />
        </div>
        <div class="products-name">
          <p class="main-title">{{ product.prodName }}</p>
          <p class="sub-title">Product Per Piece Price: {{ product.prodPerPiecePrice }} tk/pcs</p>
          <p class="sub-title">Distributor's Name: {{ product.disUserName }} </p>
          <p class="sub-title">Distributing Region: {{ product.prodRegion }} </p>
        </div>
      </div>
    </div>
  </div>
</template> 



 <!-- <script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const products = ref([]);
const searchedProduct = ref(route.query.prodname);
const fetchProducts = async () => {
  if (searchedProduct.value.trim() !== '') {
    try {
      const response = await fetch(`http://localhost/distributorHub/searchProductByName.php?prodname=${searchedProduct.value}`);
      const data = await response.json();
      if (data.success) {
        products.value = data.data;
      } else {
        console.error(data.message);
      }
    } catch (error) {
      console.error('Error fetching products:', error);
    }
  }
};
const selectProduct=(selectedProduct)=>{
  localStorage.setItem('selectedProductId', selectedProduct.prodId);
  route.push('/retailer/product/page');
}
watch(
  () => route.query.prodname,
  (newProdname) => {
    searchedProduct.value = newProdname;
    fetchProducts();
  }
);

onMounted(() => {
  fetchProducts();
});
</script>

 
 
<template>
    <div class="products">
      <h3 v-if="products.length>0">Showing Results For "{{ searchedProduct }}"</h3>
      <h3 v-else>OOPs No Products Found!!</h3>
      <div class="products-cont">
        <div v-for="product in products" :key="product.prodId" class="products-box" v-on:click="selectProduct(product)" >
          <div class="products-image">
            <img :src="`http://localhost/${product.prodImage}`" alt="Product Image" />
          </div>
          <div class="products-name">
            <p class="main-title">{{ product.prodName }}</p>
            <p class="sub-title">Product Per Piece Price: {{ product.prodPerPiecePrice }} tk/pcs</p>
            <p class="sub-title">Distributor's Name: {{ product.disUserName }}</p>
            <p class="sub-title">Distributing Region: {{ product.prodRegion }}</p>
          </div>
        </div>
      </div>
    </div>
  </template> -->

<!--   <script setup>
import { ref, onMounted, watch } from 'vue';
import { useRouter } from 'vue-router';

const route = useRouter();
const products = ref([]);
const searchedProduct = ref(route.query.prodname || '');


const fetchProducts = async () => {
  if (searchedProduct.value.trim() !== '') {
    try {
      const response = await fetch(`http://localhost/distributorHub/searchProductByName.php?prodname=${searchedProduct.value}`);
      const data = await response.json();
      if (data.success) {
        products.value = data.data;
      } else {
        products.value = []; 
        console.error(data.message);
      }
    } catch (error) {
      products.value = []; 
      console.error('Error fetching products:', error);
    }
  }
};


const selectProduct = (selectedProduct) => {
  localStorage.setItem('selectedProductId', selectedProduct.prodId);
  route.push('/retailer/product/page');
};

watch(
  () => route.query.prodname,
  (newProdname) => {
    searchedProduct.value = newProdname;
    fetchProducts();
  }
);


onMounted(() => {
  fetchProducts();
});
</script>

<template>
  <div class="products">

    <h3 v-if="products.length > 0">Showing Results For "{{ searchedProduct }}"</h3>
    <h3 v-else>Oops! No Products Found!!</h3>

    <div class="products-cont">
      <div
        v-for="product in products"
        :key="product.prodId"
        class="products-box"
        @click="selectProduct(product)"
      >
        <div class="products-image">
          <img :src="`http://localhost/${product.prodImage}`" alt="Product Image" />
        </div>
        <div class="products-name">
          <p class="main-title">{{ product.prodName }}</p>
          <p class="sub-title">Product Per Piece Price: {{ product.prodPerPiecePrice }} tk/pcs</p>
          <p class="sub-title">Distributor's Name: {{ product.disUserName }}</p>
          <p class="sub-title">Distributing Region: {{ product.prodRegion }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
 -->
  
 
 
 