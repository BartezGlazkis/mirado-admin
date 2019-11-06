<template>
  <div class="container mb-4">
    <b-form inline @submit="getPositions">
      <select
        v-model="selectedCategory"
        v-on:change="getSubCategories(selectedCategory)"
        name="category"
        class="form-control mb-2 mr-sm-2 mb-sm-0"
      >
        <option
          v-for="category in categories"
          v-bind:key="category.id"
          :value="category.id"
          :disabled="category.id == 0"
          :selected="category.id == 0"
        >{{category.name}}</option>
      </select>
      <select name="subCategory" class="form-control mb-2 mr-sm-2 mb-sm-0">
        <option
          v-for="subCategory in subCategories"
          v-bind:key="subCategory.id"
          :value="subCategory.id"
          :disabled="subCategory.id == 0"
          :selected="subCategory.id == 0"
        >{{subCategory.name}}</option>
      </select>
      <b-input name="keyword" class="mb-2 mr-sm-2 mb-sm-0" placeholder="Введите слово"></b-input>
      <b-button type="submit" variant="primary">Показать</b-button>
    </b-form>
  </div>
</template>
<script>
export default {
  data() {
    return {
      selectedCategory: 0,
      categories: [{ id: 0, name: "Выберите категорию" }],
      subCategories: [{ id: 0, name: "Выберите подкатегорию" }]
    };
  },
  mounted() {
    this.getCategories();
  },
  methods: {
    getCategories: function() {
      axios.get("/categories/get").then(response => {
        this.categories = this.categories.concat(response.data);
      });
    },
    getSubCategories: function(selectedCategory) {
      this.subCategories = [{ id: 0, name: "Выберите подкатегорию" }];
      axios.get("/subcategories/get/" + selectedCategory).then(response => {
        if (response.data.length > 0) {
          this.subCategories = this.subCategories.concat(response.data);
        }
      });
    },
    getPositions: function(evt) {
      evt.preventDefault();
      this.$emit("get-positions", evt.target);
    }
  }
};
</script>