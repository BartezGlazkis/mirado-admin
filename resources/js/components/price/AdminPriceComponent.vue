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
          <th>
            <add-price-modal @update-positions="getPositions" :formData="formData" />
          </th>
        </tr>
      </thead>
      <tbody>
        <template v-if="positions.length > 0">
          <tr v-for="position in positions" v-bind:key="position.id">
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
            <td>
              <div class="row">
                <div class="col flex-grow-0 pr-0">
                  <edit-price-modal @update-positions="getPositions" :position="position" />
                </div>
                <div class="col flex-grow-0">
                  <delete-price-modal @update-positions="getPositions" :position="position" />
                </div>
              </div>
            </td>
          </tr>
        </template>
        <template v-else>
          <tr>
            <td colspan="8" class="text-center">Ничего не найдено</td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      positions: [],
      formData: new FormData()
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
