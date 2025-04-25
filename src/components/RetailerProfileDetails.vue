<script setup>
import { ref, onMounted } from "vue";

const showOverlay = ref(false);
const profileInfo = ref({}); // Object to store profile details

// Toggle the overlay visibility
const toggleOverlay = () => {
  showOverlay.value = !showOverlay.value;
};

// Fetch profile details
const fetchProfileInfo = async () => {
  const userId = localStorage.getItem("userId");
  if (!userId) {
    alert("User ID not found. Please log in again.");
    return;
  }

  try {
    const response = await fetch(
      `http://localhost/distributorHub/showRetailerProfile.php?userId=${userId}`
    );
    const data = await response.json();
    if (data.success) {
      profileInfo.value = data.data;
    } else {
      console.error(data.message);
    }
  } catch (error) {
    console.error("Error fetching profile:", error);
  }
};

// Update profile details
const handleSubmit = async () => {
  const userId = localStorage.getItem("userId");
  if (!userId) {
    alert("User ID not found. Please log in again.");
    return;
  }

  const updatedData = {
    id: userId,
    name: profileInfo.value.userName,
    strname: profileInfo.value.storeName,
    straddr: profileInfo.value.storeAddress,
    division: profileInfo.value.division,
    district: profileInfo.value.district,
    city: profileInfo.value.city,
    region: profileInfo.value.region,
  };

  try {
    const response = await fetch("http://localhost/distributorHub/test.php", {
      method: "PATCH",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(updatedData),
    });

    const result = await response.json();

    if (result.success) {
      alert("Profile updated successfully!");
      fetchProfileInfo(); // Refresh the profile data
      toggleOverlay(); // Close the overlay
    } else {
      console.error(result.message);
    }
  } catch (error) {
    console.error("Error updating profile:", error);
  }
};

onMounted(fetchProfileInfo);
</script>

<template>
  <div class="retailer-profile-details">
    <div class="retailer-profile-details-cont">
      <div class="retailer-profile-details-image">
        <img :src="`http://localhost/${profileInfo.retailerProfilePic}`" alt="Profile Picture" />
      </div>
      <div class="retailer-profile-details-info">
        <div class="retailer-profile-details-subtitle">
          <strong>Name: </strong>{{ profileInfo.userName }}
        </div>
        <div class="retailer-profile-details-subtitle">
          <strong>Store Name: </strong>{{ profileInfo.storeName }}
        </div>
        <div class="retailer-profile-details-subtitle">
          <strong>Store Address: </strong>{{ profileInfo.storeAddress }}
        </div>
        <div class="retailer-profile-details-subtitle">
          <strong>Contact No: </strong>{{ profileInfo.contactNumber }}
        </div>
        <div class="retailer-profile-details-subtitle">
          <strong>Region: </strong>{{ profileInfo.region }}
        </div>
        <div class="retailer-profile-details-subtitle">
          <strong>Division: </strong>{{ profileInfo.division }}
        </div>
        <div class="retailer-profile-details-subtitle">
          <strong>District: </strong>{{ profileInfo.district }}
        </div>
        <div class="retailer-profile-details-subtitle">
          <strong>City: </strong>{{ profileInfo.city }}
        </div>
      </div>
      <div class="retailer-profile-details-edit">
        <button @click="toggleOverlay" class="retailer-profile-details-edit-btn">
          Edit
        </button>
      </div>
    </div>

    <div v-if="showOverlay" class="edit-profile-overlay">
      <div class="edit-profile-overlay-cont">
        <form @submit.prevent="handleSubmit" class="edit-profile-form">
          <div class="edit-profile-form-group">
            <input v-model="profileInfo.userName" type="text" placeholder="Enter your name *" />
          </div>
          <div class="edit-profile-form-group">
            <input v-model="profileInfo.storeName" type="text" placeholder="Store Name *" />
          </div>
          <div class="edit-profile-form-group">
            <input v-model="profileInfo.storeAddress" type="text" placeholder="Store Address *" />
          </div>
          <div class="edit-profile-form-group">
            <select v-model="profileInfo.division">
              <option value="" disabled>Division *</option>
              <option value="Division 1">Division 1</option>
              <option value="Division 2">Division 2</option>
              <option value="Division 3">Division 3</option>
            </select>
          </div>
          <div class="edit-profile-form-group">
            <select v-model="profileInfo.district">
              <option value="" disabled>District *</option>
              <option value="District 1">District 1</option>
              <option value="District 2">District 2</option>
              <option value="District 3">District 3</option>
            </select>
          </div>
          <div class="edit-profile-form-group">
            <select v-model="profileInfo.city">
              <option value="" disabled>City *</option>
              <option value="City 1">City 1</option>
              <option value="City 2">City 2</option>
              <option value="City 3">City 3</option>
            </select>
          </div>
          <div class="edit-profile-form-group">
            <select v-model="profileInfo.region">
              <option value="" disabled>Region *</option>
              <option value="Region 1">Region 1</option>
              <option value="Region 2">Region 2</option>
              <option value="Region 3">Region 3</option>
            </select>
          </div>
          <button type="submit" class="edit-profile-btn-submit">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</template>
