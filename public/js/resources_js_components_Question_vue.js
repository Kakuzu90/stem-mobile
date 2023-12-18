"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Question_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Question.vue?vue&type=script&lang=js":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Question.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_Modal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/Modal */ "./resources/js/components/Modal.vue");
/* harmony import */ var _alphabet__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../alphabet */ "./resources/js/alphabet.js");
/* harmony import */ var _exam__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../exam */ "./resources/js/exam.js");



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Question",
  props: ['exam', 'alias', 'api'],
  components: {
    Modal: _components_Modal__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      selectedSection: 0,
      Alphabet: _alphabet__WEBPACK_IMPORTED_MODULE_1__["default"],
      remainingTime: 0,
      timerInterval: null,
      form: [],
      srcImg: '/images/placeholder.png'
    };
  },
  mounted: function mounted() {
    var examStartTime = localStorage.getItem(this.alias + 'startTime');
    var answers = JSON.parse(localStorage.getItem(this.alias + 'answers'));
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
    sectionContent: function sectionContent() {
      var _this$exam;
      return (_this$exam = this.exam) === null || _this$exam === void 0 ? void 0 : _this$exam.sections[this.selectedSection];
    },
    showSubmitIfLast: function showSubmitIfLast() {
      var _this$exam2;
      var length = (_this$exam2 = this.exam) === null || _this$exam2 === void 0 ? void 0 : _this$exam2.sections.length;
      return length - 1 === this.selectedSection;
    },
    filterDuration: function filterDuration() {
      if (!this.exam.score) {
        var timeParts = this.exam.duration.split(":");
        var hours = parseInt(timeParts[0], 10);
        var minutes = parseInt(timeParts[1], 10);
        var seconds = parseInt(timeParts[2], 10);
        return hours * 3600 + minutes * 60 + seconds;
      }
    }
  },
  watch: {
    sectionContent: function sectionContent() {
      this.textAreaValue();
    }
  },
  methods: {
    setSection: function setSection(index) {
      this.selectedSection = index;
    },
    setAnswer: function setAnswer(id, event) {
      var examStartTime = localStorage.getItem(this.alias + 'startTime');
      if (!examStartTime) {
        this.startTimer();
      }
      var answerValue = event.target.value;
      if (answerValue === '') return;
      var foundIndex = this.form.findIndex(function (item) {
        return item.id === id;
      });
      if (foundIndex !== -1) {
        this.form[foundIndex].answer = answerValue;
      } else {
        this.form.push({
          id: id,
          answer: answerValue
        });
      }
      (0,_exam__WEBPACK_IMPORTED_MODULE_2__.write)(this.alias, {
        id: id,
        answer: answerValue
      });
    },
    setAnswerByChoice: function setAnswerByChoice(id, answer) {
      var examStartTime = localStorage.getItem(this.alias + 'startTime');
      if (!examStartTime) {
        this.startTimer();
      }
      var foundIndex = this.form.findIndex(function (item) {
        return item.id === id;
      });
      if (foundIndex !== -1) {
        this.form[foundIndex].answer = answer;
      } else {
        this.form.push({
          id: id,
          answer: answer
        });
      }
      (0,_exam__WEBPACK_IMPORTED_MODULE_2__.write)(this.alias, {
        id: id,
        answer: answer
      });
    },
    setUploadAnswer: function setUploadAnswer(id, event) {
      var examStartTime = localStorage.getItem(this.alias + 'startTime');
      if (!examStartTime) {
        this.startTimer();
      }
      var files = event.target.files;
      var arrayOfImages = [];
      for (var i = 0; i < files.length; i++) {
        var file = files[i];
        if (file && file.type.startsWith('image/')) {
          arrayOfImages.push({
            name: file.name,
            size: file.size,
            file: file
          });
        }
      }
      var foundIndex = this.form.findIndex(function (item) {
        return item.id === id;
      });
      if (foundIndex !== -1) {
        this.form[foundIndex].image = arrayOfImages;
      } else {
        this.form.push({
          id: id,
          image: arrayOfImages
        });
      }
      (0,_exam__WEBPACK_IMPORTED_MODULE_2__.write)(this.alias, {
        id: id,
        image: arrayOfImages
      });
    },
    highlightAnswer: function highlightAnswer(id, value) {
      var foundIndex = this.form.findIndex(function (item) {
        return item.id === id;
      });
      if (foundIndex !== -1 && this.form[foundIndex].answer === value) {
        return 'text-danger text-decoration-underline fw-bolder';
      }
    },
    showPopUp: function showPopUp() {
      $('#section').modal('show');
    },
    closePopUp: function closePopUp() {
      $('#section').modal('hide');
    },
    showImage: function showImage(img) {
      this.srcImg = img;
      $('#modal').modal('show');
    },
    submitAnswer: function submitAnswer() {
      var _this = this;
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
      var formdata = new FormData();
      var startTime = parseFloat(localStorage.getItem(this.alias + 'startTime'));
      var start_time = new Date(startTime * 1000);
      var format_time = "".concat(this.padTime(start_time.getHours()), ":").concat(this.padTime(start_time.getMinutes()), ":").concat(this.padTime(start_time.getSeconds()));
      formdata.append('start_time', format_time);
      this.form.forEach(function (item, index) {
        formdata.append("answers[".concat(index, "][id]"), item.id);
        if (item.answer) {
          formdata.append("answers[".concat(index, "][answer]"), item.answer);
        }
        if (item.image) {
          item.image.forEach(function (image, imgIndex) {
            formdata.append("answers[".concat(index, "][image][").concat(imgIndex, "]"), image.file);
          });
        }
      });
      axios.post(this.api + '/stored', formdata, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then(function (response) {
        _this.hideLoader();
        if (response.status === 204) {
          _this.clearAnswerSheet();
        }
      });
    },
    answerWithUpload: function answerWithUpload(id) {
      var _this$form$foundIndex;
      var foundIndex = this.form.findIndex(function (item) {
        return item.id === id;
      });
      return ((_this$form$foundIndex = this.form[foundIndex]) === null || _this$form$foundIndex === void 0 ? void 0 : _this$form$foundIndex.image) || [];
    },
    removeImage: function removeImage(id, index) {
      var foundIndex = this.form.findIndex(function (item) {
        return item.id === id;
      });
      if (foundIndex !== -1) {
        this.form[foundIndex].image.splice(index, 1);
        (0,_exam__WEBPACK_IMPORTED_MODULE_2__.remove)(this.alias, id, index);
      }
    },
    formatSize: function formatSize(bytes) {
      var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
      if (bytes === 0) return '0 Byte';
      var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10);
      return "".concat(Math.round(bytes / Math.pow(1024, i), 2), " ").concat(sizes[i]);
    },
    startTimer: function startTimer() {
      var _this2 = this;
      if (!this.remainingTime) {
        var examStartTime = new Date().getTime() / 1000;
        localStorage.setItem(this.alias + 'startTime', examStartTime);
        this.remainingTime = this.filterDuration;
      }
      this.timerInterval = setInterval(function () {
        var currentTime = new Date().getTime() / 1000;
        var examStartTime = parseFloat(localStorage.getItem(_this2.alias + 'startTime'));
        var elapsedTime = currentTime - examStartTime;
        _this2.remainingTime = Math.max(_this2.filterDuration - elapsedTime, 0);
        if (parseInt(_this2.remainingTime) == 60) {
          toastr['error']('Only 1 minute left! Please answer all the questions.', 'Exam Alert', {
            positionClass: 'toast-bottom-right',
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
            rtl: false
          });
        }
        if (_this2.remainingTime <= 0) {
          _this2.submitAnswer();
        }
      }, 1000);
    },
    loadRemainingTime: function loadRemainingTime() {
      var examStartTime = localStorage.getItem(this.alias + 'startTime');
      if (examStartTime) {
        var currentTime = new Date().getTime() / 1000;
        var elapsedTime = currentTime - parseFloat(examStartTime);
        this.remainingTime = Math.max(this.filterDuration - elapsedTime, 0);
      }
    },
    formatTime: function formatTime(seconds) {
      var hours = Math.floor(seconds / 3600);
      var minutes = Math.floor(seconds % 3600 / 60);
      var secs = Math.floor(seconds % 60);
      return "".concat(this.padTime(hours), ":").concat(this.padTime(minutes), ":").concat(this.padTime(secs));
    },
    padTime: function padTime(val) {
      return val < 10 ? "0".concat(val) : val;
    },
    textAreaValue: function textAreaValue() {
      var _this3 = this;
      this.$nextTick(function () {
        var textareas = _this3.$refs.textareas;
        var answers = JSON.parse(localStorage.getItem(_this3.alias + 'answers'));
        textareas === null || textareas === void 0 || textareas.forEach(function (textarea) {
          var id = textarea.getAttribute('data-item-id');
          var foundIndex = answers.findIndex(function (item) {
            return item.id == id;
          });
          textarea.value = answers[foundIndex].answer;
        });
      });
    },
    showLoader: function showLoader() {
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
    hideLoader: function hideLoader() {
      $.unblockUI();
    },
    clearAnswerSheet: function clearAnswerSheet() {
      clearInterval(this.timerInterval);
      localStorage.removeItem(this.alias + 'startTime');
      localStorage.removeItem(this.alias + 'answers');
      this.form = [];
      this.$emit('examCompleted');
    }
  },
  beforeUnmount: function beforeUnmount() {
    clearInterval(this.timerInterval);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Question.vue?vue&type=template&id=0fecee51&scoped=true":
/*!******************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Question.vue?vue&type=template&id=0fecee51&scoped=true ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _withScopeId = function _withScopeId(n) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.pushScopeId)("data-v-0fecee51"), n = n(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.popScopeId)(), n;
};
var _hoisted_1 = {
  "class": "col-lg-7 mx-auto"
};
var _hoisted_2 = {
  "class": "card card-bordered mb-1"
};
var _hoisted_3 = {
  "class": "card-header p-1 align-items-center"
};
var _hoisted_4 = {
  "class": "card-title text-primary mb-0"
};
var _hoisted_5 = {
  key: 0,
  "class": "me-50"
};
var _hoisted_6 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "fw-bolder text-dark"
  }, "Score: ", -1 /* HOISTED */);
});
var _hoisted_7 = {
  "class": "fw-bolder ms-25 text-primary"
};
var _hoisted_8 = {
  key: 1,
  "class": "me-50"
};
var _hoisted_9 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "fw-bolder text-dark"
  }, "Time Remaining: ", -1 /* HOISTED */);
});
var _hoisted_10 = {
  "class": "fw-bold ms-25 text-primary"
};
var _hoisted_11 = {
  "class": "card mb-2"
};
var _hoisted_12 = {
  "class": "card-body card-bordered p-75"
};
var _hoisted_13 = ["onClick"];
var _hoisted_14 = {
  "class": "fw-bolder text-dark mb-0"
};
var _hoisted_15 = {
  key: 0
};
var _hoisted_16 = {
  "class": "card-body p-1"
};
var _hoisted_17 = {
  "class": "mb-0"
};
var _hoisted_18 = {
  "class": "fw-bolder text-dark"
};
var _hoisted_19 = {
  key: 0,
  "class": "ms-1 mb-25"
};
var _hoisted_20 = {
  key: 1,
  "class": "mt-50 d-flex justify-content-center align-items-center flex-column flex-lg-row"
};
var _hoisted_21 = {
  key: 0,
  "class": "d-flex justify-content-center align-items-center mb-50 mt-25 flex-column"
};
var _hoisted_22 = ["src", "onClick"];
var _hoisted_23 = {
  key: 1,
  "class": "p-50 rounded shadow-sm border-secondary bg-light-secondary w-100"
};
var _hoisted_24 = {
  key: 2,
  "class": "d-flex justify-content-center align-items-center mb-50 mt-25"
};
var _hoisted_25 = ["src", "onClick"];
var _hoisted_26 = ["data-item-id", "onKeyup"];
var _hoisted_27 = {
  key: 4,
  "class": "col-lg-8 col-12 mx-auto mt-50"
};
var _hoisted_28 = {
  "class": "row"
};
var _hoisted_29 = ["onClick"];
var _hoisted_30 = {
  "class": "fw-bolder"
};
var _hoisted_31 = {
  key: 5,
  "class": "mt-25"
};
var _hoisted_32 = ["for"];
var _hoisted_33 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Choose ");
var _hoisted_34 = ["onChange", "id"];
var _hoisted_35 = {
  key: 0,
  "class": "p-50"
};
var _hoisted_36 = {
  "class": "col-10 d-flex justify-content-start align-items-center rounded-pill border shadow-sm p-25 text-truncate"
};
var _hoisted_37 = {
  "class": "avatar bg-primary me-25"
};
var _hoisted_38 = {
  "class": "avatar-content"
};
var _hoisted_39 = {
  "class": "d-flex flex-column"
};
var _hoisted_40 = {
  "class": "font-small-3"
};
var _hoisted_41 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "fw-bolder text-dark"
  }, "Filename: ", -1 /* HOISTED */);
});
var _hoisted_42 = {
  "class": "font-small-3"
};
var _hoisted_43 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "fw-bolder text-dark"
  }, "Size: ", -1 /* HOISTED */);
});
var _hoisted_44 = {
  "class": "col-2"
};
var _hoisted_45 = ["onClick"];
var _hoisted_46 = {
  "class": "avatar-content"
};
var _hoisted_47 = {
  key: 1,
  "class": "d-flex justify-content-center align-items-center"
};
var _hoisted_48 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Submit Answer ");
var _hoisted_49 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", {
    "class": "fw-bolder text-center text-dark"
  }, " Are you sure? ", -1 /* HOISTED */);
});
var _hoisted_50 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
    "class": "text-center"
  }, " You won't be able to revert this once submitted. ", -1 /* HOISTED */);
});
var _hoisted_51 = {
  "class": "d-flex justify-content-center align-items-center"
};
var _hoisted_52 = {
  "class": "modal fade",
  id: "modal",
  tabindex: "-1",
  "aria-hidden": "true"
};
var _hoisted_53 = {
  "class": "modal-dialog modal-dialog-centered"
};
var _hoisted_54 = {
  "class": "modal-content"
};
var _hoisted_55 = ["src"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _$options$sectionCont, _$options$sectionCont2, _$options$sectionCont3, _$options$sectionCont4;
  var _component_vue_feather = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("vue-feather");
  var _component_modal = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("modal");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", _hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.exam.title), 1 /* TEXT */), $props.exam.score ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_5, [_hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.exam.score), 1 /* TEXT */)])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_8, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.remainingTime ? $options.formatTime($data.remainingTime) : $props.exam.duration), 1 /* TEXT */)]))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.exam.sections, function (section, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
      key: section.title,
      type: "button",
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["btn btn-sm me-25", {
        'btn-primary': index === $data.selectedSection,
        'bg-light-primary border-primary': index !== $data.selectedSection
      }]),
      onClick: function onClick($event) {
        return $options.setSection(index);
      }
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(index + 1), 11 /* TEXT, CLASS, PROPS */, _hoisted_13);
  }), 128 /* KEYED_FRAGMENT */))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$options$sectionCont = $options.sectionContent) === null || _$options$sectionCont === void 0 ? void 0 : _$options$sectionCont.title), 1 /* TEXT */), (_$options$sectionCont2 = $options.sectionContent) !== null && _$options$sectionCont2 !== void 0 && _$options$sectionCont2.direction ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("p", _hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$options$sectionCont3 = $options.sectionContent) === null || _$options$sectionCont3 === void 0 ? void 0 : _$options$sectionCont3.direction), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)((_$options$sectionCont4 = $options.sectionContent) === null || _$options$sectionCont4 === void 0 ? void 0 : _$options$sectionCont4.questions, function (item, indexSection) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
      "class": "card card-bordered my-1",
      key: item.id
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_18, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(indexSection + 1) + ".", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(item.question), 1 /* TEXT */)]), item.direction ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("p", _hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(item.direction), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $props.exam.score ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_20, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_vue_feather, {
      type: item.icon,
      size: "20",
      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["me-25", item.answer_type])
    }, null, 8 /* PROPS */, ["type", "class"]), item.question_type === 2 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_21, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(item.answer, function (image) {
      return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("img", {
        key: image,
        src: image,
        onClick: function onClick($event) {
          return $options.showImage(image);
        },
        "class": "cursor-pointer rounded border-light",
        width: "300",
        height: "300",
        alt: "Answer Image"
      }, null, 8 /* PROPS */, _hoisted_22);
    }), 128 /* KEYED_FRAGMENT */))])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_23, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(item.answer), 1 /* TEXT */)]))])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), item.image ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
      src: item.image,
      onClick: function onClick($event) {
        return $options.showImage(item.image);
      },
      "class": "cursor-pointer",
      height: "200",
      alt: "Placeholder Image"
    }, null, 8 /* PROPS */, _hoisted_25)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), item.question_type === 3 && !$props.exam.score ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("textarea", {
      key: 3,
      "class": "form-control mt-50",
      placeholder: "Enter your answer here",
      ref_for: true,
      ref: "textareas",
      "data-item-id": item.id,
      onKeyup: function onKeyup($event) {
        return $options.setAnswer(item.id, $event);
      }
    }, null, 40 /* PROPS, HYDRATE_EVENTS */, _hoisted_26)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), item.question_type === 1 && item.choices ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_27, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_28, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(item.choices, function (choice, indexChoice) {
      return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
        "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["col-6 cursor-pointer", $options.highlightAnswer(item.id, choice)]),
        key: choice,
        onClick: function onClick($event) {
          return $options.setAnswerByChoice(item.id, choice);
        }
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_30, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.Alphabet[indexChoice]) + ".", 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(choice), 1 /* TEXT */)], 10 /* CLASS, PROPS */, _hoisted_29);
    }), 128 /* KEYED_FRAGMENT */))])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), item.question_type === 2 && !$props.exam.score ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_31, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
      "for": 'upload' + item.id,
      "class": "btn btn-sm btn-relief-primary d-flex align-items-center mb-50 choose-btn"
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_vue_feather, {
      type: "upload-cloud",
      size: "14",
      "class": "me-25"
    }), _hoisted_33], 8 /* PROPS */, _hoisted_32), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
      type: "file",
      onChange: function onChange($event) {
        return $options.setUploadAnswer(item.id, $event);
      },
      id: 'upload' + item.id,
      accept: "image/*",
      hidden: "",
      multiple: ""
    }, null, 40 /* PROPS, HYDRATE_EVENTS */, _hoisted_34), $options.answerWithUpload(item.id).length > 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_35, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($options.answerWithUpload(item.id), function (image, imageIndex) {
      return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
        "class": "row align-items-center mb-50",
        key: image.name
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_36, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_37, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_38, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_vue_feather, {
        type: "image",
        size: "14",
        "class": "avatar-icon"
      })])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_39, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_40, [_hoisted_41, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(image.name), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_42, [_hoisted_43, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formatSize(image.size)), 1 /* TEXT */)])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_44, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
        "class": "avatar bg-danger",
        onClick: function onClick($event) {
          return $options.removeImage(item.id, imageIndex);
        }
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_46, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_vue_feather, {
        type: "x",
        size: "14",
        "class": "avatar-icon"
      })])], 8 /* PROPS */, _hoisted_45)])]);
    }), 128 /* KEYED_FRAGMENT */))])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]);
  }), 128 /* KEYED_FRAGMENT */)), !$props.exam.score ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_47, [$options.showSubmitIfLast ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
    key: 0,
    type: "button",
    "class": "btn btn-relief-primary d-flex align-items-center",
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.showPopUp && $options.showPopUp.apply($options, arguments);
    })
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_vue_feather, {
    type: "save",
    size: "14",
    "class": "me-25"
  }), _hoisted_48])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_modal, {
    id: "section",
    onClose: $options.closePopUp
  }, {
    body: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_49, _hoisted_50, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_51, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        type: "button",
        "class": "btn btn-relief-primary me-25",
        onClick: _cache[1] || (_cache[1] = function () {
          return $options.submitAnswer && $options.submitAnswer.apply($options, arguments);
        })
      }, " Yes, submit it! "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        type: "button",
        "class": "btn btn-relief-danger",
        onClick: _cache[2] || (_cache[2] = function () {
          return $options.closePopUp && $options.closePopUp.apply($options, arguments);
        })
      }, " Cancel ")])];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["onClose"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_52, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_53, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_54, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $data.srcImg,
    "class": "img-fluid"
  }, null, 8 /* PROPS */, _hoisted_55)])])])]);
}

