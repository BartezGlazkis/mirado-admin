<template>
  <div>
    <i class="far fa-pen-square text-primary" @click="shown"></i>

    <b-modal v-model="show" hide-footer title="Редактировать коммерческое предложение">
      <b-form @submit="editCommerce">
        <b-form-input
          class="mt-3"
          type="text"
          :value="commerce.name"
          required
          placeholder="Имя"
          name="name"
        ></b-form-input>
        <b-form-input
          class="mt-3"
          type="email"
          :value="commerce.email"
          required
          placeholder="Почта"
          name="email"
        ></b-form-input>
        <b-form-input
          class="mt-3"
          type="tel"
          :value="commerce.phone"
          required
          placeholder="Телефон"
          name="phone"
        ></b-form-input>
        <input type="hidden" name="blocks" :value="selected" />
        <input type="hidden" name="kp_id" :value="commerce.id" />
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
        <b-button class="mt-3" block type="submit" >Сохранить</b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["commerce"],
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
      this.setOptions();
      this.show = true;
    },
    editCommerce: function(evt) {
      evt.preventDefault();
      let formData = new FormData(evt.target);
      axios.post("/commerce/edit", formData).then(() => {
        this.show = false;
        this.$emit("update-commerce", this.commerce.id);
      });
    },
    setOptions: function() {
      axios.get("/blocks").then(response => {
        this.options = response.data;
      });

      axios.get("/blocks/" + this.commerce.id).then(response => {
        if (response.data.length > 0) {
          this.values = response.data;
        }
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