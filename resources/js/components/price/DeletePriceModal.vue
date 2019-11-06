<template>
  <div>
    <i class="far fa-trash text-danger" @click="show=true"></i>

    <b-modal v-model="show" hide-footer centered title="Удалить позицию">
      <b-form @submit="deletePosition">
        <input type="hidden" name="id" :value="position.id" />
        <input type="hidden" name="link_img" :value="position.link_img" />
        Вы действительно хотите удалить позицию?
        <b-button class="mt-3" block type="submit">Удалить</b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["position"],
  data() {
    return {
      show: false
    };
  },
  methods: {
    deletePosition: function(evt) {
      evt.preventDefault();
      let formData = new FormData(evt.target);
      axios.post("/price/delete", formData).then(() => {
        this.show = false;
        this.$emit("update-positions", false);
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