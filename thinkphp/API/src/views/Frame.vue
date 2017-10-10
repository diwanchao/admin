<template>
  <div style="height:100%;">
    <header>
      <!--<img src="" alt="logo" class="header-logo">-->
      <label>Logo</label>
      <ul class="header-operations">
        <li>
          <el-dropdown style="color:white">
            <span class="el-dropdown-link">
              User<i class="el-icon-caret-bottom el-icon--right"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item>修改密码</el-dropdown-item>
              <el-dropdown-item>注销</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </li>
      </ul>
    </header>
    <div id="menu_main">
      <ul>
        <li>
          <icon class="main_menu_icon"></icon>
          <br/>
          <label style="font-size:12px;width:100%;"></label>
        </li>
      </ul>
    </div>
    <div id="menu_sub">
      <ul> <!--//v-for="item in ItemListSub"-->
        <li>
          <label></label>
        </li>
      </ul>
    </div>

    <div id="main_content">
      <ul> <!--//v-for="item in ItemListSub"-->
        <li>
          <!--<label>{{ item.Name }}</label>-->
          <el-tabs>
            <el-tab-pane>
            </el-tab-pane>
          </el-tabs>
        </li>
      </ul>
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Frame',
    data () {
      return {
        data_menu: [],
        main_menu: [],
        sub_menu: [],
        tabs: [],
        currentView: ''
      }
    },
    mounted: function () {
      this.loaded()
    },
    // 在 `methods` 对象中定义方法
    methods: {
      loaded: function () {
        this.$router.push('/user/info/List')
      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .header-operations {
    display: inline-block;
    float: right;
    height: 100%;
  }

  .header-operations li {
    color: #fff;
    display: inline-block;
    vertical-align: middle;
    margin: 0;
    line-height: 50px;
    cursor: pointer;
  }

  .header-operations .header-download.is-available {
    opacity: 1;
    cursor: pointer;
  }

  .header-logo {
    display: inline-block;
    vertical-align: middle;
  }

  .header-operations:after, header:after {
    display: inline-block;
    content: "";
    height: 100%;
    vertical-align: middle;
  }

  #menu_main, #menu_sub {
    position: absolute;
    top: 0;
    height: 100%;
    padding-top: 50px;
  }

  .active {
    color: #8391a5;
    background: #e3e3e3;
    text-align: center;
    padding: 8px 0 8px 0;
  }

  #menu_main {
    width: 70px;
    left: 0;
  }

  #menu_sub {
    width: 160px;
    left: 70px;
  }

  #menu_sub ul li {
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
    font-size: 20px;
    height: 20px;
  }

  #main_content {
    margin-left: 230px;
    height: 100%;
    padding-top: 50px;
  }

  #menu_main {
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .12), 0 0 6px 0 rgba(0, 0, 0, .04);
  }

  #menu_main li {
    color: #8391a5;
    text-align: center;
    padding: 8px 0 8px 0;
  }

  #menu_main li:hover {
    color: #8391a5;
    background: #e3e3e3;
    text-align: center;
    padding: 8px 0 8px 0;
  }

  #menu_main li .active {
    color: #8391a5;
    background: #e3e3e3;
    text-align: center;
    padding: 8px 0 8px 0;
  }

  #menu_main li .active {
    border-left-color: #f2f6f9;
    -moz-border-left-colors: #f2f6f9;
  }

  #menu_main li .active {
    display: block;
    content: "";
    position: absolute;
    top: -1px;
    right: -10px;
    bottom: auto;
    z-index: 1;
    border-style: solid;
    border-width: 20px 0 21px 10px;
    border-color: transparent;
  }
</style>
