// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Vuex from 'vuex'
import ElementUI from 'element-ui'
import 'vue-awesome/icons'
import 'element-ui/lib/theme-default/index.css'
import App from './App'
import router from './router'
import Icon from 'vue-awesome/components/Icon'
import axios from 'axios'
import tools from './extend/tools'

Vue.use(ElementUI)
Vue.use(Vuex)
Vue.component('icon', Icon)
Vue.prototype.$http = axios
Vue.prototype.$tools = tools
Vue.prototype.$server_root = 'http://123.206.9.224'
Vue.prototype.$store = new Vuex.Store({
  state: {
    data_menu: [],
    main_menu: [],
    sub_menu: [],
    tabs: []
  }
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: {App}
})
