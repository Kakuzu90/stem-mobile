<template>
<div class="sidebar-left">
    <div class="sidebar">
        <div class="sidebar-file-manager">
            <div class="sidebar-inner">
                <div class="p-2 border-bottom">
                    <button 
                        class="btn btn-relief-primary add-file-btn text-center w-100" 
                        type="button"
                        @click="modalSection"
                        >
                        <span class="align-middle">Add Section</span>
                    </button>
                </div>

                <div class="sidebar-list">
                    <div class="list-group">
                        <a 
                            v-for="(questionnaire, index) in questionnaires"
                            :key="index"
                            @click="setActiveSection(index)"
                            class="list-group-item list-group-item-action" :class="{'active': index === activeSection}">
                            <span class="d-flex justify-content-between align-items-center">
                                {{ questionnaire.title }}
                                <span class="badge rounded-pill bg-light-warning">
                                    {{ sectionTotalPoints(index) }}
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-right">
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="body-content-overlay"></div>
            <div class="file-manager-main-content">
                <div class="file-manager-content-header d-flex justify-content-end align-items-center">
                    <div class="d-flex align-items-center">
                        <button
                            type="button"
                            class="btn btn-relief-success me-25"
                            :disabled="disableIfEmpty"
                            @click="submit"
                        >
                            <span class="align-middle">Save Changes</span>
                        </button>
                        <button
                            type="button"
                            class="btn btn-relief-primary"
                            :disabled="disableIfEmpty"
                            @click="modalQuestion"
                        >
                            <span class="align-middle">Add Question</span>
                        </button>
                    </div>
                </div>
                <perfect-scrollbar ref="body" class="file-manager-content-body pb-2">
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-dark fw-bolder mb-0" v-if="sectionQuestions">
                            {{ sectionQuestions.title }}
                            <span class="cursor-pointer" @click="openEditSectionModal">
                                <vue-feather type="edit-2" size="15" />
                            </span>
                            <span class="cursor-pointer ms-25" @click="deleteSection">
                                <vue-feather type="trash-2" size="15" />
                            </span>
                        </h4>
                        <span class="badge badge-pill bg-warning">
                            {{ totalPoints }} Points
                        </span>
                    </div>
                    <p v-if="sectionQuestions">
                        <span class="text-danger fw-bold">Direction:</span> {{ sectionQuestions.direction ?? 'No direction' }}
                    </p>
                    <div class="row g-1">
                        <div class="col-12"
                            v-for="(question, questionIndex) in sectionQuestions?.questions"
                            :key="questionIndex"
                            ref="items"
                        >
                            <div class="border rounded p-1">
                                <div class="d-flex justify-content-end align-items-center">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-icon btn-relief-success me-25"
                                        @click="openEditQuestionModal(questionIndex)"
                                    >
                                        <vue-feather type="edit-2" size="14"></vue-feather>
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-icon btn-relief-danger"
                                        @click="deleteQuestion(questionIndex)"
                                    >
                                    <vue-feather type="trash-2" size="14"></vue-feather>
                                    </button>
                                </div>
                                <p class="mb-0 text-dark">
                                    {{ questionIndex + 1 }}. {{ question.question }} <span class="text-warning fw-bolder">({{ question.points }} points)</span>
                                </p>
                                <span class="text-muted">
                                    Direction: {{ question.direction ?? 'No direction' }}
                                </span>
                                <div class="d-flex justify-content-center align-items-center" v-if="question.question_type === 2">
                                    <img :src="srcImage(question)" height="250" alt="Image" />
                                </div>
                                <div class="row justify-content-center align-items-center mt-1" v-if="question.question_type === 1">
                                    <div class="col-6"
                                        v-for="(choice, choiceIndex) in question.choices"
                                        :key="choice + '-key'"
                                    >
                                        <span class="fw-bolder text-dark">Choice {{ choiceIndex + 1 }}.</span> {{ choice }}
                                    </div>
                                </div>
                                <p class="text-danger fw-bolder mt-1">Answer: <span class="text-dark">{{ question.answer ?? 'Manual Check' }}</span></p>
                            </div>
                        </div>
                    </div>
                    
                </perfect-scrollbar>
            </div>
        </div>
    </div>
</div>

