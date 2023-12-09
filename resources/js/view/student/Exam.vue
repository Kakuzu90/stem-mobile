<template>
  <div class="content-body">
    <div class="col-lg-7 mx-auto">
      <div class="card card-bordered mb-1">
        <div class="card-header p-1 align-items-center">
          <h4 class="card-title text-primary mb-0">
            {{ exam.title }}
          </h4>
          <span class="me-50">
            <span class="fw-bolder text-dark">Time Remaining:</span>
            <span class="fw-bold ms-25 text-primary">{{ exam.duration }}</span>
          </span>
        </div>
      </div>
      <div class="card">
        <div class="card-body card-bordered p-75">
          <button
            type="button"
            class="btn btn-sm bg-light-primary border-primary"
          >
            1
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Completed from '../../components/Completed'
export default {
  props: ['api'],
  data() {
    return {
      exam: {},
      form: {},
      selectedSection: 0,
    }
  },
}
</script>