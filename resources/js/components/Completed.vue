<template>
  <div class="card border-top-success col-lg-4 col-md-5 col-11 mx-auto">
    <div class="card-body text-center">
      <div class="avatar bg-light-success mb-25">
        <vue-feather type="check-circle" size="100" />
      </div>
      <h1 class="mb-50">Completed!</h1>
      <p>
        Congratulations! You've successfully completed the exam. Thank you for your participation and best of luck with your results.
      </p>
      <button
        type="button"
        class="btn btn-relief-success btn-block w-100"
        @click="showResults"
      >
        Show Results
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "Completed",
  methods: {
    showResults() {
      this.$emit('onShowResults');
    }
  }
}
</script>