<modal id="section" @close="clearForm">
    <template #body>
        <h1 class="address-title text-center mb-1">Add New Section</h1>
        <div class="mb-1">
            <label class="form-label">Title</label>
            <div 
                class="input-group input-group-merge"
                :class="{'is-invalid' : errors.title}"
            >
                <span class="input-group-text">
                    <vue-feather type="book" size="14"></vue-feather>
                </span>
                <input 
                    type="text"
                    class="form-control"
                    :class="{'is-invalid' : errors.title}" 
                    name="title" 
                    placeholder="Enter title here" 
                    v-model="form.title"
                    @keypress.enter="addSection"
                    @input="clearError('title')"
                    />
            </div>
            <span class="invalid-feedback" v-if="errors.title">{{ errors.title }}</span>
        </div>
        <div class="mb-1">
            <label class="form-label">Direction: <span class="text-muted">(Optional)</span></label>
            <textarea class="form-control" placeholder="Enter direction here" v-model="form.direction"></textarea>
        </div>
        <div class="d-flex justify-content-end align-items-center">
            <button
                type="button"
                class="btn"
                :class="{'btn-relief-primary' : !editSection, 'btn-relief-warning' : editSection}"
                @click="addSection"
            >
                <i data-feather="database"></i> {{ editSection ? 'Update Section' : 'Add Section' }}
            </button>
        </div>
    </template>
</modal>

<modal id="question" @close="clearForm">
    <template #body>
        <h1 class="address-title text-center mb-1">Add New Question</h1>
        <div class="mb-1">
            <input 
                ref="file"
                type="file"
                class="form-control"
                @change="handleUpload"
                accept="image/*"
                placeholder="Select a file" 
                />
        </div>
        <div class="mb-1">
            <label class="form-label">Question</label>
            <textarea class="form-control" :class="{'is-invalid' : errors.question}" @input="clearError('question')" placeholder="Enter question here" v-model="form.question"></textarea>
            <span class="invalid-feedback" v-if="errors.question">
                {{ errors.question }}
            </span>
        </div>
        <div class="mb-1">
            <label class="form-label">Direction: <span class="text-muted">(Optional)</span></label>
            <textarea class="form-control" placeholder="Enter direction here" v-model="form.direction"></textarea>
        </div>
        <div class="mb-1">
            <label class="form-label">Question Type</label>
            <v-select 
            placeholder="Select a question type"
            :class="{'is-invalid' : errors.question_type}"
            :options="[{label: 'Multiple Choice', value: 1}, {label: 'Identification', value:3}, {label: 'Image', value: 2}]"
            v-model="form.question_type"
            :reduce="(e)=>e.value"
            />
            <span class="invalid-feedback" v-if="errors.question_type">
                {{ errors.question_type }}
            </span>
        </div>
        <div class="mb-1" v-if="form.question_type === 1">
            <label class="form-label">Choices</label>
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-11">
                    <div class="input-group input-group-merge"
                        :class="{'is-invalid' : errors.choice}">
                        <span class="input-group-text">
                            <vue-feather type="grid" size="14"></vue-feather>
                        </span>
                        <input 
                            type="text"
                            class="form-control" 
                            :class="{'is-invalid' : errors.choice}"
                            placeholder="Enter choice here" 
                            v-model="form.choice"
                            @input="clearError('choice')"
                            @keyup.enter="addChoices"
                            />
                    </div>
                    <span class="invalid-feedback" v-if="errors.choice">
                        {{ errors.choice }}
                    </span>
                </div>
                <button type="button" class="ms-25 btn btn-icon btn-sm btn-relief-primary"
                    @click="addChoices"
                >
                    <vue-feather type="plus" size="14"></vue-feather>
                </button>
            </div>
            <div class="mt-50">
                <span 
                    class="badge badge-pill bg-light-primary me-25"
                    v-for="(choice, index) in form.choices"
                    :key="index"
                >{{ choice }}</span>
            </div>
        </div>
        <div class="mb-1" v-if="form.question_type !== 2">
            <label class="form-label">Answer</label>
            <div class="input-group input-group-merge"
            :class="{'is-invalid' : errors.answer}">
                <span class="input-group-text">
                    <vue-feather type="key" size="14"></vue-feather>
                </span>
                <input 
                    type="text"
                    class="form-control" 
                    :class="{'is-invalid' : errors.answer}"
                    placeholder="Enter answer here" 
                    v-model="form.answer"
                    @input="clearError('answer')"
                    />
            </div>
            <span class="invalid-feedback" v-if="errors.answer">
                {{ errors.answer }}
            </span>
        </div>
        <div class="mb-1">
            <label class="form-label">Points</label>
            <div class="input-group input-group-merge"
            :class="{'is-invalid' : errors.points}">
                <span class="input-group-text">
                    <vue-feather type="plus-circle" size="14"></vue-feather>
                </span>
                <input 
                    type="number"
                    class="form-control" 
                    :class="{'is-invalid' : errors.points}"
                    placeholder="Enter points here" 
                    v-model="form.points"
                    @input="clearError('points')"
                    />
            </div>
            <span class="invalid-feedback" v-if="errors.points">
                {{ errors.points }}
            </span>
        </div>
        <div class="d-flex justify-content-end align-items-center">
            <button
                type="button"
                class="btn"
                :class="{'btn-relief-primary' : !editQuestion, 'btn-relief-warning' : editQuestion}"
                @click="addQuestion"
            >
                <i data-feather="database"></i> {{ editQuestion ? 'Update Question' : 'Add Question' }}
            </button>
        </div>
    </template>
