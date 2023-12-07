<template>
  <div class="row justify-content-center align-items-center">
    <div class="col-lg-4" v-if="filteredCollection.length === 0">
      <div class="card border">
        <div class="card-body text-center">
          <h4 class="card-text text-danger fw-bolder mb-0">
            No Items Found!
          </h4>
        </div>
      </div>
    </div>
    <div class="col-lg-4"
      v-for="item in filteredCollection"
      :key="item.id"
    >
      <div 
        class="card cursor-pointer" 
        :class="item.border"
        @click="takeExam(item.id, item.classroom, item.subject)"
      >
        <div class="card-body">
          <h4 class="card-title text-center text-primary">
            {{ item.title }}
          </h4>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">Duration: </span>
            <span>{{ item.duration }}</span>
          </h6>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">Date Open: </span>
            <span>{{ item.date_open }}</span>
          </h6>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">Date Closed: </span>
            <span>{{ item.date_closed }}</span>
          </h6>
          <h6 class="mb-0" v-if="item.date_submitted">
            <span class="text-dark fw-bolder">Date Submitted: </span>
            <span>{{ item.date_submitted }}</span>
          </h6>
        </div>
        <div class="card-footer p-75 d-flex justify-content-end align-items-center">
          <span class="badge" :class="item.color">{{ item.remarks }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['collection', 'sort'],
  computed: {
    filteredCollection() {
      return this.collection.sort((a, b) => {
        let comparison = 0;
        if (a['date_closed'] > b['date_closed']) {
          comparison = 1;
        } else if (a['date_closed'] < b['date_closed']) {
          comparison = -1;
        }
        return this.sort ? comparison : -comparison;
      });
    }
  },
  methods: {
    takeExam(activity, classroom, subject) {
      window.location.assign('/student/exam/' + activity + '/classroom/' + classroom + '/subject/' + subject)
    }
  }
}
</script>
