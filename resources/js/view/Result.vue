<template>
  <div class="col-12 mb-2">
    <div class="row custom-options-checkable justify-content-center align-items-center">
        <div 
          class="col-lg-4 mb-md-0 mb-2"
          v-for="(classroom, index) in classrooms"
          :key="classroom.classroom"
        >
            <input 
              class="custom-option-item-check" 
              type="radio" 
              name="classroom" 
              @change="setClassroom(classroom.classroom)"
              :checked="index === 0"
              :id="index"
              />
            <label class="custom-option-item px-2 py-1" :for="index">
                <span class="d-flex align-items-center mb-50">
                    <vue-feather type="columns" size="50" class="me-50"></vue-feather>
                    <div>
                      <span class="custom-option-item-title h4 fw-bolder mb-0">
                        S.Y: {{ classroom.year }}
                      </span>
                      <p class="mb-0">Section: {{ classroom.section }}</p>
                    </div>
                </span>
                <span class="d-block">Grade Level: {{ classroom.level }} </span>
            </label>
        </div>
    </div>
  </div>

  <div class="mb-2 mt-1 col-10 mx-auto">
    <h4 class="text-dark fw-bold">
      Subjects
    </h4>
    <span 
      class="badge me-50 cursor-pointer"
      :class="{
        'bg-light-primary' : selectedRoom.subject !== subject.id,
        'bg-primary' : selectedRoom.subject === subject.id
        }"
      v-for="(subject) in selectedRoomSubjects?.subjects"
      :key="subject.id"
      @click="setSubject(subject.id)"
    >
      <vue-feather type="layers" size="25" />
      <span class="ms-25 font-small-4">{{ subject.name }}</span>
      <vue-feather 
        v-if="selectedRoom.subject === subject.id" 
        type="check-circle" 
        size="25" 
        class="ms-25" />
    </span>
  </div>

  <div class="card student-body">
    <div class="card-header border-bottom">
      <h4 class="card-title fw-bold">
        List of Students
      </h4>
    </div>
    <div class="card-body mt-2">
      <table class="table table-bordered table-hover table-striped table-sm text-center">
        <thead>
          <tr>
            <th>Student Name</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Date Submitted</th>
            <th>Score</th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="student in students"
            :key="student.student_id"
            class="cursor-pointer"
            @click="showScore"
          >
            <td class="text-left d-flex align-items-center">
                <div class="avatar">
                    <img :src="student.student_profile" alt="avatar" width="40" height="40" />
                </div>
                <div class="ms-50 text-start">
                    <span class="fw-bolder">
                        {{ student.student_name }}
                    </span>
                    <p class="mb-0 font-small-3">
                      {{ student.student_no }}
                    </p>
                </div>   
            </td>
            <td>
              <span class="fw-bolder">
                {{ student.start_time }}
              </span>
            </td>
            <td>
              <span class="fw-bolder">
                {{ student.end_time }}
              </span>
            </td>
            <td>
              <span class="fw-bolder">
                {{ student.date_submitted }}
              </span>
            </td>
            <td>
              <span class="badge rounded-pill bg-secondary">
                {{ student.score }}
              </span>
            </td>
            <td>
              <span class="badge bg-success">
                {{ student.remarks }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</template>

<script>

export default {
  props: ['api'],
  data() {
    return {
      classrooms: [],
      students: [],
      selectedRoom: {},

    }
  },
  mounted() {
    this.getClassrooms();
  },
  computed: {
    selectedRoomSubjects() {
      return this.classrooms?.find(item => item.classroom === this.selectedRoom.classroom);
    }
  },
  watch: {
    selectedRoom: {
      handler(value) {
        if (Object.keys(value).length > 1) {
          this.showLoader();
          axios.get(this.api + '/' + value.classroom + '/' + value.subject + '/students')
            .then(response => {
              this.hideLoader();
              this.students = response.data.data;
            })
        }
      },
      deep: true,
      immediate: true
    }
  },
  methods: {
    getClassrooms() {
      axios.get(this.api)
        .then(response => {
          this.classrooms = response.data.data;
          this.selectedRoom.classroom = this.classrooms[0].classroom;
          this.selectedRoom.subject = this.classrooms[0].subjects[0].id;
          this.hideLoader();
        })
    },
    setClassroom(id) {
      if (this.selectedRoom.classroom !== id) {
        this.selectedRoom.classroom = id;
        this.selectedRoom.subject = this.selectedRoomSubjects.subjects[0].id;
      }
      
    },
    setSubject(id) {
      this.selectedRoom.subject = id;
    },
    showScore() {
      window.open('http://127.0.0.1:8000/teacher/quiz', '_blank', "width=600,height=800")
    },
    showLoader() {
        $.blockUI({
            message: '<div class="spinner-border text-primary" role="status"></div>',
            css: {
                backgroundColor: 'transparent',
                border: '0'
            },
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8
            }
        });
    },
    hideLoader() {
      $.unblockUI();
    },
  }
}
</script>