<script setup>
import {getCurrentInstance} from 'vue'
import pageTitle from "./components/PageTitle";
import {useRoute, useRouter} from "vue-router";

const _route = useRoute()
const router = useRouter()

const _app = getCurrentInstance()

// Change page title
router.afterEach(async (to, _) => {
  document.title = pageTitle(to.meta?.title)
})

</script>

<template>
  <router-view></router-view>
</template>
