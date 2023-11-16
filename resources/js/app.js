require('./bootstrap');
import { createApp } from 'vue';
import VueFeather from 'vue-feather';
import VueSelect from 'vue-select';

import Question from './view/Question'

import 'vue-select/dist/vue-select.css';

const app = createApp({});

app.component('v-select', VueSelect);
app.component(VueFeather.name, VueFeather);
app.component('question', Question);

app.mount('#app');