<template>
  <div>
    <transition name="fade">
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>
  /* eslint-disable camelcase */

  export default {
    name: 'Index',
    data () {
      return {}
    },
    mounted: function () {
      this.loaded()
    },
    // 在 `methods` 对象中定义方法
    methods: {
      loaded: function () {
        let self = this
        // http request 拦截器
        if (this.$tools.CheckCookie('UserToken')) {
          this.$http.interceptors.request.use(
            config => {
              config.headers.UserToken = `${self.$tools.GetCookie('UserToken')}`
              return config
            },
            err => {
              return Promise.reject(err)
            })
          this.$tools.GetDataFromServer(
            this,
            this.$server_root + '/System/Menu/ListItem',
            function success (response) {
              let object_menu_children = []
              self.$store.state.data_menu = response.data.MenuInfo.Itemlist
              console.log(self.$store.state.data_menu)
              for (let i = 0; i < self.$store.state.data_menu.length; i++) {
                if (self.$store.state.data_menu[i].Action !== '') {
                  object_menu_children.push(
                    {
                      path: '/' + self.$store.state.data_menu[i].Model + '/' + self.$store.state.data_menu[i].Function + '/' + self.$store.state.data_menu[i].Action,
                      name: self.$store.state.data_menu[i].Model + '/' + self.$store.state.data_menu[i].Function + '/' + self.$store.state.data_menu[i].Action,
                      component: function (resolve) {
                        require(['@/views' + '/' + self.$store.state.data_menu[i].Model + '/' + self.$store.state.data_menu[i].Function + '/' + self.$store.state.data_menu[i].Action], resolve)
                      }
                    }
                  )
                }
              }
              self.$router.addRoutes([{
                path: '/Frame',
                name: 'Frame',
                component: function (resolve) {
                  require(['@/views/Frame'], resolve)
                },
                children: object_menu_children
              }])
              self.$router.push('/Frame')
            }
            ,
            function error (response) {
              console.log(response)
            }
          )
        } else {
          this.$router.push('/Login')
        }
      }
    }
  }
</script>

<style scoped>

</style>
