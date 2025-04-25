<script setup>
    import { ref,onMounted } from 'vue';

    const showOverlay = ref(false);
    const toggleOverlay = () =>{
        showOverlay.value= !showOverlay.value;
    }
    //it will store the items that are added to the cart
    const cartItems = ref([]);
    //it will fetch the items from the cart 
    const fetchCartItems = async()=>{
        const retailerId = localStorage.getItem('userId');
        try{
            const response = await fetch(`http://localhost/distributorHub/cartShow.php?retailerId=${retailerId}`);
            const result = await response.json();
            if(result.success){
                cartItems.value = result.data;
                console.log(cartItems.value);
            }
        }catch(error){
            console.error("Error in showing the cart items", error);
        }
    }
    //after add to order(confirming an item)
    const addToOrder = async(selectedCartItem)=>{
        const retailerId = localStorage.getItem('userId');
        try{
            const response = await fetch("http://localhost/distributorHub/orders.php",{
            method:'POST',
            headers:{
                'Content-Type':'application-json'
            },
            body:JSON.stringify({
                productid:selectedCartItem.prodId,
                qtncount:selectedCartItem.quantity,
                totalPrice:selectedCartItem.totalPrice,
                userId : retailerId
            })
        });
        const result = await response.json();
        if(result.success){
            alert("Your Order has benn Placed");
            console.log(result);
            const deleteResponse = await fetch("http://localhost/distributorHub/cartDelete.php",{
                method: 'DELETE',
                headers: {
                    'Content-Type':'application/json'
                },
                body:JSON.stringify({
                    cartid:selectedCartItem.cartId
                })
            });
            const deleteResponseResult = await deleteResponse.json();
            if (deleteResponseResult.success) {
                // Update the front-end cartItems array directly
                cartItems.value = cartItems.value.filter(
                    (item) => item.cartId !== selectedCartItem.cartId
                );
                showOverlay.value = !showOverlay.value;
            }
        }
        }catch(error){
            console.error("Not added");
        }
    }
    //deleting a cart item .
    const removeCartItem=async(selectedCartItem)=>{
        const deleteResponse = await fetch("http://localhost/distributorHub/cartDelete.php",{
                method: 'DELETE',
                headers: {
                    'Content-Type':'application/json'
                },
                body:JSON.stringify({
                    cartid:selectedCartItem.cartId
                })
            });
            const deleteResponseResult = await deleteResponse.json();
            if (deleteResponseResult.success) {
                // Update the front-end cartItems array directly
                cartItems.value = cartItems.value.filter(
                    (item) => item.cartId !== selectedCartItem.cartId
                );
            }
    }



    onMounted(()=>{
        fetchCartItems();
    })
</script>

<template>
    <div class="cart">
        <div class="cart-cont">
            <div v-if="cartItems.length>0">Your products:</div>
            <div v-else>Your cart is empty</div>
        
            <div  v-for="cartItem in cartItems" :key="cartItem.prodId" class="cart-box">
                <div class="cart-item-image-cont">
                    <div class="cart-item-image">
                        <img :src="`http://localhost/${cartItem.prodImage}`" alt="image 1">
                    </div>
                </div>
                <div class="cart-item-details-cont">
                    <div class="cart-item-details"><strong>Item name: </strong> {{ cartItem.prodName }}</div>
                    <div class="cart-item-details"><strong>Item Quantity: </strong>{{ cartItem.quantity }}</div>
                    <div class="cart-item-details"><strong>Item Total Price:</strong> {{ cartItem.totalPrice }}</div>
                    <div class="cart-item-details"><strong>Item Region: </strong>{{ cartItem.prodRegion }}</div>
                    <div class="cart-item-details"><strong>Item type: </strong>{{ cartItem.prodType }}</div>
                    <div class="cart-item-details"><strong>Item Category: </strong>{{ cartItem.prodCategory }}</div>
                    
                    
                </div>
                <div class="cart-item-btn-cont">
                    <button class="cart-item-btns" @click="addToOrder(cartItem)">Confirm</button> 
                    <button class="cart-item-btns" @click="removeCartItem(cartItem)">Remove</button>
                </div>
            </div>
           <!--  <div v-if="cartItems.length>0" class="cart-item-confirm-all">
                <button class="cart-item-confirm-all-btn" @click="toggleOverlay">Confirm All</button>
            </div> -->
        </div>

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