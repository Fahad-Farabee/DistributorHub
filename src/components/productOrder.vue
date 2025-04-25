<script setup>
import { computed, onMounted, ref } from 'vue';
    const productPerPiecePrice = ref(0);
    const foundProduct = ref({});
    const minimumQtn = ref(0);
    const productCount = ref(0);
    //finding the selected product by its id.
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
                minimumQtn.value = foundProduct.value.prodMinQtn;
                productPerPiecePrice.value = foundProduct.value.prodPerPiecePrice
                productCount.value = minimumQtn.value;
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
    const decreaseCount = () => {
        if (productCount.value > minimumQtn.value) {
                productCount.value--;  
        }
        else{
            alert("Less than miminum QUANTITY!!")
        }
    };
    const increaseCount = () =>{
        productCount.value++;
    }   
    const productTotalPrice = computed(()=>{
        return productCount.value * productPerPiecePrice.value;
    })
    //adding to cart.
    const addToCart = async() =>{
        const prodId = localStorage.getItem('selectedProductId');
        /* try{
            const response = await fetch("http://localhost/distributorHub/cartAdd.php",{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    productid: prodId,
                    qtncount: productCount.value,
                    totalPrice: productTotalPrice.value

                })
            });
            const result = await response.json();
            console.log(result);
            if(result.success){
                alert("added to your cart");
            }
            else{
                console.log("fuk you");
            }
        }
        catch(error){
            console.log("Error while uploading : ", error);
        } */
       alert("Please login or sign up");
    }
    //directly adding to orders. because i am buying now.
    const showOverlay = ref(false);
    const toggleOverlay = ()=>{
        showOverlay.value = !showOverlay.value;
    }
    const buyNow = async () =>{
        const prodId = localStorage.getItem('selectedProductId');
    /*     try{
            const response = await fetch("http://localhost/distributorHub/orders.php",{
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    productid: prodId,
                    qtncount: productCount.value,
                    totalPrice: productTotalPrice.value

                })
            });
            const result = await response.json();
            console.log(result);
            if(result.success){
                alert("Your order has beeb placed");
                toggleOverlay();
            }
            else{
                console.log("Error>>>>>>>");
            }
        }
        catch(error){
            console.log("Error while uploading : ", error);
        } */
        alert("Please login or sign up");
    }
</script>

<template>
    <div class="product-order">
        <div class="product-order-cont">
            <div class="product-order-image">
               <img :src="`http://localhost/${foundProduct.prodImage}`" alt="Profile Picture" />
            </div>
            <div class="product-order-details">
                <h3>{{ foundProduct.prodName }}</h3>
                <!-- <div class="product-order-subtitle"><strong>Distributor: </strong> X </div>
                <div class="product-order-subtitle"><strong>Region: </strong> {{ foundProduct.prodRegion }} </div> -->
                <div class="product-order-subtitle"><strong>Minimum Order Quantity: </strong> {{ foundProduct.prodMinQtn }} </div>
                <div class="product-order-subtitle"><strong>Price Per Piece: </strong> {{ foundProduct.prodPerPiecePrice }} tk</div>
                <br>
                <button v-on:click="decreaseCount" class="product-order-count-button">-</button>
                {{ productCount }}
                <button v-on:click="increaseCount" class="product-order-count-button">+</button>
                {{ productTotalPrice }}
                <br>
                <div class="product-order-buttons">
                    <button class="product-order-button" v-on:click="addToCart">Add to cart</button>
                    <button class="product-order-button" v-on:click="buyNow">Buy now</button>
                </div>
            </div>
        </div>

        <!-- payment overlay -->
        <div v-if="showOverlay" class="payment-overlay">
            <div class="payment-overlay-content">
                <div class="payment-method" >
                    <img src="/src/assets/img/bkash.svg" alt="bkash">
                </div>
                <div class="payment-method" >
                    <img src="/src/assets/img/496-4962280_nagad-logo-transparent-bkash-logo-png-png-download.png" alt="nagad">
                </div>
                <div class="payment-method" >
                    <img src="/src/assets/img/rocket.webp" alt="rocket">
                </div>
                <div class="payment-method" >
                    Cash On Delivery
                </div>
                <button class="payment-overlay-close-btn" @click="toggleOverlay">Close</button>
            </div>
        </div>
    </div>
</template>