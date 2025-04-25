<script setup>
    import { ref, onMounted } from 'vue';
    const showOverlay = ref(false);
    const showEditOverlay = ref(false);
    const prodPic = ref(null);
    const productName = ref("");
    const productMinQtn = ref("");
    const productPricePerPiece = ref("");
    const productType = ref("");
    const productCategory = ref("");
    const productCompany = ref("");
    const productRegion = ref("");
    const distributorsProducts = ref([]);
    const currentProduct = ref({});
    //handling the picture file uploading
    const handleFileUpload = (event) =>{
        prodPic.value = event.target.files[0];
    }
    //toggeling overlay.
    const toggleOverlay = () =>{
        showOverlay.value = !showOverlay.value;
    } 
    //reseting the form after using.
    const resetForm = () => {
        prodPic.value = null;
        productName.value = "";
        productMinQtn.value = "";
        productPricePerPiece.value = "";
        productType.value = "";
        productCategory.value = "";
        productCompany.value = "";
        productRegion.value = "";
    };
    //uploading a product.
    const handleSubmit = async () =>{
    try{
        console.log("hello");
        const distId = localStorage.getItem('userId');
        const data = new FormData();
        data.append("productName", productName.value);
        data.append("productMinQtn", productMinQtn.value);
        data.append("productPricePerPiece", productPricePerPiece.value);
        data.append("productType", productType.value);
        data.append("productCategory", productCategory.value);
        data.append("productCompany", productCompany.value);
        data.append("productRegion", productRegion.value);
        data.append("distributorSL", distId);
         if (prodPic.value) {
            data.append("productPicture", prodPic.value);
        } 

        const response = await fetch("http://localhost/distributorHub/productAdd.php", {
            method: 'POST',
            body: data
        });
        if(!response.ok){
            throw new Error ("failed to upload data"); 
        } 
        const result = await response.json();
        await fetchDistributorProducts(distId);
        console.log("Server Response: ", result);
        alert("Data uploaded successfully!!!");
        toggleOverlay();
        resetForm();
         }catch(error){
        console.error("Error Uploading data: ", error);
        alert("Failed to upload data. Please try again");
        }
    }
    //showing the products.
    const fetchDistributorProducts = async (distId) =>{
        try{
            const response = await fetch(`http://localhost/distributorHub/showDistributorProfileProducts.php?distId=${distId}`);
            const data = await response.json();
            if(data.success){
                distributorsProducts.value = data.data;
            }
            else{
                console.error(data.message);
            }
        }catch(error){
            console.error("Error Fetching Data", error)
        }
    }
    //deleting a product
    const deleteProduct = async (product) => {
    currentProduct.value = product;
    try {
        const response = await fetch(`http://localhost/distributorHub/productDelete.php`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ prodId: currentProduct.value.prodId }),
        });
        if (!response.ok) {
            throw new Error('Failed to delete');
        }
        const result = await response.json();
        const distId = localStorage.getItem('userId'); // Retrieve the correct distId
        await fetchDistributorProducts(distId); // Refresh the products list
        console.log(result);
    } catch (error) {
        console.error(error);
    }
};

    onMounted(() => {
    const distId = localStorage.getItem('userId');
    fetchDistributorProducts(distId);
    });

