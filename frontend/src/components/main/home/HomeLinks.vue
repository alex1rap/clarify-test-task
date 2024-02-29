<script setup>

import MainPage from "@/pages/MainPage.vue";
</script>

<template>
  <MainPage>
    <div>
      <h1>Home</h1>
    </div>

    <div>
      <h3>
        Links
      </h3>
      <ul>
        <li>
          <router-link :to="{name: 'DeliveryCost'}">Delivery Cost</router-link>
        </li>
        <li>
          <router-link :to="{name: 'TextManagement'}">Text Management</router-link>
        </li>
      </ul>
    </div>
  </MainPage>
</template>
