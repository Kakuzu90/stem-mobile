<template>
  <div class="content-body">
    <default-exam 
      v-if="isTakeExam"
      @onShowResults="getQuestions"
    />
    <missed-exam v-if="isMissed" />
    <already-taken 
      v-if="isAlreadyTaken"
      @onShowResults="getQuestions"
    />
    <completed 
      v-if="isComplete"
      @onShowResults="getQuestions"
    />
    <question 
      v-if="showQuestionOrResults" 
      :exam="exam"
      :alias="alias"
      :api="api"
      @examCompleted="onExamCompleted"
    />
  </div>
</template>

<script>
import { defineAsyncComponent } from 'vue';

export default {
  props: ['api', 'alias'],
  components: {
    Completed: defineAsyncComponent(() => import('../../components/Completed.vue')),
    AlreadyTaken: defineAsyncComponent(() => import('../../components/AlreadyTaken.vue')),
    MissedExam: defineAsyncComponent(() => import('../../components/MissedExam.vue')),
    DefaultExam: defineAsyncComponent(() => import('../../components/DefaultExam.vue')),
    Question: defineAsyncComponent(() => import('../../components/Question.vue')),
  },
  data() {
    return {
      exam: {},
      remarks: null,
    }
  },
  mounted() {
    this.getExam();
    this.isExamAlreadyStarted();
  },
  computed: {
    showQuestionOrResults() {
      return Object.entries(this.exam).length > 0 && (this.remarks === 'take exam' || this.remarks === 'submitted' || this.remarks === 'completed');
    },
    isTakeExam() {
      return this.remarks === 'take exam' && Object.entries(this.exam).length === 0;
    },
    isMissed() {
      return this.remarks === 'missed' && Object.entries(this.exam).length === 0;
    },
    isAlreadyTaken() {
      return this.remarks === 'submitted' && Object.entries(this.exam).length === 0;
    },
    isComplete() {
      return this.remarks === 'completed' && Object.entries(this.exam).length === 0;
    }
  },
  methods: {
    isExamAlreadyStarted() {
      const examStartTime = localStorage.getItem(this.alias+'startTime');
      if (examStartTime) {
        this.getQuestions();
      }
    },
    getExam() {
      axios.get(this.api)
        .then(response => {
          this.remarks = response.data.remarks;
          this.hideLoader();
        })
    },
    getQuestions() {
      this.showLoader();
      axios.get(this.api + '/questions')
        .then(response => {
          this.exam = response.data.data;
          this.hideLoader();
        })
    },
    onExamCompleted() {
      this.exam = [];
      this.remarks = 'completed';
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
  },
}
</script>