</script>
<template>
    <div class="distributor-products">
        <div class="distributor-products-cont">
            <h3>My Products:</h3>
            <div v-for="(product,index) in distributorsProducts" :key="product.prodId" class="distributor-products-box">
                <div class="distributor-products-image">
                    <img :src="`http://localhost/${product.prodImage}`"  alt="">
                </div>
                <div class="distributor-products-details">
                    <div class="distributor-products-details-subtitle"><strong>Product Name: </strong>{{product.prodName}}</div>
                    <div class="distributor-products-details-subtitle"><strong>Product Type: </strong>{{product.prodType}}</div>
                    <div class="distributor-products-details-subtitle"><strong>Product Category: </strong>{{product.prodCategory}}</div>
                    <div class="distributor-products-details-subtitle"><strong>Product Minimum Quantity: </strong>{{product.prodMinQtn}}</div>
                    <div class="distributor-products-details-subtitle"><strong>Product Per Piece Price: </strong>{{product.prodPerPiecePrice}}</div>
                    <div class="distributor-products-details-subtitle"><strong>Product Company: </strong>{{product.prodCompany}}</div>
                </div>
                <div class="distributor-products-edit-btn">
                    <button v-on:click="deleteProduct(product)" class="distributor-products-editBtn">Remove</button>
                </div>
            </div>
            <div class="distributor-products-buttons">
                    <button v-on:click="toggleOverlay()" class="distributor-products-addItem-btn">Add Item</button>
            </div>
        </div>
        <!-- Product Add -->
        <div v-if="showOverlay" class="distributor-add-item-overlay">
            <div class="add-item-form-container">
            <form @submit.prevent="handleSubmit" class="add-item-form">
                <div class="add-item-product-pic">
                    <input class="prod-pic" type= "file" @change="handleFileUpload">
                </div>
                <div class="add-item-form-group">
                    <input v-model="productName" type="text" placeholder="product name *" required>
                </div>
                <div class="add-item-form-group">
                    <input v-model="productMinQtn" type="text" placeholder="Product minimum quantity *" required>
                </div>
                <div class="add-item-form-group">
                    <input v-model="productPricePerPiece" type="text" placeholder="Product Per piece price *" required>
                </div>
                <div class="add-item-form-group">
                    <select v-model="productRegion" required>
                        <option value="" disabled >Product Region *</option>
                        <option value="Region 1">Region 1</option>
                        <option value="Region 2">Region 2</option>
                        <option value="Region 3">Region 3</option>
                       <!--  <option value="Region 4">Region 4</option>
                        <option value="Region 5">Region 5</option>
                        <option value="Region 6">Region 6</option> -->
                    </select>
                </div>
                <div class="add-item-form-group">
                    <select v-model="productCompany" required>
                        <option value="" disabled >Product Company *</option>
                        <option value="Pran">Pran</option>
                        <option value="Radhuni">Radhuni</option>
                        <option value="Fresh">Fresh</option>
                        <option value="Teer">Teer</option>
                        <option value="ACI">ACI</option>
                        <option value="Chashi">Chashi</option>
                        <option value="Shan">Shan</option>
                        <option value="Rupchanda">Rupchanda</option>
                        <option value="Saffola">Saffola</option>
                        <option value="Ruchi">Ruchi</option>
                        <option value="Amul">Amul</option>
                        <option value="Cadbury">Cadbury</option>
                        <option value="Doodles">Doodles</option>
                        <option value="Mr.Noodles">Mr.Noodles</option>
                        <option value="Detos">Detos</option>
                        <option value="Sun">Sun</option>
                        <option value="Kurkure">Kurkure</option>
                        <option value="Kolson">Kolson</option>
                        <option value="Mojo">Mojo</option>
                        <option value="Clemon">Clemon</option>
                        <option value="Marks">Marks</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Starship">Starship</option>
                        <option value="Milk Vita">Milk Vita</option>
                    </select>
                </div>
                <div class="add-item-form-group">

                    <select v-model="productType" required>
                        <option value="" disabled>Product Type *</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
                <div class="add-item-form-group">
                    <select v-model="productCategory" required>
                        <option value="" disabled >Product Category *</option>
                        <option value="Snacks">Snacks</option>
                        <option value="Sausces and Pickles">Sausces and Pickles</option>
                        <option value="Cooking">Cooking</option>
                        <option value="Dairy Items">Dairy Items</option>
                        <option value="Candy and Chocolate">Candy and Chocolate</option>
                    </select>
                </div>
                <button type="submit" class="add-item-btn-submit">Confirm</button>
            </form>
            </div>
        </div>
    </div>
</template>