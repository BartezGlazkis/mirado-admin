<template>
  <div>
    <table class="table">
      <thead>
        <tr>
          <th>Блоки</th>
          <th>Категория</th>
          <th>Субкатегория</th>
          <th>Материал</th>
          <th>Фото</th>
          <th>Цена за ед.</th>
          <th>Количество</th>
          <th>Сумма</th>
          <th></th>
        </tr>
      </thead>
      <tbody v-for="block in commerceBlocks" v-bind:key="block.id">
        <tr>
          <th :rowspan="block.positions.length">
            <div class="row">
              <p class="ml-2 mr-2">{{block.name}}</p>
              <add-position-modal
                :commerceId="commerce.id"
                :blockId="block.id"
                @update-blocks="update"
              />
            </div>
          </th>
          <template v-if="block.positions.length > 0">
            <td>{{block.positions[0].category_name}}</td>
            <td>{{block.positions[0].subCategory_name}}</td>
            <td>{{block.positions[0].position_name}}</td>
            <td style="width: 100px;">
              <b-img-lazy
                v-if="block.positions[0].link_img != null"
                thumbnail
                fluid
                :src="'/storage/uploads/images/' + block.positions[0].link_img"
              />
              <p v-else>Нет фото</p>
            </td>
            <td>{{block.positions[0].price * rate}}</td>
            <td>{{block.positions[0].count}}</td>
            <td>{{block.positions[0].price * block.positions[0].count * rate}}</td>
            <td>
              <delete-position-modal
                :blockPositionId="block.positions[0].id"
                @update-blocks="update"
              />
            </td>
          </template>
        </tr>
        <template v-if="block.positions.length > 0">
          <tr v-for="position in block.positions.slice(1)" v-bind:key="position.id">
            <td>{{position.category_name}}</td>
            <td>{{position.subCategory_name}}</td>
            <td>{{position.position_name}}</td>
            <td style="width: 100px;">
            <b-img-lazy
              v-if="position.link_img != null"
              thumbnail
              fluid
              :src="'/storage/uploads/images/' + position.link_img"
            />
            <p v-else>Нет фото</p>
          </td>
            <td>{{position.price * rate}}</td>
            <td>{{position.count}}</td>
            <td>{{position.price * position.count * rate}}</td>
            <td>
              <delete-position-modal :blockPositionId="position.id" @update-blocks="update" />
            </td>
          </tr>
        </template>
      </tbody>
    </table>
    <form
      v-if="commerce.summ > 0"
      class="form-inline d-flex justify-content-end"
      @submit="addSale"
      method="POST"
    >
      <div class="form-group mx-sm-3 mb-2">
        <input type="hidden" name="kp_id" :value="commerce.id" />
        <input type="number" min="0" name="sale" class="form-control" placeholder="Скидка %" />
      </div>
      <button type="submit" class="btn btn-primary mb-2">Применить скидку</button>
    </form>
  </div>
</template>
<script>
export default {
  props: ["commerceBlocks", "rate", "commerce"],
  mounted() {},
  methods: {
    update: function() {
      this.$emit("update-commerce", this.commerce.id);
    },
    addSale: function(evt) {
      evt.preventDefault();
      let formData = new FormData(evt.target);
      axios.post("/commerce/add/sale", formData).then(response => {
        this.update();
      });
    }
  }
};
</script>