/***/ }),

/***/ "./resources/js/alphabet.js":
/*!**********************************!*\
  !*** ./resources/js/alphabet.js ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']);

/***/ }),

/***/ "./resources/js/exam.js":
/*!******************************!*\
  !*** ./resources/js/exam.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   remove: () => (/* binding */ remove),
/* harmony export */   write: () => (/* binding */ write)
/* harmony export */ });
function write(alias, form) {
  var answers = JSON.parse(localStorage.getItem(alias + 'answers')) || [];
  var itemIndex = answers.findIndex(function (item) {
    return item.id === form.id;
  });
  if (itemIndex !== -1) {
    answers[itemIndex] = form;
  } else {
    answers.push(form);
  }
  localStorage.setItem(alias + 'answers', JSON.stringify(answers));
}
function remove(alias, id, index) {
  var answers = JSON.parse(localStorage.getItem(alias + 'answers'));
  var itemIndex = answers.findIndex(function (item) {
    return item.id === id;
  });
  answers[itemIndex].image.splice(index, 1);
  localStorage.setItem(alias + 'answers', JSON.stringify(answers));
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Question.vue?vue&type=style&index=0&id=0fecee51&scoped=true&lang=css":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Question.vue?vue&type=style&index=0&id=0fecee51&scoped=true&lang=css ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.choose-btn[data-v-0fecee51] {\r\n  width: 97px !important;\n}\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Question.vue?vue&type=style&index=0&id=0fecee51&scoped=true&lang=css":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Question.vue?vue&type=style&index=0&id=0fecee51&scoped=true&lang=css ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Question_vue_vue_type_style_index_0_id_0fecee51_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Question.vue?vue&type=style&index=0&id=0fecee51&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Question.vue?vue&type=style&index=0&id=0fecee51&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Question_vue_vue_type_style_index_0_id_0fecee51_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Question_vue_vue_type_style_index_0_id_0fecee51_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/components/Question.vue":
/*!**********************************************!*\
  !*** ./resources/js/components/Question.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Question_vue_vue_type_template_id_0fecee51_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Question.vue?vue&type=template&id=0fecee51&scoped=true */ "./resources/js/components/Question.vue?vue&type=template&id=0fecee51&scoped=true");
