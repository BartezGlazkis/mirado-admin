<template>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Наименование</th>
        <th>Почта</th>
        <th>Телефон</th>
        <th>Сумма</th>
        <th style="width:  15%">Со скидкой</th>
        <th>Дата создания</th>
        <th v-if="isadmin">Создал</th>
        <th>
          <add-commerce-modal @update-commerce-list="getCommerceList" @toggle="toggle" />
        </th>
      </tr>
    </thead>
    <tbody v-for="commerce in commerceList" v-bind:key="commerce.id">
      <tr class="cursor" @click="toggle(commerce.id)">
        <td>{{commerce.name}}</td>
        <td>{{commerce.email}}</td>
        <td>{{commerce.phone}}</td>
        <td>{{commerce.summ}}</td>
        <td
          v-if="commerce.sale > 0"
        >{{commerce.summ - ((commerce.summ * commerce.sale) / 100)}} / {{commerce.sale}}%</td>
        <td v-else>{{commerce.summ}}</td>
        <td>{{commerce.created_at}}</td>
        <td v-if="isadmin">{{commerce.user_name}}</td>
        <td>

          <edit-commerce-modal :commerce="commerce" @update-commerce="updateCommerce" />

          <delete-commerce-modal :commerceId="commerce.id" @update-commerce-list="getCommerceList" />

          <make-commerce-pdf :commerceId="commerce.id"></make-commerce-pdf>
        </td>
      </tr>
      <tr v-if="opened.includes(commerce.id)">
        <td :colspan="isadmin ? 8 : 7">
          <commerce-more
            :commerceBlocks="commerceBlocks"
            :commerce="commerce"
            :rate="rate"
            @update-commerce="updateCommerce"
          ></commerce-more>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: ["rate", "isadmin"],
  data: function() {
    return {
      sale: false,
      opened: [],
      commerceList: [],
      commerceBlocks: []
    };
  },
  mounted() {
    this.getCommerceList();
  },
  methods: {
    getCommerceList: function() {
      axios.get("/commerce/get").then(response => {
        this.commerceList = response.data;
      });
    },
    updateCommerce: function(kpId) {
      this.getCommerceList();
      this.getCommerceBlocks(kpId);
    },
    getCommerceBlocks: function(kpId) {
      axios.post("/commerce/more", { kp_id: kpId }).then(response => {
        this.commerceBlocks = response.data;
      });
    },
    toggle(id) {
      this.getCommerceBlocks(id);

      const index = this.opened.indexOf(id);
      if (index > -1) {
        this.opened.splice(index, 1);
      } else {
        this.opened.push(id);
      }
    }
  }
};
</script>
<style scoped>

</style>