</modal>
</template>

<script>
import Modal from '../components/Modal';

export default {
  props: ['api', 'image'],
  components: {
    Modal,
  },
  data() {
    return {
        errors: {},
        questionnaires: [],
        form: {},
        deleted: {sections: [], questions:[]},
        activeSection: 0,
        selectedQuestionIndex: 0,
        editSection: false,
        editQuestion: false,
    }
  },
  mounted() {
    this.getQuestionnaires();
  },
  watch: {
    'form.question_type' : function(newValue, oldValue) {
        if (this.errors.with_image && newValue !== 2) {
            delete this.errors.with_image;
        }
        if (newValue === 2 || newValue === 3) {
            delete this.form.choices;
        }
    }
  },
  computed: {
    sectionQuestions() {
        return this.questionnaires[this.activeSection];
    },
    totalPoints() {
        let points = 0;
        this.sectionQuestions?.questions.forEach(item => {
            points += item.points;
        });

        return points;
    },
    disableIfEmpty() {
        return this.questionnaires.length === 0;
    }
  },
  methods: {
    getQuestionnaires() {
        axios.get(this.api)
            .then((response) => {
                this.questionnaires = response.data.data;
                this.hideLoader();
            })
    },
    submit() {
        this.showLoader();
        let formData = new FormData();

        this.questionnaires.forEach((questionnaire, index) => {
            if (questionnaire.id) {
                formData.append(`questionnaires[${index}][id]`, questionnaire.id)
            }
            formData.append(`questionnaires[${index}][title]`, questionnaire.title)
            formData.append(`questionnaires[${index}][direction]`, questionnaire.direction)
            questionnaire.questions.forEach((question, indexQ) => {
                if (question.id) {
                    formData.append(`questionnaires[${index}][questions][${indexQ}][id]`, question.id)
                }
                formData.append(`questionnaires[${index}][questions][${indexQ}][question]`, question.question)
                formData.append(`questionnaires[${index}][questions][${indexQ}][direction]`, question.direction)
                formData.append(`questionnaires[${index}][questions][${indexQ}][image]`, question.image)
                formData.append(`questionnaires[${index}][questions][${indexQ}][question_type]`, question.question_type)
                formData.append(`questionnaires[${index}][questions][${indexQ}][choices]`, JSON.stringify(question.choices))
                formData.append(`questionnaires[${index}][questions][${indexQ}][answer]`, question.answer)
                formData.append(`questionnaires[${index}][questions][${indexQ}][points]`, question.points)
            });
        });

        formData.append('deleted', JSON.stringify(this.deleted));
        
        axios.post(this.api + '/store', formData, {headers: {'Content-Type' : 'multipart/form-data'}})
        .then(() => {
            this.hideLoader();
            toastr['success']('Questions has been successfully saved', 'Questions Saved', {
                positionClass: 'toast-bottom-right',
                closeButton: true,
                tapToDismiss: false,
                progressBar: true,
                rtl: false
            });
        })
    },
    modalSection() {
        $('#section').modal('show');
    },
    modalQuestion() {
        if (this.questionnaires.length > 0) {
            $('#question').modal('show');
        }
    },
    closeSection() {
        $('#section').modal('hide');
    },
    closeQuestion() {
        $('#question').modal('hide');
    },
    setActiveSection(index) {
        this.activeSection = index;
    },
    addSection(){
        if (!this.form.title) {
            this.errors.title = 'The title field is required';
            return;
        }
        const skeleton = {
            title: this.form.title,
            direction: this.form.direction,
            questions: [],
        };
        if (this.editSection) {
            this.questionnaires[this.activeSection].title = this.form.title;
            this.questionnaires[this.activeSection].direction = this.form.direction;
            this.editSection = false;
        }else {
            this.questionnaires.push(skeleton);
            this.activeSection = this.questionnaires.length - 1;
        }
        this.closeSection();
        this.clearForm();
    },
    addQuestion() {

        if (!this.form.question) {
            this.errors.question = 'The question field is required';
        }

        if (!this.form.question_type) {
            this.errors.question_type = 'The question type field is required';
        }

        if (this.form.question_type === 1 && !this.form.hasOwnProperty('choices')) {
            this.errors.choice = 'The choice field is required';
        }

        if (this.form.question_type !== 2 && !this.form.answer) {
            this.errors.answer = 'The answer field is required';
        }

        if (!this.form.points) {
            this.errors.points = 'The points field is required';
        }

        if (Object.entries(this.errors).length === 0) {
            const skeleton = {
                question : this.form.question,
                direction: this.form.direction,
                image: this.form.with_image ?? null,
                image_url : this.form.image_url ?? null,
                question_type: this.form.question_type,
                choices: this.form.choices ?? null,
                answer: this.form.answer ?? null,
                points: this.form.points
            };
            if (this.editQuestion) {
                const selectedQuestion = this.sectionQuestions.questions[this.selectedQuestionIndex];
                selectedQuestion.question  = this.form.question;
                selectedQuestion.direction = this.form.direction;
                selectedQuestion.image = this.form.with_image ?? (selectedQuestion.id ? selectedQuestion.image : selectedQuestion.image);
                selectedQuestion.image_url = this.form.image_url ?? selectedQuestion.image_url;
                selectedQuestion.question_type = this.form.question_type;
                selectedQuestion.choices = this.form.choices ?? null;
                selectedQuestion.answer = this.form.answer ?? null;
                selectedQuestion.points = this.form.points
                this.editQuestion = false;
            }else {
                this.questionnaires[this.activeSection].questions.push(skeleton)
                this.$nextTick(() => {
                    const body = this.$refs.body.$el;
                    body.scrollTop = body.scrollHeight;
                    const items = this.$refs.items;
                    const lastItem = items[items.length - 1];
                    if (lastItem) {
                        const child = lastItem.querySelector('div')
                        child.classList.remove('border')
                        child.classList.add('border-top-active');
                        setTimeout(() => {
                            child.classList.add('border')
                            child.classList.remove('border-top-active');
                        }, 4000);
                        lastItem.scrollIntoView({behavior: 'smooth'});
                    }
                })
                
            }
            
            this.closeQuestion();
            this.clearForm();
        }

    },
    addChoices() {
        if (!this.form.choice) {
            this.errors.choice = 'The choice field is required';
            return;
        }
        this.form.choices = this.form.choices ?? [];
        if (!this.form.choices.includes(this.form.choice.trim())) {
            this.form.choices.push(this.form.choice);
        }
        this.form.choice = null;
    },
    handleUpload(event) {
        this.form.with_image = event.target.files[0];
        this.form.image_url = URL.createObjectURL(event.target.files[0]);
    },
    openEditSectionModal() {
        this.editSection = true;
        this.form.title = this.sectionQuestions.title;
        this.form.direction = this.sectionQuestions.direction;
        this.modalSection();
    },
    openEditQuestionModal(index) {
        this.selectedQuestionIndex = index;
        const selectedQuestion = this.sectionQuestions.questions[index]
        this.editQuestion = true;
        this.form.question = selectedQuestion.question;
        this.form.direction = selectedQuestion.direction;
        this.form.question_type = selectedQuestion.question_type;
        this.form.choices = selectedQuestion.choices ?? null;
        this.form.answer = selectedQuestion.answer ?? null;
        this.form.points = selectedQuestion.points;
        this.modalQuestion();
    },
    deleteSection() {
        if (this.questionnaires[this.activeSection].id) {
            this.deleted.sections.push(this.questionnaires[this.activeSection].id);
        }
        this.questionnaires.splice(this.activeSection, 1);
        const length = this.questionnaires.length;
        const temp = this.activeSection;
        this.activeSection = length === 1 ? 0 : temp - 1;
    },
    deleteQuestion(index) {
        if (this.sectionQuestions.questions[index].id) {
            this.deleted.questions.push(this.sectionQuestions.questions[index].id);
        }
        this.sectionQuestions.questions.splice(index, 1);
    },
    clearForm() {
        this.form = {};
        this.editSection = false;
        this.editQuestion = false;
        const fileInput = this.$refs.file;
        if (fileInput) {
            fileInput.value = '';
        }
    },
    clearError(field) {
        delete this.errors[field];
    },
    srcImage(question) {
        if (question.id) {
            return this.image + '/' + question?.image;
        }else {
            return question?.image_url;
        }
    },
    sectionTotalPoints(index) {
        let points = 0;
        const questions = this.questionnaires[index]?.questions;
        questions.forEach(item => {
            points += item.points;
        });

        return points;
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
    }
  },
}
</script>
