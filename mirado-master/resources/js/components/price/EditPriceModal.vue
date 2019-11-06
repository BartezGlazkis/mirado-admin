<template>
  <div>
    <i class="far fa-pen-square text-primary" @click="shown"></i>

    <b-modal v-model="show" hide-footer title="Редактировать позицию">
      <b-form @submit="editPrice">

        <input type="hidden" name="id" :value="position.id">

        <label>Наименование</label>
        <b-input required name="name" :value="position.name" class="mb-2 mr-sm-2"></b-input>

        <label>Артикуль</label>
        <b-input required name="art" :value="position.art" class="mb-2 mr-sm-2"></b-input>

        <label>Поставщик</label>
        <select name="supplier" class="form-control mb-2 mr-sm-2">
          <option
            v-for="supplier in suppliers"
            v-bind:key="supplier.id"
            :value="supplier.id"
            :selected="position.supplier == supplier.id"
          >{{supplier.name}}</option>
        </select>

        <label>Производитель</label>
        <select required name="manufacturer" class="form-control mb-2 mr-sm-2">
          <option
            v-for="manufacturer in manufacturers"
            v-bind:key="manufacturer.id"
            :value="manufacturer.id"
            :selected="position.manufacturer == manufacturer.id"
          >{{manufacturer.name}}</option>
        </select>

        <label>Цена</label>
        <b-input name="priceYE" :value="position.priceYE" type="number" class="mb-2 mr-sm-2"></b-input>

        <label>Ед.измерения</label>
        <select required name="unit" class="form-control mb-2 mr-sm-2">
          <option
            v-for="unit in units"
            v-bind:key="unit.id"
            :value="unit.id"
            :selected="position.unit == unit.id"
          >{{unit.name}}</option>
        </select>

        <label>Фото</label>
        <div class="w-100 mb-2 mr-sm-2">
          <b-img-lazy thumbnail :src="'/storage/uploads/images/' + position.link_img" fluid-grow/>
        </div>
        <b-form-file
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
          >{{category.name}}</option>
        </select>

        <label>Подкатегория</label>
        <select required name="subcategory" class="form-control mb-2 mr-sm-2">
          <option
            v-for="subCategory in subCategories"
            v-bind:key="subCategory.id"
            :value="subCategory.id"
            :selected="position.subCategory == subCategory.id"
          >{{subCategory.name}}</option>
        </select>

        <label>Примечание</label>
        <b-input name="comment" :value="position.comment" class="mb-2 mr-sm-2"></b-input>

        <b-button class="mt-3" block type="submit">Сохранить</b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["position"],
  data() {
    return {
      show: false,
      suppliers: [],
      manufacturers: [],
      units: [],
      selectedCategory: this.position.category,
      categories: [],
      subCategories: []
    };
  },
  mounted() {},
  methods: {
    shown: function() {
      this.show = true;
      this.getOptions();
    },
    editPrice: function(evt) {
      evt.preventDefault();
      let formData = new FormData(evt.target);
      axios.post("/price/edit", formData).then(response => {
        this.show=false
        this.$emit("update-positions", false);
      });
    },
    getOptions: function() {
      this.suppliers = this.$root.suppliers;
      this.manufacturers = this.$root.manufacturers;
      this.units = this.$root.units;
      this.categories = this.$root.categories;
      this.getSubCategories(this.position.category);
    },
    getSubCategories: function(category) {
      axios.get("/subcategories/get/" + category).then(response => {
        this.subCategories = [];
        if (response.data.length > 0) {
          this.subCategories = response.data;
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
