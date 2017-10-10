/* eslint-disable camelcase */
let tools = {
  /**
   * 从服务器获取数据
   * @param param_object
   * @param param_url
   * @param param_success
   * @param param_error
   * @constructor
   */
  GetDataFromServer: function (param_object, param_url, param_success, param_error) {
    param_object.$http.get(param_url)
      .then(function (response) {
        param_success(response)
      })
      .catch(function (error) {
        param_error(error)
      })
  },
  /**
   * Post数据到服务器
   * @param param_object
   * @param param_url
   * @param param_data
   * @param param_success
   * @param param_error
   * @constructor
   */
  PostDataToServer: function (param_object, param_url, param_data, param_success, param_error) {
    param_object.$http.post(param_url, param_data)
      .then(function (response) {
        param_success(response)
      })
      .catch(function (error) {
        param_error(error)
      })
  },
  /**
   * 设置Cookie
   * @param paramcname
   * @param paramcvalue
   * @param paramhour
   * @constructor
   */
  SetCookie: function (paramcname, paramcvalue, paramhour) {
    let d = new Date()
    d.setTime(d.getTime() + (paramhour * 60 * 60 * 1000))
    let expires = 'expires=' + d.toUTCString()
    document.cookie = paramcname + '=' + paramcvalue + ';' + expires
  },
  /**
   * 获取Cookie
   * @param paramcname
   * @returns {*}
   * @constructor
   */
  GetCookie: function (paramcname) {
    let name = paramcname + '='
    let ca = document.cookie.split(';')
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i]
      while (c.charAt(0) === ' ') c = c.substring(1)
      if (c.indexOf(name) !== -1) return c.substring(name.length, c.length)
    }
    return ''
  },
  /**
   * 清除Cookie
   * @param paramcookie
   * @constructor
   */
  ClearCookie: function (paramcookie) {
    this.SetCookie(paramcookie, '', -1)
  },
  /**
   * 检查Cookie
   * @param paramcookie
   * @returns {boolean}
   * @constructor
   */
  CheckCookie: function (paramcookie) {
    let cookie = this.GetCookie(paramcookie)
    if (cookie !== '') {
      return true
    } else {
      return false
    }
  },
  /**
   * 验证Token
   * @param paramobject
   * @constructor
   */
  CheckToken: function (paramobject) {
    if (this.CheckCookie('UserId') && this.CheckCookie('UserToken')) {
      paramobject.$router.push('/Frame')
    } else {
      paramobject.$router.push('/Login')
    }
  }
}
export default tools
