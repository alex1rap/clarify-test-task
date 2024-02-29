<script setup>

import MainPage from "@/pages/MainPage.vue";
import {onMounted, ref, watch} from "vue";
import Api from "@/services/api";

const carriers = ref([]);
const selectedCarrierId = ref(null);

const weight = ref(null);
const calculatedCost = ref(null);

const loadCarriers = async () => {
  await Api.getCarriers().then((response) => {
    carriers.value = response;
    console.log('Carriers loaded:', response);
  });
};

onMounted(async () => {
  await loadCarriers();
});

watch(carriers, (value) => {
  console.log('Carriers changed:', value);
});

const calculate = async (carrierId) => {
  if (!carrierId) return;
  const carrier = carriers.value.find(c => c.id === carrierId);
  if (!carrier) return;
  calculatedCost.value = await Api.getDeliveryCost(carrier, weight.value);
  console.log('Calculate delivery cost for carrier:', carrier.title);
};

</script>

<template>
  <MainPage>
    <div>
      <h1>Delivery Cost</h1>
      <h3>
        Calculate Delivery Cost for Carrier
      </h3>
      <form @submit.prevent="calculate(selectedCarrierId)">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label for="weight" id="weight-label" class="input-group-text">Weight in kg:</label>
          </div>
          <input type="number" id="weight" name="weight" class="form-control" required min="1" v-model="weight"
                 aria-describedby="weight-label">
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label for="carrier" id="carrier-label" class="input-group-text">Carrier:</label>
          </div>
          <select name="carrier" id="carrier" required class="form-control" v-model="selectedCarrierId"
                  aria-describedby="carrier-label">
            <option disabled selected>Select carrier</option>
            <option v-for="carrier in carriers" :key="carrier.id" :value="carrier.id">
              {{ carrier.title }}
            </option>
          </select>
        </div>
        <button type="submit" class="btn form-control btn-primary">Calculate</button>
      </form>

      <div v-if="calculatedCost">
        <h3>Calculated Delivery Cost:</h3>
        <p>{{ calculatedCost.cost }} EUR</p>
        <p>with formula "{{ calculatedCost.rule.formula }}"</p>
      </div>
    </div>
  </MainPage>
</template>

<style scoped>

</style>
