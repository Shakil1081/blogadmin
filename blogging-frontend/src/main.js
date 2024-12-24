import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import './assets/styles/bootstrap.scss';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';


toastr.options = {
  closeButton: true,
  progressBar: true,
  positionClass: 'toast-top-right',
  timeOut: '5000',
};

const app = createApp(App);
app.config.globalProperties.$toastr = toastr;
app.use(router).mount('#app');
