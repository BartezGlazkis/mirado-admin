<template>
  <div>
    <i class="far fa-plus-circle text-primary" @click="shown"></i>

    <b-modal v-model="show" hide-footer title="Добавить позицию">
      <b-form @submit="addPrice">
        <label>Наименование</label>
        <b-input required name="name" class="mb-2 mr-sm-2"></b-input>

        <label>Артикуль</label>
        <b-input required name="art" class="mb-2 mr-sm-2"></b-input>

        <label>Поставщик</label>
        <select name="supplier" class="form-control mb-2 mr-sm-2">
          <option
            v-for="supplier in suppliers"
            v-bind:key="supplier.id"
            :value="supplier.id"
            :disabled="supplier.id == 0"
            :selected="supplier.id == 0"
          >{{supplier.name}}</option>
        </select>

        <label>Производитель</label>
        <select required name="manufacturer" class="form-control mb-2 mr-sm-2">
          <option
            v-for="manufacturer in manufacturers"
            v-bind:key="manufacturer.id"
            :value="manufacturer.id"
            :disabled="manufacturer.id == 0"
            :selected="manufacturer.id == 0"
          >{{manufacturer.name}}</option>
        </select>

        <label>Цена</label>
        <b-input required name="priceYE" type="number" class="mb-2 mr-sm-2"></b-input>

        <label>Ед.измерения</label>
        <select required name="unit" class="form-control mb-2 mr-sm-2">
          <option
            v-for="unit in units"
            v-bind:key="unit.id"
            :value="unit.id"
            :disabled="unit.id == 0"
            :selected="unit.id == 0"
          >{{unit.name}}</option>
        </select>

        <label>Фото</label>
        <b-form-file
          required
          name="link_img"
          class="mb-2 mr-sm-2"
          accept=".jpg, .png, .gif"
          placeholder="Выберите фото"
        ></b-form-file>

        <label>Категория</label>
        <select
          v-model="selectedCategory"
          @change="getSubCategories(selectedCategory)"
          required
          name="category"
          class="form-control mb-2 mr-sm-2"
        >
          <option
            v-for="category in categories"
            v-bind:key="category.id"
            :value="category.id"
            :disabled="category.id == 0"
            :selected="category.id == 0"
          >{{category.name}}</option>
        </select>

        <label>Подкатегория</label>
        <select
          required
          name="subcategory"
          class="form-control mb-2 mr-sm-2"
        >
          <option
            v-for="subCategory in subCategories"
            v-bind:key="subCategory.id"
            :value="subCategory.id"
            :disabled="subCategory.id == 0"
            :selected="subCategory.id == 0"
          >{{subCategory.name}}</option>
        </select>

        <label>Примечание</label>
        <b-input name="comment" class="mb-2 mr-sm-2"></b-input>
        <b-button class="mt-3" block type="submit">Добавить</b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      selectedCategory: 0,
      suppliers: [{ id: 0, name: "Выберите поставщика" }],
      manufacturers: [{ id: 0, name: "Выберите производителя" }],
      units: [{ id: 0, name: "Ед.измерения" }],
      categories: [{ id: 0, name: "Выберите категорию" }],
      subCategories: [{ id: 0, name: "Выберите подкатегорию" }]
    };
  },
  mounted() {},
  methods: {
    shown: function() {
      this.show = true;
      this.getOptions();
    },
    addPrice: function(evt) {
      evt.preventDefault();
      let formData = new FormData(evt.target);
      axios.post("/price/add", formData).then(response => {
        this.show = false;
        this.$emit("update-positions", false);
      });
    },
    getOptions: function() {
      this.suppliers = this.suppliers.concat(this.$root.suppliers);
      this.manufacturers = this.manufacturers.concat(this.$root.manufacturers);
      this.units = this.units.concat(this.$root.units);
      this.categories = this.categories.concat(this.$root.categories);
    },
    getSubCategories: function(categoryId) {
      this.subCategories = [];
      axios.get("/subcategories/get/" + categoryId).then(response => {
        if (response.data.length > 0) {
          this.subCategories = this.subCategories.concat(response.data);
        }
      });
    }
  }
};
</script>
<style>
.modal-backdrop {
  opacity: 0.5;
}
</style>
