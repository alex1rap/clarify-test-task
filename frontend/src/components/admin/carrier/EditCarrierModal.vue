<script setup>
import {defineProps, ref, watch} from 'vue';
import {BCol, BRow, BTable} from "bootstrap-vue-next";

const props = defineProps(['showModal', 'cancel', 'carrier', 'updateCarrier', 'getDeliveryRuleTypeLabel']);

const showModal = ref(props.showModal);
const carrier = ref(props.carrier);

let editingRule = ref(null); // посилання на обране для редагування правило

// Функція для відкриття модального вікна для редагування
const editRule = (rule) => {
  editingRule.value = rule; // зберігаємо посилання на обране правило
};

// Функція для закриття модального вікна для редагування
const saveRule = () => {
  editingRule.value = null; // знімаємо посилання на редаговане правило
};

// Функція для перевірки, чи правило редагується
const isEditing = (rule) => {
  console.log('isEditing', rule, editingRule.value)
  return rule === editingRule.value;
};

const deleteRule = (rule) => {
  // Обробник для видалення правила
  console.log('Видаляємо правило:', carrier, rule);

  carrier.value.deliveryRules = carrier.value?.deliveryRules.filter(r => r !== rule);
};

const fields = [
  {key: 'type', label: 'Type'},
  {key: 'value', label: 'Value'},
  {key: 'formula', label: 'Formula'},
  {key: 'actions', label: 'Actions'},
];

watch(() => props.showModal, (value) => {
  showModal.value = value;
});

watch(() => props.carrier, (value) => {
  carrier.value = value;
});

const handleSubmit = async (e) => {

  if (e.submitter.id !== 'save-carrier') return;
  // Обробник для збереження даних і закриття модального вікна
  // Тут ви можете виконати відправку даних на сервер або виконати інші дії
  await props.updateCarrier(carrier.value).finally(() => {
    showModal.value = false;
    carrier.value = null;
  });
  console.log('Збережено:', carrier);
};
</script>

<template>
  <div>
    <!-- Модальне вікно -->
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <!-- Форма редагування -->
        <form @submit.prevent="handleSubmit">
          <div class="input-group">
            <div class="input-group-prepend">
              <label class="form-text" for="carrier-title">Title:</label>
            </div>
            <input class="form-control" v-model="carrier.title" type="text" required id="carrier-title">
          </div>

          <h3>Rules:</h3>

          <b-table :items="carrier.deliveryRules" :fields="fields">
            <template #cell(type)="row">
              <b-row v-if="isEditing(row.item)">
                <b-col>
                  <select v-model="row.item.type" class="form-control">
                    <option value="eq">Equal to</option>
                    <option value="gt">Greater than</option>
                    <option value="gte">Greater than or equal</option>
                    <option value="lt">Less than</option>
                    <option value="lte">Less than or equal</option>
                  </select>
                </b-col>
              </b-row>
              <b-row v-else>
                <b-col>
                  {{ getDeliveryRuleTypeLabel(row.item.type) }}
                </b-col>
              </b-row>
            </template>
            <template #cell(value)="row">
              <b-row v-if="isEditing(row.item)">
                <b-col>
                  <input v-model="row.item.value" type="number" class="form-control" required>
                </b-col>
              </b-row>
              <b-row v-else>
                <b-col>
                  {{ row.item.value }}
                </b-col>
              </b-row>
            </template>
            <template #cell(formula)="row">
              <b-row v-if="isEditing(row.item)">
                <b-col>
                  <input v-model="row.item.formula" type="text" class="form-control" required>
                </b-col>
              </b-row>
              <b-row v-else>
                <b-col>
                  {{ row.item.formula }}
                </b-col>
              </b-row>
            </template>
            <template #cell(actions)="row">
              <button class="btn btn-secondary" @click="saveRule()" v-if="isEditing(row.item)">Save</button>
              <button class="btn btn-secondary" @click="editRule(row.item)" v-else>Edit</button>
              <button class="btn btn-danger" @click="deleteRule(row.item)">Delete</button>
            </template>
          </b-table>

          <b-row align-h="between">
            <b-col cols="4">
              <button class="btn btn-secondary" type="button"
                      @click="carrier.deliveryRules.push({type: 'gt', value: 0, formula: 'kg * 10'})">Add Rule
              </button>
            </b-col>
            <b-col cols="4">
              <button class="btn btn-primary" id="save-carrier" type="submit">Save</button>
              <button class="btn btn-danger" type="reset" @click="props.cancel">Cancel</button>
            </b-col>
          </b-row>
        </form>
      </div>
    </div>
  </div>
</template>

<style>
/* Стилі для модального вікна */
.modal {
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fff;
  min-width: 360px;
  width: 100%;
  max-width: 640px;
  margin: 100px auto;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

input {
  display: block;
  margin-bottom: 10px;
}
</style>
