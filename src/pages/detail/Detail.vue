<template>
  <div>
    <BookInfo :info="info"></BookInfo>
    <div class="comment">
      <textarea v-model="comment"
        class="textarea"
        :maxlength="100"
        placeholder="请输入图书短评"
      >
      </textarea>
      <div class="location">
        地理位置:
        <switch color="#EA5A49" :checked="location" @change="getGeo"></switch>
        <span class="text-primary">{{location}}</span>
      </div>
      <div class="phone">
        手机型号:
        <switch color="#EA5A49" :checked="phone" @change="getPhone"></switch>
        <span class="text-primary">{{phone}}</span>
      </div>
    </div>
  </div>
</template>

<script>
import {get} from '@/util'
import BookInfo from '@/components/BookInfo'

export default {
  data () {
    return {
      bookid: '',
      info: {},
      comment: '',
      location: '',
      phone: ''
    }
  },

  components: {
    BookInfo
  },

  methods: {
    async getDetail () {
      const info = await get('/weapp/bookdetail', {id: this.bookid})
      wx.setNavigationBarTitle({
        title: info.title
      })
      this.info = info
      console.log(info)
    },

    getPhone (e) {
      if (e.target.value) {
        const phoneInfo = wx.getSystemInfoSync()
        this.phone = phoneInfo.model
      } else {
        this.phone = ''
      }
    },

    getGeo (e) {
      const ak = 'VbzwlzrgD8iIyRdWb0aXog6it3L5xkTA'
      let url = 'http://api.map.baidu.com/geocoder/v2/'
      if (e.target.value) {
        wx.getLocation({
          success: geo => {
            wx.request({
              url,
              data: {
                ak,
                location: `${geo.latitude},${geo.longitude}`,
                output: 'json'
              },
              success: res => {
                if (res.data.status === 0) {
                  this.location = res.data.result.addressComponent.city
                } else {
                  this.location = '未知地点'
                }
              }
            })
          }
        })
      } else {
        this.location = ''
      }
    }
  },

  mounted () {
    this.bookid = this.$root.$mp.query.id
    this.getDetail()
  }
}
</script>

<style lang="scss">
.comment {
  margin-top: 10px;
  .textarea {
    width: 730rpx;
    height: 200rpx;
    background: #EEE;
    padding: 10rpx;
  }
  .location {
    padding: 5px 10px;
    margin-top: 10px;
  }
  .phone {
    padding: 5px 10px;
    margin-top: 10px;
  }
}
</style>>
