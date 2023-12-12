<template>
  <div class="card border-top-active col-lg-4 col-md-5 col-10 mx-auto">
    <div class="card-body text-center">
      <div class="avatar bg-light-primary mb-25">
        <vue-feather type="shield" size="100" />
      </div>
      <h1 class="mb-50">Take Exam Now!</h1>
      <p>
        Best of luck as you embark on your exam journey! Trust in your hard work, stay focused, and let your knowledge shine. You've got this! Wishing you the very best for success.
      </p>
      <button
        type="button"
        class="btn btn-relief-primary btn-block w-100"
        @click="showResults"
      >
        Start Now
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "DefaultExam",
  methods: {
    showResults() {
      this.$emit('onShowResults');
    }
  }
}
</script>
