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
              <b-nav-item :to="{name: 'Home'}">Home</b-nav-item>
              <b-nav-item :to="{name: 'DeliveryCost'}">Delivery Cost</b-nav-item>
              <b-nav-item :to="{name: 'TextManagement'}">Text Parser</b-nav-item>
            </b-navbar-nav>
            <b-navbar-nav class="ml-auto">
              <b-nav-item :to="{name: 'Dashboard'}">Admin panel</b-nav-item>
            </b-navbar-nav>
          </b-collapse>
        </b-navbar>
      </b-col>
    </b-row>
  </b-container>
  <b-container class="mt-3">
    <b-row>
      <b-col cols="10">
        <slot></slot>
      </b-col>
    </b-row>
  </b-container>
</template>
