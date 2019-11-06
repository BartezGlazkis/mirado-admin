<template>
  <div>
    <a :href="'/commerce/pdf/' + commerceId">
      <i class="far fa-file-pdf text-danger"></i>
    </a>
  </div>
</template>

<script>
export default {
  props: ["commerceId"],
    methods: {}
};
</script>

