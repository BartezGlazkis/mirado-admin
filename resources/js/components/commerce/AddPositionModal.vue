<template>
  <div>
    <i class="far fa-plus-circle text-primary" @click="shown"></i>

    <b-modal v-model="show" hide-footer centered title="Добавить материал">
      <b-form @submit="addPosition">
        <input type="hidden" name="kp" :value="commerceId" />
        <input type="hidden" name="block" :value="blockId" />

        <select
          v-model="selectedCategory"
          @change="getSubCategories()"
          required
          class="form-control mt-3"
        >
          <option
            v-for="category in categories"
            v-bind:key="category.id"
            :value="category.id"
            :disabled="category.id == 0"
            :selected="category.id == 0"
          >{{category.name}}</option>
        </select>

        <select
          v-model="selectedSubCategory"
          @change="getPositions()"
          required
          class="form-control mt-3"
        >
          <option
            v-for="subCategory in subCategories"
            v-bind:key="subCategory.id"
            :value="subCategory.id"
            :disabled="subCategory.id == 0"
            :selected="subCategory.id == 0"
          >{{subCategory.name}}</option>
        </select>

        <input type="hidden" name="position" :value="selectedPosition.id" />
        <multiselect
          v-model="selectedPosition"
          class="mt-3"
          placeholder="Выберите материал"
          label="name"
          track-by="name"
          :options="positions"
          :show-labels="false"
        >
          <template slot="option" slot-scope="props">
            <div class="row m-1">
              <img
                class="option__image"
                width="50px"
                height="50px"
                :src="'/storage/uploads/images/' + props.option.link_img"
              />
              <div class="col text-wrap">
                <span class="option__title">{{ props.option.name }}</span>
              </div>
            </div>
          </template>
        </multiselect>

        <b-form-input
          name="count"
          class="mt-3"
          type="number"
          required
          placeholder="Введите количество"
          value="1"
        ></b-form-input>
        <b-button class="mt-3" block type="submit">Добавить</b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["commerceId", "blockId"],
  data() {
    return {
      show: false,
      selectedPosition: 0,
      selectedCategory: 0,
      selectedSubCategory: 0,
      categories: [{ id: 0, name: "Выберите категорию" }],
      subCategories: [{ id: 0, name: "Выберите подкатегорию" }],
      positions: []
    };
  },
  mounted() {},
  methods: {
    shown: function() {
      this.show = true;
      this.getCategories();
    },
    getCategories: function() {
      this.categories = [{ id: 0, name: "Выберите категорию" }];
      this.categories = this.categories.concat(this.$root.categories);
    },
    getSubCategories: function() {
      axios
        .get("/subcategories/get/" + this.selectedCategory)
        .then(response => {
          this.subCategories = [{ id: 0, name: "Выберите подкатегорию" }];
          this.positions = [];
          if (response.data.length > 0) {
            this.subCategories = this.subCategories.concat(response.data);
          }
        });
    },
    getPositions: function() {
      axios.get("/positions/" + this.selectedSubCategory).then(response => {
        if (response.data.length > 0) {
          this.positions = response.data;
        }
      });
    },
    addPosition: function(evt) {
      evt.preventDefault();
      let formData = new FormData(evt.target);
      axios.post("/commerce/position/add", formData).then(response => {
        this.kpBlocks = response.data;
        this.show = false;
        this.$emit("update-blocks");
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