<template>
  <div class="card border-top-warning col-lg-4 col-md-5 col-11 mx-auto">
    <div class="card-body text-center">
      <div class="avatar bg-light-warning mb-25">
        <vue-feather type="alert-circle" size="100" />
      </div>
      <h1 class="mb-50">Warning!</h1>
      <p>
        Your exam has been successfully completed. You will be able to view the results once they are available. Thank you for your participation.
      </p>
      <button
        type="button"
        class="btn btn-relief-warning btn-block w-100"
        @click="showResults"
      >
        Show Results
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "AlreadyTaken",
  methods: {
    showResults() {
      this.$emit('onShowResults');
    }
  }
}
</script>