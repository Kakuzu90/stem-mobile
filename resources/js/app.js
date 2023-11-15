require('./bootstrap');
import { createApp } from 'vue';
import Question from './view/Question'

const app = createApp({});

app.component('question', Question);

app.mount('#app');