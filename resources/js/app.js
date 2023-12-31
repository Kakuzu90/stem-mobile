require('./bootstrap');
import { createApp } from 'vue';
import VueFeather from 'vue-feather';
import VueSelect from 'vue-select';
import PerfectScrollbar from 'vue3-perfect-scrollbar';

import Question from './view/Question'
import Result  from './view/Result'
import MyClass from './view/teacher/MyClass'
import StudentClass from './view/student/StudentClass'
import Classroom from './view/student/Classroom'
import Exam from './view/student/Exam'

import 'vue-select/dist/vue-select.css';
import 'vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.min.css'

const app = createApp({});

app.component('v-select', VueSelect);
app.component(VueFeather.name, VueFeather);
app.component('question', Question);
app.component('result', Result);
app.component('my-class', MyClass);
app.component('student-class', StudentClass);
app.component('classroom', Classroom);
app.component('exam', Exam);

app.use(PerfectScrollbar, {
  options: {
      wheelPropagation: false,
  }
});

app.mount('#app');