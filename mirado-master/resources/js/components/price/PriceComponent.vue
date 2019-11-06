<template>
  <div>
    <price-search @get-positions="getPositions" />
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Наименование</th>
          <th>Артикуль</th>
          <th>Поставщик</th>
          <th>Производитель</th>
          <th>Ед.изм</th>
          <th>Цена в у.е.</th>
          <th>Фото</th>
          <th>Примечание</th>
        </tr>
      </thead>
      <tbody v-for="position in positions" v-bind:key="position.id">
        <tr v-if="positions.length > 0">
          <td>{{position.name}}</td>
          <td>{{position.art}}</td>
          <td>{{position.supplier_name}}</td>
          <td>{{position.manufacturer_name}}</td>
          <td>{{position.unit_name}}</td>
          <td>{{position.priceYE}}</td>
          <td style="width: 100px;">
            <b-img-lazy
              v-if="position.link_img != null"
              thumbnail
              fluid
              :src="'/storage/uploads/images/' + position.link_img"
            />
            <p v-else>Нет фото</p>
          </td>
          <td>{{position.comment}}</td>
        </tr>
        <tr v-else>
          <td colspan="8">Ничего не найдено</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  data() {
    return {
      positions: [],
      formData: null
    };
  },
  mounted() {
    this.getPositions(false);
  },
  methods: {
    getPositions: function(target) {
      if (target) {
        this.formData = new FormData(target);
      }

      axios.post("/price/get", this.formData).then(response => {
        this.positions = response.data;
      });
    }
  }
};
</script>