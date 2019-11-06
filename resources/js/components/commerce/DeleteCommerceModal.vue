<template>
  <div>
    <i class="far fa-trash text-danger" @click="show=true"></i>

    <b-modal v-model="show" hide-footer centered title="Удалить материал">
      <b-form @submit="deleteCommerce">
        <input type="hidden" name="kp_id" :value="commerceId" />
        Удалить коммерческое предложение?
        <b-button class="mt-3" block type="submit">Удалить</b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["commerceId"],
  data() {
    return {
      show: false
    };
  },
  methods: {
    deleteCommerce: function(evt) {
      evt.preventDefault();
      let formData = new FormData(evt.target);
      axios.post("/commerce/delete", formData).then(() => {
        this.show=false
        this.$emit('update-commerce-list');
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