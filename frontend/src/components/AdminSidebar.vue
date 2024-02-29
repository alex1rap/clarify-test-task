<script setup>
</script>

<template>
  <div class="sidebar">
    <div class="sidebar-header">
      Zoo Admin
    </div>
    <ul class="nav btn-group-vertical">
      <li class="nav-item">
        <router-link :to="{name: 'Dashboard'}" class="nav-link">Dashboard</router-link>
      </li>
      <li class="nav-item">
        <router-link :to="{name: 'CarrierList'}" class="nav-link">Carriers</router-link>
      </li>
      <!-- Додайте сюди інші пункти меню -->
    </ul>
  </div>
</template>

<style>
.sidebar {
  background-color: #f5f5f5;
  padding: 20px;
}

.sidebar-header {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 20px;
}

.nav {
  list-style: none;
  padding: 0;
}

.nav-item {
  margin-bottom: 10px;
}

.nav-link {
  text-decoration: none;
  color: #333;
}

.nav-link:hover {
  color: #007bff;
}
</style>
