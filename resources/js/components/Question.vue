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
          class="btn btn-sm me-25"
          :class="{'btn-primary': index === selectedSection, 'bg-light-primary border-primary': index !== selectedSection}"
          @click="setSection(index)"
        >
          {{ index + 1 }}
        </button>
      </div>
    </div>
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
        <div class="d-flex justify-content-center align-items-center mb-50 mt-25" v-if="item.image">
          <img :src="item.image" class="cursor-pointer" height="200" alt="Placeholder Image" />
        </div>
        <textarea 
          class="form-control mt-50" 
          placeholder="Enter your answer here" 
          v-if="item.question_type === 3"
          @keyup="setAnswer(item.id, $event)"
          ></textarea>
        <div class="col-lg-8 col-12 mx-auto mt-50" v-if="item.question_type === 1">
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
        <div class="mt-25" v-if="item.question_type === 2">
          <label 
            :for="'upload' + item.id" 
            class="btn btn-sm btn-relief-primary d-flex align-items-center mb-50 choose-btn"
          >
            <vue-feather type="upload-cloud" size="14" class="me-25" /> Choose 
          </label>
          <input type="file" 
            @change="setUploadAnswer(item.id, $event)" 
            :id="'upload' + item.id" 
            accept="image/*" 
            hidden 
            multiple />
          <div
            v-if="answerWithUpload(item.id).length > 0"
            class="p-50"
          >
            <div
              class="row align-items-center mb-50"
              v-for="(image, imageIndex) in answerWithUpload(item.id)"
              :key="image.name"
            >
              <div class="col-10 d-flex justify-content-start align-items-center rounded-pill border shadow-sm p-25 text-truncate">
                <div class="avatar bg-primary me-25">
                  <div class="avatar-content">
                    <vue-feather type="image" size="14" class="avatar-icon" />
                  </div>
                </div>
                <div class="d-flex flex-column">
                  <span class="font-small-3"><span class="fw-bolder text-dark">Filename: </span> {{ image.name }}</span>
                  <span class="font-small-3"><span class="fw-bolder text-dark">Size: </span> {{ formatSize(image.size) }}</span>
                </div>
              </div>
              <div class="col-2">
                <div 
                  class="avatar bg-danger"
                  @click="removeImage(item.id, imageIndex)"
                >
                  <div class="avatar-content">
                    <vue-feather type="x" size="14" class="avatar-icon" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center align-items-center">
      <button type="button" class="btn btn-relief-primary d-flex align-items-center"
        @click="submitAnswer"
      >
        <vue-feather type="save" size="14" class="me-25" /> Submit Answer
      </button>
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
      return this.exam?.sections[this.selectedSection];
    },
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
    setUploadAnswer(id, event) {
      const files = event.target.files;
      let arrayOfImages = [];
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (file && file.type.startsWith('image/')) {
          arrayOfImages.push({name: file.name, size: file.size, file})
        }
      }
      const foundIndex = this.form.findIndex(item => item.id === id);

      if (foundIndex !== -1) {
        this.form[foundIndex].image = arrayOfImages;
      } else {
        this.form.push({ id: id, image: arrayOfImages });
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
    answerWithUpload(id) {
      const foundIndex = this.form.findIndex(item => item.id === id);
      return this.form[foundIndex]?.image || [];
    },
    removeImage(id, index) {
      const foundIndex = this.form.findIndex(item => item.id === id);
      if (foundIndex !== -1) {
        this.form[foundIndex].image.splice(index, 1);
      }
    },
    formatSize(bytes) {
      const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
      if (bytes === 0) return '0 Byte';
      const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10);
      return `${Math.round(bytes / Math.pow(1024, i), 2)} ${sizes[i]}`;
    },
  },
}
</script>

<style scoped>
.choose-btn {
  width: 97px !important;
}
</style>