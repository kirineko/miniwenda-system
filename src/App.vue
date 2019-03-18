<script>
import { showSuccess } from './util'
import config from './config'
import qcloud from 'wafer2-client-sdk'

export default {

  async created () {
    this.login()
  },
  methods: {
    login () {
      qcloud.setLoginUrl(config.loginUrl)
      const session = qcloud.Session.get()
      console.log(session)
      if (session) {
        // 第二次登录
        // 或者本地已经有登录态
        // 可使用本函数更新登录态
        qcloud.loginWithCode({
          success: res => {
            qcloud.Session.set({ userInfo: res, logged: true })
            console.log(res)
            showSuccess('登录成功')
          },
          fail: err => {
            console.error('222', err)
          }
        })
      } else {
        // 首次登录
        qcloud.login({
          success: res => {
            qcloud.Session.set({ userInfo: res, logged: true })
            showSuccess('登录成功')
          },
          fail: err => {
            console.log(err)
          }
        })
      }
    }
  }
}
</script>

<style>
.btn {
  color: white;
  background: #EA5A49;
  margin-top: 10px;
  margin-bottom: 10px;
  padding-left: 15px;
  padding-right: 15px;
  border-radius: 2px;
  font-size: 16px;
  line-height: 40px;
  height: 40px;
  width: 100%;
}

.btn:active {
  background: #FA5A49;
}
</style>
