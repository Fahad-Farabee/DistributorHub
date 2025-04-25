<script setup>
    import { ref } from 'vue';
    const name = ref("");
    const contnum = ref("");
    const nidnum = ref("");
    const strname = ref("");
    const straddr = ref("");
    const tradelicnum = ref("");
    const division = ref("");
    const district = ref("");
    const city = ref("");
    const region = ref("");
    const pass = ref("");
    const profilePicture = ref(null);
    //handling file method.
    const handleFileUpload = (event) =>{
        profilePicture.value = event.target.files[0];
    }
    //fetching the retailer sign up 
    const handleSubmit = async () =>{
    try{
        console.log("hello");
        const data = new FormData();
        data.append("name", name.value);
        data.append("contnum", contnum.value);
        data.append("nidnum", nidnum.value);
        data.append("strname", strname.value);
        data.append("straddr", straddr.value);
        data.append("tradelicnum", tradelicnum.value);
        data.append("division", division.value);
        data.append("district", district.value);
        data.append("city", city.value);
        data.append("region", region.value);
        data.append("pass", pass.value);
        if (profilePicture.value) {
            data.append("profilePicture", profilePicture.value);
        }
        const response = await fetch("http://localhost/distributorHub/distributorSignUp.php", {
            method: 'POST',
            body: data
        });
        if(!response.ok){
            throw new Error ("failed to upload data"); 
        } 
        const result = await response.json();
        console.log("Server Response: ", result);
        alert("Data uploaded successfully!!!");
    }catch(error){
        console.error("Error Uploading data: ", error);
        alert("Failed to upload data. Please try again");
    }
}
</script>

<template>
    <div class="Signup">
        <div class="form-container">
            <form @submit.prevent="handleSubmit" class="registration-form">
                <div class="profile-pic">
                    <input type= "file" @change="handleFileUpload">
                </div>
                <div class="form-group">
                    <input v-model="name" type="text" placeholder="Enter your name *" required>
                </div>
                <div class="form-group">
                    <input v-model="contnum" type="text" placeholder="Contact No *" required>
                </div>
                <div class="form-group">
                    <input v-model="nidnum" type="text" placeholder="NID No *" required>
                </div>
                <div class="form-group">
                    <input v-model="strname" type="text" placeholder="Store Name *" required>
                </div>
                <div class="form-group">
                    <input v-model="straddr" type="text" placeholder="Store Address *" required>
                </div>
                <div class="form-group">
                    <input v-model="tradelicnum" type="text" placeholder="Trade License No *" required>
                </div>
                <div class="form-group">
                    <select v-model="division" required>
                        <option value="" disabled >Division *</option>
                        <option value="division1">Division 1</option>
                        <option value="division2">Division 2</option>
                        <option value="division3">Division 3</option>
                    </select>
                </div>
                <div class="form-group">
                    <select v-model="district" required>
                        <option value="" disabled >District *</option>
                        <option value="district1">District 1</option>
                        <option value="district2">District 2</option>
                        <option value="district3">District 3</option>
                    </select>
                </div>
                <div class="form-group">
                    <select v-model="city" required>
                        <option value="" disabled >City *</option>
                        <option value="city1">City 1</option>
                        <option value="city2">City 2</option>
                        <option value="city3">City 3</option>
                    </select>
                </div>
                <div class="form-group">
                    <input v-model="pass" type="password" placeholder="Password *" required>
                </div>
                <button type="submit" class="btn-submit">Confirm</button>
            </form>
        </div>
    </div>
</template> 



