<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'app'
}
</script>

<style>
  body {
    font-family: Helvetica Neue,Helvetica,PingFang SC,Hiragino Sans GB,Microsoft YaHei,SimSun,sans-serif;
    padding:0;
    margin:0;
    width:100%;
    height:100%;
  }
  html {
    font-family: sans-serif;
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
    width:100%;
    height:100%;
  }
  header {
    height: 50px;
    position: absolute;
    width: 100%;
    top: 0;
    left: 0;
    padding: 0 20px;
    z-index: 1;
    box-sizing: border-box;
    background-color: rgb(32, 160, 255);
    box-shadow: 0 2px 4px 0 rgba(0,0,0,.12), 0 0 6px 0 rgba(0,0,0,.04);
  }
  header label{
    color:white;
    font-size:26px;
    height:50px;
    line-height:50px;
  }
  article, aside, details, figcaption, figure, footer, header, main, menu, nav, section, summary {
    display: block;
  }
  dd, dl, li, ol, ul {
    margin: 0;
    padding: 0;
  }
  ol, ul {
    list-style: none outside none;
  }
  img {
    border-style: none;
  }
  #app{
    height:100%;
  }
</style>
