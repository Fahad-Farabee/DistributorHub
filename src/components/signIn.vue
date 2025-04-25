<script setup>
        import {ref} from 'vue';
        import { useRouter } from 'vue-router';
        const contnum = ref("");
        const pass = ref("");
        const route = useRouter();

        const handleSignIn = async ()=>{
            try{
                const response = await fetch("http://localhost/distributorHub/signIn.php",{
                    method: 'POST',
                    headers: {
                        'Content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        contnum: contnum.value,
                        pass: pass.value,
                    }),
                });
                const result = await response.json();
                console.log(result);
                if(result.success){
                    alert("You logged in successfully");
                    localStorage.setItem('userId', result.user_id); 
                    localStorage.setItem('userType', result.user_type);
                    if(result.user_type === "retailer"){
                        localStorage.setItem('userRegion',result.user_region);
                        console.log(localStorage.getItem('userRegion'));
                        route.push('/retailer/profile');
                    }
                    else if(result.user_type === "distributor"){
                        route.push('/distributor/profile');
                    }
                }
                else{
                    alert("wrong credentials.!!!");
                }
            }
            catch(error){
                console.error("Error Logging in :" , error);
                alert("Something went wrong . Please try again later!!!");
            }
        };
        
</script>

<template>
    <div class="login">
        <div class="login-container">
            <form @submit.prevent="handleSignIn" class="login-form">
                <div class="form-group">
                    <label for="phone">
                        <span class="icon">📞</span>
                        <input v-model="contnum" type="text" id="phone" placeholder="Phone Number" required>
                    </label>
                </div>
                <div class="form-group">
                    <label for="password">
                        <span class="icon">🔒</span>
                        <input v-model="pass" type="password" id="password" placeholder="Password" required>
                    </label>
                </div>
                <button type="submit" class="btn-login">Log In</button>
            </form>
        </div>
    </div>
</template>