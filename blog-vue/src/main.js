import Vue from 'vue'
import App from './App'
import router from './router'
import Axios from 'axios'
import Util from './util.js'
import Qs from 'qs'
import VueLazyload from 'vue-lazyload'
import Toast from '@/components/plug/toast/index.js'
import MessageBox from '@/components/plug/messagebox/index.js'
import Login from '@/components/plug/login/index.js'
import Register from '@/components/plug/register/index.js'
// import Loadings from '@/components/plug/loading/index.js'
import { Upload,Row,Loading } from 'element-ui';

//全局Toast
Vue.use(Toast)
//全局临时信息填写
Vue.use(MessageBox)
//登录
Vue.use(Login)
//注册
Vue.use(Register)
//加载
// Vue.use(Loadings)
// 配置懒加载
Vue.use(VueLazyload, {
	loading: require('@/assets/loading.gif'),
	error: require('@/assets/loaderror.gif'),
})
Vue.config.productionTip = false
// 网络请求挂载
Vue.prototype.$axios = Axios
Axios.defaults.baseURL = 'http://blog.cn/api';
// 添加请求拦截器
Axios.interceptors.request.use(function (config) {
	// 在发送请求之前做些什么
	if(config.method == 'post' && config.url != '/upload/image'){
		config.data = Qs.stringify(config.data);
	}
	return config;
	}, function (error) {
	// 对请求错误做些什么
	return Promise.reject(error);
});
Vue.use(Util)
// Vue.use(Util)
// element-ui
Vue.use(Upload)
Vue.use(Row)
Vue.use(Loading)
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  render: h => h(App)
})
