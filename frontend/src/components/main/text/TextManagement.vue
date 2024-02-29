<script setup>

import MainPage from "@/pages/MainPage.vue";
import {ref, watch} from "vue";
import Api from "@/services/api";
import {BTable} from "bootstrap-vue-next";

const text = ref(null);
const parserType = ref('tags');
const result = ref(null);

const parseText = async () => {
  switch (parserType.value) {
    case 'tags':
      console.log('Parsing tags:', text.value);
      await Api.parseTextTags(text.value).then((response) => {
        result.value = response;
        console.log('Parsed tags:', response);
      });
      break;
    case 'keys':
      console.log('Parsing keys:', text.value);
      await Api.parseTextKeys(text.value).then((response) => {
        result.value = response;
        console.log('Parsed keys:', response);
      });
      break;
  }
};

watch(() => text.value, (value) => {
  console.log('Text changed:', value);
});

watch(() => parserType.value, (value) => {
  console.log('Parser type changed:', value);
});

</script>

<template>
  <MainPage>
    <div>
      <h1>Text Parser</h1>
      <h3>
        Parse Text
      </h3>

      <form @submit.prevent="parseText">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label for="text" id="text-label" class="input-group-text">Text:</label>
          </div>
          <textarea id="text" name="text" class="form-control" required v-model="text"
                    aria-describedby="text-label"></textarea>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <label for="type" id="type-label" class="input-group-text">Parser Type:</label>
          </div>
          <select v-model="parserType" name="parser_type" id="type" class="form-control">
            <option value="tags">Tags</option>
            <option value="keys">Keys</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Parse</button>
      </form>

      <div id="result" v-if="result">
        <h3>Result:</h3>
        <pre>{{ result }}</pre>
      </div>
    </div>
  </MainPage>
</template>
