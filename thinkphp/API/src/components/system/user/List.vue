<template>
  <div>
    <el-table border style="width: 100%" max-height="250">
      <el-table-column fixed prop="date" label="日期" width="150" ></el-table-column>
      <el-table-column prop="name" label="姓名" width="120"></el-table-column>
      <el-table-column prop="province" label="省份" width="120"></el-table-column>
      <el-table-column prop="city" label="市区" width="120"></el-table-column>
      <el-table-column prop="address" label="地址" width="300"></el-table-column>
      <el-table-column prop="zip" label="邮编" width="120"></el-table-column>
      <el-table-column fixed="right" label="操作" width="120">
        <template scope="scope">
          <el-button @click.native.prevent="" type="text" size="small">
            移除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  let a = ''
  export default {
    name: 'List',
    props: {
      inputValue: String
    },
    data () {
      return {
        child_value: a
      }
    },
    mounted: function () {
      this.loaded()
    },
    // 在 `methods` 对象中定义方法
    methods: {
      loaded: function () {
        this.inputValue = 'aaaa'
      }
    }
  }

</script>

<style>
</style>
