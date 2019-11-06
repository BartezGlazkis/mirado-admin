<template>
  <div>
    <apexchart width="100%" height="500" type="line" :options="options" :series="series"></apexchart>
  </div>
</template>
<script>
export default {
  props: ["ratevalues"],
  data: function() {
    return {
      options: {},
      series: []
    };
  },
  mounted() {
    let dates = [];
    let values = [];
    this.ratevalues.map(rate => {
      dates.push(new Date(rate.created_at).toLocaleDateString());
      values.push(rate.rate_value);
    });

    this.options = {
      xaxis: {
        categories: dates
      }
    };
    
    this.series = [
      {
        name: "курс",
        data: values
      }
    ];

    
  }
};
</script>