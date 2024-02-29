<script setup>
import {onMounted, ref, watch} from 'vue';
import EditCarrierModal from '@/components/admin/carrier/EditCarrierModal.vue';
import AdminPage from "@/pages/AdminPage.vue";
import Api from "@/services/api";
import {BCol, BRow, BTable} from "bootstrap-vue-next";

const carriers = ref([]);
const editModalVisible = ref(false);
const selectedCarrier = ref(null);

const editCarrier = (carrier) => {
  selectedCarrier.value = carrier;
  editModalVisible.value = true;
};

const closeEditModal = () => {
  selectedCarrier.value = null;
  editModalVisible.value = false;
};

const addCarrier = async () => {
  selectedCarrier.value = null;
  editModalVisible.value = false;
  await Api.createCarrier({
    title: 'New Carrier',
    deliveryRules: [],
  }).then((response) => {
    carriers.value.push(response);
    console.log('Carrier added:', response);
  }).finally(() => {
    selectedCarrier.value = null;
    editModalVisible.value = false;
  });
};

const fields = [
  {key: 'id', label: 'Carrier ID'},
  {key: 'title', label: 'Carrier Title'},
  {
    key: 'deliveryRules',
    label: 'Delivery Rules',
  },
  {key: 'actions', label: 'Actions'},
];

const deleteCarrier = async (carrier) => {
  console.log('Deleting carrier:', carrier)
  await Api.deleteCarrier(carrier).then((_) => {
    carriers.value = carriers.value.filter(c => c !== carrier);
    console.log('Carrier deleted:', carrier);
  }).finally(() => {
    selectedCarrier.value = null;
    editModalVisible.value = false;
  });
};

const updateCarrier = async (carrier) => {
  console.log('Updating carrier:', carrier)
  await Api.updateCarrier(carrier).then((response) => {
    console.log('Carrier updated:', response);
  }).finally(() => {
    selectedCarrier.value = null;
    editModalVisible.value = false;
  });
};

const loadCarriers = async () => {
  await Api.getCarriers().then((response) => {
    carriers.value = response;
    console.log('Carriers loaded:', carriers.value);
  }).finally(() => {
    selectedCarrier.value = null;
    editModalVisible.value = false;
  });
};

const getDeliveryRuleTypeLabel = (type) => {
  switch (type) {
    case 'eq':
      return 'Equal to';
    case 'gt':
      return 'Greater than';
    case 'gte':
      return 'Greater than or equal';
    case 'lt':
      return 'Less than';
    case 'lte':
      return 'Less than or equal';
    default:
      return type;
  }
};

onMounted(async () => {
  await loadCarriers();
});

watch(carriers, (value) => {
  console.log('Carriers changed:', value);
});

</script>
<template>
  <AdminPage class="container-fluid">
    <div>
      <h1>Carriers</h1>
      <b-table striped hover :items="carriers" :fields="fields">
        <template #cell(deliveryRules)="row">
          <b-row v-for="(rule, index) in row.item.deliveryRules" :key="index">
            <b-col>
              {{ getDeliveryRuleTypeLabel(rule.type) }} <span class="text-success">{{ rule.value }}</span>
              kg: <span class="text-danger">{{ rule.formula }}</span> EUR
            </b-col>
          </b-row>
          <b-row v-if="!row.item.deliveryRules.length">
            <b-col class="bg-warning text-bg-warning">
              No delivery rules yet
            </b-col>
          </b-row>
        </template>
        <template #cell(actions)="row">
          <b-row>
            <b-col>
              <button class="btn btn-secondary" @click="editCarrier(row.item)">Edit</button>
            </b-col>
            <b-col>
              <button class="btn btn-danger" @click="deleteCarrier(row.item)">Delete</button>
            </b-col>
          </b-row>
        </template>
      </b-table>
      <button class="btn btn-primary" @click="addCarrier">Add Carrier</button>

      <EditCarrierModal v-if="selectedCarrier" :carrier="selectedCarrier" :showModal="editModalVisible"
                        :updateCarrier="updateCarrier" @close="closeEditModal"
                        :getDeliveryRuleTypeLabel="getDeliveryRuleTypeLabel" :cancel="loadCarriers"/>
    </div>
  </AdminPage>
</template>