/* harmony import */ var _Question_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Question.vue?vue&type=script&lang=js */ "./resources/js/components/Question.vue?vue&type=script&lang=js");
/* harmony import */ var _Question_vue_vue_type_style_index_0_id_0fecee51_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Question.vue?vue&type=style&index=0&id=0fecee51&scoped=true&lang=css */ "./resources/js/components/Question.vue?vue&type=style&index=0&id=0fecee51&scoped=true&lang=css");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Question_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Question_vue_vue_type_template_id_0fecee51_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-0fecee51"],['__file',"resources/js/components/Question.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/Question.vue?vue&type=script&lang=js":
/*!**********************************************************************!*\
  !*** ./resources/js/components/Question.vue?vue&type=script&lang=js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Question_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Question_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Question.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Question.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/Question.vue?vue&type=template&id=0fecee51&scoped=true":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Question.vue?vue&type=template&id=0fecee51&scoped=true ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Question_vue_vue_type_template_id_0fecee51_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Question_vue_vue_type_template_id_0fecee51_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Question.vue?vue&type=template&id=0fecee51&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Question.vue?vue&type=template&id=0fecee51&scoped=true");


/***/ }),

/***/ "./resources/js/components/Question.vue?vue&type=style&index=0&id=0fecee51&scoped=true&lang=css":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/Question.vue?vue&type=style&index=0&id=0fecee51&scoped=true&lang=css ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Question_vue_vue_type_style_index_0_id_0fecee51_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Question.vue?vue&type=style&index=0&id=0fecee51&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Question.vue?vue&type=style&index=0&id=0fecee51&scoped=true&lang=css");


/***/ })

}]);