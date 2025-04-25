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
        const response = await fetch(`http://localhost/distributorHub/showDistributorProfile.php?userId=${userId}`);
        const data = await response.json();
        if (data.success) {
            profileInfo.value = data.data;
            console.log(profileInfo.value);
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
    name: profileInfo.value.disUserName,
    strname: profileInfo.value.disStoreName,
    straddr: profileInfo.value.disStoreAddress,
    division: profileInfo.value.disDivision,
    district: profileInfo.value.disDistrict,
    city: profileInfo.value.disCity,
  };
  try {
    const response = await fetch("http://localhost/distributorHub/distributorEditProfile.php", {
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
  <div class="distributor-profile-details">
    <div class="distributor-profile-details-cont">
      <div class="distributor-profile-details-image">
        <img :src="`http://localhost/${profileInfo.disProfilePic}`" alt="Profile Picture" />
      </div>
      <div class="distributor-profile-details-info">
        <div class="distributor-profile-details-subtitle">
          <strong>Name: </strong>{{ profileInfo.disUserName }}
        </div>
        <div class="distributor-profile-details-subtitle">
          <strong>Store Name: </strong>{{ profileInfo.disStoreName }}
        </div>
        <div class="distributor-profile-details-subtitle">
          <strong>Store Address: </strong>{{ profileInfo.disStoreAddress }}
        </div>
        <div class="distributor-profile-details-subtitle">
          <strong>Contact No: </strong>{{ profileInfo.disContactNumber }}
        </div>
        <div class="distributor-profile-details-subtitle">
          <strong>Division: </strong>{{ profileInfo.disDivision }}
        </div>
        <div class="distributor-profile-details-subtitle">
          <strong>District: </strong>{{ profileInfo.disDistrict }}
        </div>
        <div class="distributor-profile-details-subtitle">
          <strong>City: </strong>{{ profileInfo.disCity }}
        </div>
      </div>
      <div class="distributor-profile-details-edit">
        <button @click="toggleOverlay" class="distributor-profile-details-edit-btn">
          Edit
        </button>
      </div>
    </div>

    <div v-if="showOverlay" class="distributor-edit-profile-overlay">
      <div class="distributor-edit-profile-overlay-cont">
        <form @submit.prevent="handleSubmit" class="distributor-edit-profile-form">
          <div class="distributor-edit-profile-form-group">
            <input v-model="profileInfo.disUserName" type="text" placeholder="Enter your name *" />
          </div>
          <div class="distributor-edit-profile-form-group">
            <input v-model="profileInfo.disStoreName" type="text" placeholder="Store Name *" />
          </div>
          <div class="distributor-edit-profile-form-group">
            <input v-model="profileInfo.disStoreAddress" type="text" placeholder="Store Address *" />
          </div>
          <div class="distributor-edit-profile-form-group">
            <select v-model="profileInfo.disDivision">
              <option value="" disabled>Division *</option>
              <option value="division1">Division 1</option>
              <option value="division2">Division 2</option>
              <option value="division3">Division 3</option>
            </select>
          </div>
          <div class="distributor-edit-profile-form-group">
            <select v-model="profileInfo.disDistrict">
              <option value="" disabled>District *</option>
              <option value="district1">District 1</option>
              <option value="district2">District 2</option>
              <option value="district3">District 3</option>
            </select>
          </div>
          <div class="distributor-edit-profile-form-group">
            <select v-model="profileInfo.disCity">
              <option value="" disabled>City *</option>
              <option value="city1">City 1</option>
              <option value="city2">City 2</option>
              <option value="city3">City 3</option>
            </select>
          </div>
          <button type="submit" class="edit-profile-btn-submit">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</template>