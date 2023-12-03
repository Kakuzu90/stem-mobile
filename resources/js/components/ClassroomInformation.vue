<template>
  <div class="row">
    <div class="col-lg-4">
      <div class="card border-left-active">
        <div class="card-header">
          <h4 class="card-title text-uppercase text-primary">Classroom Informations</h4>
        </div>
        <div class="card-body">
          <h6 class="text-dark mb-25">
            <span class="fw-bolder text-primary">Teacher Name: </span>
            <span>{{ information.teacher_name }}</span>
          </h6>
          <h6 class="text-dark mb-25">
            <span class="fw-bolder text-primary">Subject: </span>
            <span>{{ information.subject }}</span>
          </h6>
          <h6 class="text-dark mb-25">
            <span class="fw-bolder text-primary">Section: </span>
            <span>{{ information.section }}</span>
          </h6>
          <h6 class="text-dark mb-25">
            <span class="fw-bolder text-primary">Grade: </span>
            <span>{{ information.grade }}</span>
          </h6>
          <h6 class="text-dark mb-25">
            <span class="fw-bolder text-primary">S.Y: </span>
            <span>{{ information.year }}</span>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-4 col-md-4 col-6">
          <div class="card cursor-pointer text-center border-bottom-success"
            @click="setPageView('assignments')"
          >
            <div class="card-body">
              <div class="avatar avatar-lg bg-light-success p-50 mb-1">
                <div class="avatar-content">
                    <i data-feather="file-minus" class="font-large-1"></i>
                </div>
              </div>
              <h2 class="fw-bolder">{{ information.assignment }}</h2>
              <p class="card-text font-small-4 fw-bolder text-dark">Assignments</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-6">
          <div class="card cursor-pointer text-center border-bottom-warning"
            @click="setPageView('quiz')"
          >
            <div class="card-body">
              <div class="avatar avatar-lg bg-light-warning p-50 mb-1">
                <div class="avatar-content">
                    <i data-feather="file-plus" class="font-large-1"></i>
                </div>
              </div>
              <h2 class="fw-bolder">{{ information.quiz }}</h2>
              <p class="card-text font-medium-1 fw-bolder text-dark">Quiz</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-6">
          <div class="card cursor-pointer text-center border-bottom-danger"
            @click="setPageView('modules')"
          >
            <div class="card-body">
              <div class="avatar avatar-lg bg-light-danger p-50 mb-1">
                <div class="avatar-content">
                    <i data-feather="file-text" class="font-large-1"></i>
                </div>
              </div>
              <h2 class="fw-bolder">{{ information.module }}</h2>
              <p class="card-text font-medium-1 fw-bolder text-dark">Modules</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['information'],
  methods: {
    setPageView(page) {
      this.$emit('pageView', page);
    }
  },
}
</script>
