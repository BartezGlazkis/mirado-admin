<template>
  <div>
    <i class="far fa-trash text-danger" @click="show=true"></i>

    <b-modal v-model="show" hide-footer centered title="Удалить материал">
      <b-form @submit="deletePosition">
        <input type="hidden" name="block_position_id" :value="blockPositionId" />
        Вы действительно хотите удалить материал?
        <b-button class="mt-3" block type="submit">Удалить</b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["blockPositionId"],
  data() {
    return {
      show: false
    };
  },
  methods: {
    deletePosition: function(evt) {
      evt.preventDefault();
      let formData = new FormData(evt.target);
      axios.post("/commerce/position/delete", formData).then(() => {
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