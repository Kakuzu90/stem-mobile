<template>
  <div class="col-lg-7 mx-auto">
    <div class="card card-bordered mb-1">
      <div class="card-header p-1 align-items-center">
        <h4 class="card-title text-primary mb-0">
          {{ exam.title }}
        </h4>
        <span class="me-50" v-if="exam.score">
          <span class="fw-bolder text-dark">Score: </span>
          <span class="fw-bolder ms-25 text-primary">{{ exam.score }}</span>
        </span>
        <span class="me-50" v-else>
          <span class="fw-bolder text-dark">Time Remaining: </span>
          <span class="fw-bold ms-25 text-primary">{{ remainingTime ? formatTime(remainingTime) : exam.duration }}</span>
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
        <div
          class="mt-50 d-flex justify-content-center align-items-center flex-column flex-lg-row"
          v-if="exam.score"
        >
          <vue-feather :type="item.icon" size="20" class="me-25" :class="item.answer_type" />
          <div class="d-flex justify-content-center align-items-center mb-50 mt-25 flex-column" v-if="item.question_type === 2">
            <img
              v-for="image in item.answer"
              :key="image"
              :src="image" 
              @click="showImage(image)" 
              class="cursor-pointer rounded border-light" 
              width="300" 
              height="300" 
              alt="Answer Image"
            />
          </div>
          <div 
            class="p-50 rounded shadow-sm border-secondary bg-light-secondary w-100"
            v-else
          >
            <span>{{ item.answer }}</span>
          </div>
        </div>
        <div class="d-flex justify-content-center align-items-center mb-50 mt-25" v-if="item.image">
          <img :src="item.image" @click="showImage(item.image)" class="cursor-pointer" height="200" alt="Placeholder Image" />
        </div>
        <textarea 
          class="form-control mt-50"
          placeholder="Enter your answer here"
          v-if="item.question_type === 3 && !exam.score"
          ref="textareas"
          :data-item-id="item.id"
          @keyup="setAnswer(item.id, $event)"
          ></textarea>
        <div class="col-lg-8 col-12 mx-auto mt-50" v-if="item.question_type === 1 && item.choices">
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
        <div class="mt-25" v-if="item.question_type === 2 && !exam.score">
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
    <div class="d-flex justify-content-center align-items-center" v-if="!exam.score">
      <button type="button" class="btn btn-relief-primary d-flex align-items-center"
        v-if="showSubmitIfLast"
        @click="showPopUp"
      >
        <vue-feather type="save" size="14" class="me-25" /> Submit Answer
      </button>
    </div>
    <modal id="section" @close="closePopUp">
      <template #body>
        <h2 class="fw-bolder text-center text-dark">
          Are you sure?
        </h2>
        <p class="text-center">
          You won't be able to revert this once submitted.
        </p>
        <div class="d-flex justify-content-center align-items-center">
            <button
                type="button"
                class="btn btn-relief-primary me-25"
                @click="submitAnswer"
            >
              Yes, submit it!
            </button>
            <button
                type="button"
                class="btn btn-relief-danger"
                @click="closePopUp"
            >
              Cancel
            </button>
        </div>
      </template>
    </modal>
    <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <img :src="srcImg" class="img-fluid" />
          </div>
      </div>
    </div>
  </div>
</template>

