
<script>
export default {
  el: "#app",
  data: {
    categories: [],
    units: [],
    manufacturers: [],
    suppliers: []
  },
  mounted() {
    axios.get("/categories/get").then(response => {
      this.categories = response.data;
    });
    axios.get("/units/get").then(response => {
      this.units = response.data;
    });
    axios.get("/manufacturers/get").then(response => {
      this.manufacturers = response.data;
    });
    axios.get("/suppliers/get").then(response => {
      this.suppliers = response.data;
    });
  }
};
</script>