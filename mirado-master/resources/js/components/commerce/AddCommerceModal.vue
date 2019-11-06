<template>
  <div>
    <i class="far fa-plus-circle text-primary" @click="shown"></i>

    <b-modal v-model="show" hide-footer title="Добавить коммерческое предложение">
      <b-form @submit="addCommerce">
        <b-form-input class="mt-3" type="text" required placeholder="Имя" name="name"></b-form-input>
        <b-form-input class="mt-3" type="email" required placeholder="Почта" name="email"></b-form-input>
        <b-form-input class="mt-3" type="tel" required placeholder="Телефон" name="phone"></b-form-input>
        <input type="hidden" name="blocks" :value="selected" />
        <div>
          <label class="mt-3">Блоки</label>
          <multiselect
            open-direction="bottom"
            v-model="values"
            :options="options"
            :multiple="true"
            :close-on-select="true"
            :clear-on-select="true"
            placeholder="Выберите блоки"
            label="name"
            track-by="name"
            @input="selectedUpdate"
          ></multiselect>
        </div>
        <b-button class="mt-3" block type="submit" >Добавить</b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      options: [],
      values: [],
      selected: []
    };
  },
  mounted() {},
  methods: {
    shown: function() {
      this.show = true;
      this.getOptions();
    },
    addCommerce: function(evt) {
      evt.preventDefault();
      let formData = new FormData(evt.target);
      axios.post("/commerce/add", formData).then(response => {
        this.show = false;
        this.$emit("update-commerce-list");
        this.$emit("toggle", response.data);
      });
    },
    getOptions: function() {
      axios.get("/blocks").then(response => {
        this.options = response.data;
      });
    },
    selectedUpdate: function(values) {
      this.selected = [];
      values.forEach(value => {
        this.selected.push(value.id);
      });
    }
  }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
.modal-backdrop {
  opacity: 0.5;
}
</style>