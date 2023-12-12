<template>
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
    <div class="card mb-2">
      <div class="card-body card-bordered p-75">
        <button
          v-for="(section, index) in exam.sections"
          :key="section.title"
          type="button"
          class="btn btn-sm bg-light-primary border-primary"
          @click="setSection(index)"
        >
          {{ index + 1 }}
        </button>
      </div>
    </div>
    <div class="question-wrapper">
      <h4 class="fw-bolder text-dark mb-0">
        {{ sectionContent?.title }}
      </h4>
      <p v-if="sectionContent?.direction">
        {{ sectionContent?.direction }}
      </p>
      <div 
        class="card card-bordered my-1"
        v-for="(item, indexSection) in sectionContent?.questions"
        :key="item.id"
        >
        <div class="card-body p-1">
          <h5 class="mb-0">
            <span class="fw-bolder text-dark">{{ indexSection + 1 }}.</span>
            {{ item.question }}
          </h5>
          <p class="ms-1 mb-25" v-if="item.direction">{{ item.direction }}</p>
          <div class="d-flex justify-content-center align-items-center mb-50" v-if="item.image">
            <img :src="item.image" class="cursor-pointer" height="200" alt="Placeholder Image" />
          </div>
          <textarea 
            class="form-control mt-50" 
            placeholder="Enter your answer here" 
            v-if="item.question_type === 3"
            @keyup="setAnswer(item.id, $event)"
            ></textarea>
          <div class="col-lg-8 col-12 mx-auto" v-if="item.question_type === 1">
            <div class="row">
              <div 
                class="col-6 cursor-pointer"
                :class="highlightAnswer(item.id, choice)"
                v-for="(choice, indexChoice) in item.choices"
                :key="choice"
                @click="setAnswerByChoice(item.id, choice)"
              >
                <span class="fw-bolder">{{ Alphabet[indexChoice] }}.</span> {{ choice }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-relief-primary d-flex align-items-center"
          @click="submitAnswer"
        >
          <vue-feather type="save" size="15" class="me-25" /> Submit Answer
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import Alphabet from '../alphabet';
export default {
  name: "Question",
  props: ['exam'],
  data() {
    return {
      selectedSection: 0,
      Alphabet: Alphabet,
      form: [],
    }
  },
  computed: {
    sectionContent() {
      return this.exam?.sections[0];
    }
  },
  methods: {
    setSection(index) {
      this.selectedSection = index;
    },
    setAnswer(id, event) {
      const answerValue = event.target.value;
      const foundIndex = this.form.findIndex(item => item.id === id);

      if (foundIndex !== -1) {
        this.form[foundIndex].answer = answerValue;
      } else {
        this.form.push({ id: id, answer: answerValue });
      }
    },
    setAnswerByChoice(id, answer) {
      const foundIndex = this.form.findIndex(item => item.id === id);

      if (foundIndex !== -1) {
        this.form[foundIndex].answer = answer;
      } else {
        this.form.push({ id: id, answer: answer });
      }
    },
    highlightAnswer(id, value) {
      const foundIndex = this.form.findIndex(item => item.id === id);
      if (foundIndex !== -1 && this.form[foundIndex].answer === value) {
        return 'text-danger text-decoration-underline fw-bolder';
      }
    },
    submitAnswer() {
      console.log(this.form);
    },
  },
}
</script>

<style scoped>
  .question-wrapper {
    height: 430px;
    position: relative;
  }
</style>