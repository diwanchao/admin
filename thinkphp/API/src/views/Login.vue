<template>
  <div class="">
    <el-card class="box-card">
      <h3>用户登录</h3>
      <!--<icon class="main_menu_icon" name="user-circle-o" scale="2"></icon>-->
      <el-input
        type="text"
        placeholder="用户名"
        icon="user-circle-o"
        style="margin-top:6px"
        v-model="data_userinfo.string_account"
      >
      </el-input>
      <el-input
        type="password"
        placeholder="密码"
        icon="user-circle-o"
        style="margin-top:16px"
        v-model="data_userinfo.string_password"
      >
      </el-input>
      <el-button type="success" style="margin:30px 0 40px 0;float:right;" v-on:click="Login">用户登录</el-button>
    </el-card>
  </div>
</template>

<script>
  export default {
    name: 'login',
    data () {
      return {
        data_userinfo: {
          string_account: '',
          string_password: ''
        }
      }
    },
    mounted: function () {
      this.loaded()
    },
    // 在 `methods` 对象中定义方法
    methods: {
      loaded: function () {
//        this.tools.setCookie('UserToken', '11111', 24)
      },
      Login: function () {
        let self = this
        this.$tools.PostDataToServer(
          this,
          this.$server_root + '/User/Login',
          {
            Account: this.data_userinfo.string_account,
            Password: this.data_userinfo.string_password
          },
          function success (response) {
            if (response.data.State.Code === 1) {
              self.$tools.SetCookie('UserId', response.data.UserInfo.Id)
              self.$tools.SetCookie('UserToken', response.data.UserInfo.Token)
              self.$tools.CheckToken(self)
            } else {
              self.$message.error(response.data.State.Message)
            }
          },
          function error (error) {
            console.log(error)
          }
        )
      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .box-card {
    width: 480px;
    margin: 0 auto;
    margin-top: 10%;
  }
</style>
