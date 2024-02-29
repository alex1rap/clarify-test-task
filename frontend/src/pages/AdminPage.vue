<script setup>
import {
  BContainer,
  BRow,
  BCol,
  BNavbar,
  BNavbarBrand,
  BNavbarToggle,
  BNavbarNav,
  BNavItem,
  BCollapse
} from 'bootstrap-vue-next';
import Sidebar from "@/components/AdminSidebar.vue";
</script>

<template>
  <b-container fluid>
    <b-row>
      <b-col>
        <b-navbar toggleable="md" type="light" variant="light">
          <b-navbar-brand :to="{name: 'Home'}">Zoo</b-navbar-brand>

          <b-navbar-toggle target="nav-collapse" disabled></b-navbar-toggle>

          <b-collapse id="nav-collapse" is-nav class="d-flex justify-content-between">
            <b-navbar-nav class="ml-auto">
              <b-nav-item :to="{name: 'Dashboard'}">Dashboard</b-nav-item>
              <b-nav-item :to="{name: 'CarrierList'}">Carriers</b-nav-item>
            </b-navbar-nav>
            <b-navbar-nav class="ml-auto">
              <b-nav-item :to="{name: 'Home'}">Home</b-nav-item>
            </b-navbar-nav>
          </b-collapse>
        </b-navbar>
      </b-col>
    </b-row>

    <b-row>
      <b-col cols="2">
        <Sidebar></Sidebar>
      </b-col>
      <b-col cols="10" class="mt-3">
        <slot></slot>
      </b-col>
    </b-row>
  </b-container>
</template>

