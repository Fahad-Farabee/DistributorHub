<script setup>
    import { ref,onMounted } from 'vue';
    const foundProduct = ref({});
     const selectedProduct = async()=>{
        const prodId = localStorage.getItem('selectedProductId');
        if(!prodId){
            alert("Product ID not found. Please log in again.");
            return;
        }
        try{
            const response = await fetch(`http://localhost/distributorHub/showSelectedProduct.php?prodId=${prodId}`);
            const data = await response.json();
            if(data.success){
                foundProduct.value = data.data;
            }
            else{
                console.log(data.error);
            }
        }catch(error){
            console.error("Error Fetchin Product", error);
        }
    };
    onMounted(()=>{
        selectedProduct();
    });
</script>

<template>
    <div class="product-details">
        <div class="product-details-cont">
            <h2 class="product-details-head">Product Details</h2>
            <div class="product-details-subtitle"><strong>{{ foundProduct.prodName }}</strong></div>
            <div class="product-details-subtitle">{{ foundProduct.prodRegion }}</div>
            <div class="product-details-subtitle">Product Distributor's Name</div>
            <div class="product-details-subtitle"> {{ foundProduct.prodCompany }}</div>
            <div class="product-details-subtitle">{{ foundProduct.prodCategory }}</div>
            <div class="product-details-subtitle">{{ foundProduct.prodType }}</div>
        </div>
    </div>
</template>