<script>
import Modal from '../components/Modal';
import Alphabet from '../alphabet';
import { remove, write } from '../exam';
export default {
  name: "Question",
  props: ['exam', 'alias', 'api'],
  components: {
    Modal,
  },
  data() {
    return {
      selectedSection: 0,
      Alphabet: Alphabet,
      remainingTime: 0,
      timerInterval: null,
      form: [],
      srcImg: '/images/placeholder.png',
    }
  },
  mounted() {
    const examStartTime = localStorage.getItem(this.alias+'startTime');
    const answers = JSON.parse(localStorage.getItem(this.alias+'answers'));
    if (answers) {
      this.form = answers;
      this.textAreaValue();
    }
    this.loadRemainingTime();
    if (examStartTime) {
      this.startTimer();
    }
  },
  computed: {
    sectionContent() {
      return this.exam?.sections[this.selectedSection];
    },
    showSubmitIfLast() {
      const length = this.exam?.sections.length;
      return (length - 1) === this.selectedSection;
    },
    filterDuration() {
      if (!this.exam.score) {
        const timeParts = this.exam.duration.split(":");
        const hours = parseInt(timeParts[0], 10);
        const minutes = parseInt(timeParts[1], 10);
        const seconds = parseInt(timeParts[2], 10);

        return hours * 3600 + minutes * 60 + seconds;
      }
    }
  },
  watch: {
    sectionContent() {
      this.textAreaValue();
    }
  },
  methods: {
    setSection(index) {
      this.selectedSection = index;
    },
    setAnswer(id, event) {
      const examStartTime = localStorage.getItem(this.alias+'startTime');
      if (!examStartTime) {
        this.startTimer();
      }
      const answerValue = event.target.value;
      if (answerValue === '') return;
      const foundIndex = this.form.findIndex(item => item.id === id);
      if (foundIndex !== -1) {
        this.form[foundIndex].answer = answerValue;
      } else {
        this.form.push({ id: id, answer: answerValue });
      }
      write(this.alias, { id: id, answer: answerValue })
    },
    setAnswerByChoice(id, answer) {
      const examStartTime = localStorage.getItem(this.alias+'startTime');
      if (!examStartTime) {
        this.startTimer();
      }
      const foundIndex = this.form.findIndex(item => item.id === id);
      if (foundIndex !== -1) {
        this.form[foundIndex].answer = answer;
      } else {
        this.form.push({ id: id, answer: answer });
      }
      write(this.alias, {id: id, answer: answer});
    },
    setUploadAnswer(id, event) {
      const examStartTime = localStorage.getItem(this.alias+'startTime');
      if (!examStartTime) {
        this.startTimer();
      }
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
      write(this.alias, {id: id, image: arrayOfImages});
    },
    highlightAnswer(id, value) {
      const foundIndex = this.form.findIndex(item => item.id === id);
      if (foundIndex !== -1 && this.form[foundIndex].answer === value) {
        return 'text-danger text-decoration-underline fw-bolder';
      }
    },
    showPopUp() {
      $('#section').modal('show');
    },
    closePopUp() {
      $('#section').modal('hide');
    },
    showImage(img) {
      this.srcImg = img;
      $('#modal').modal('show');
    },
    submitAnswer() {
      this.closePopUp();
      if (this.form.length === 0) {
        toastr['error']('Cannot submit an empty answer sheet please answer the following questions!', 'Empty Answer Sheet', {
            positionClass: 'toast-bottom-right',
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
            rtl: false
        });
        return;
      }
      this.showLoader();
      let formdata = new FormData();
      const startTime = parseFloat(localStorage.getItem(this.alias+'startTime'));
      const start_time = new Date(startTime * 1000);
      const format_time = `${this.padTime(start_time.getHours())}:${this.padTime(start_time.getMinutes())}:${this.padTime(start_time.getSeconds())}`;
      formdata.append('start_time', format_time);
      this.form.forEach((item, index) => {
        formdata.append(`answers[${index}][id]`, item.id)
        if (item.answer) {
          formdata.append(`answers[${index}][answer]`, item.answer);
        }
        if (item.image) {
          item.image.forEach((image, imgIndex) => {
            formdata.append(`answers[${index}][image][${imgIndex}]`, image.file)
          })
        }
      })
      
      axios.post(this.api + '/stored', formdata, {headers: {'Content-Type' : 'multipart/form-data'}})
        .then(response => {
          this.hideLoader();
          if (response.status === 204) {
            this.clearAnswerSheet();
          }
        })
    },
    answerWithUpload(id) {
      const foundIndex = this.form.findIndex(item => item.id === id);
      return this.form[foundIndex]?.image || [];
    },
    removeImage(id, index) {
      const foundIndex = this.form.findIndex(item => item.id === id);
      if (foundIndex !== -1) {
        this.form[foundIndex].image.splice(index, 1);
        remove(this.alias, id, index);
      }
    },
    formatSize(bytes) {
      const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
      if (bytes === 0) return '0 Byte';
      const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10);
      return `${Math.round(bytes / Math.pow(1024, i), 2)} ${sizes[i]}`;
    },
    startTimer() {
      if (!this.remainingTime) {
        const examStartTime = new Date().getTime() / 1000;
        localStorage.setItem(this.alias+'startTime', examStartTime);
        this.remainingTime = this.filterDuration;
      }

      this.timerInterval = setInterval(() => {
        const currentTime = new Date().getTime() / 1000;
        const examStartTime = parseFloat(localStorage.getItem(this.alias+'startTime'));
        const elapsedTime = currentTime - examStartTime;
        this.remainingTime = Math.max(this.filterDuration - elapsedTime, 0);

        if (parseInt(this.remainingTime) == 60) {
          toastr['error']('Only 1 minute left! Please answer all the questions.', 'Exam Alert', {
              positionClass: 'toast-bottom-right',
              closeButton: true,
              tapToDismiss: false,
              progressBar: true,
              rtl: false
          });
        }

        if (this.remainingTime <= 0) {
          this.submitAnswer();
        }
      }, 1000)
    },
    loadRemainingTime() {
      const examStartTime = localStorage.getItem(this.alias+'startTime');
      if (examStartTime) {
        const currentTime = new Date().getTime() / 1000;
        const elapsedTime = currentTime - parseFloat(examStartTime);
        this.remainingTime = Math.max(this.filterDuration - elapsedTime, 0);
      }
    },
    formatTime(seconds) {
      const hours = Math.floor(seconds / 3600);
      const minutes = Math.floor((seconds % 3600) / 60);
      const secs = Math.floor(seconds % 60);
      return `${this.padTime(hours)}:${this.padTime(minutes)}:${this.padTime(secs)}`;
    },
    padTime(val) {
      return val < 10 ? `0${val}` : val;
    },
    textAreaValue() {
      this.$nextTick(() => {
        const textareas = this.$refs.textareas;
        const answers = JSON.parse(localStorage.getItem(this.alias+'answers'));
        textareas.forEach(textarea => {
          const id = textarea.getAttribute('data-item-id');
          const foundIndex = answers.findIndex(item => item.id == id);
          textarea.value = answers[foundIndex].answer;
        })
      })
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
    clearAnswerSheet() {
      clearInterval(this.timerInterval);
      localStorage.removeItem(this.alias+'startTime')
      localStorage.removeItem(this.alias+'answers')
      this.form = [];
      this.$emit('examCompleted');
    }
  },
  beforeUnmount() {
    clearInterval(this.timerInterval);
  }
}
</script>

<style scoped>
.choose-btn {
  width: 97px !important;
}
</style>