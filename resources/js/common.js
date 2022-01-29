import { mapActions, mapGetters } from 'vuex';

import Vue from 'vue';
import moment from 'moment';

Vue.filter('dateFormat', function (value) {
  if (!value) return ''
  return moment(value).format("YYYY-MM-DD")
});


export default {


    computed: {
        ...mapGetters({
            authInfo:'getAuthUser',
        }),
    },

    methods: {
        /**
         *
         * @param {*} method, call method
         * @param {*} url , api url
         * @param {*} dataObj, payload
         */
        async callApi(method, url, dataObj) {
            try {

                let data = await axios({
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    method: method,
                    url:  url,
                    data: dataObj
                })
                return data

            } catch (e) {
                let res = e.response;
                if (res.status == 404 || res.status == 401) {
                  if(res.data.message) this.i(res.data.message)
                }else if (res.status == 422 || res.status == 400) {

                    for (let e of res.data.messages) {
                        this.i(e)
                      }
                }
                else{
                   this.swr();
                }
                return res;

            }
        },

        i(msg, i = 'Hey!') {
            this.$Notice.info({
                title: i,
                desc: msg
            });
        },
        s(msg, i = 'Great!') {
            this.$Notice.success({
                title: i,
                desc: msg
            });
        },
        w(msg, i = 'Hi!') {
            this.$Notice.warning({
                title: i,
                desc: msg
            });
        },

        e(msg, i = 'Oops!') {
            this.$Notice.error({
                title: i,
                desc: msg
            });
        },
        swr() {
            this.$Notice.error({
                title: 'Oops',
                desc: 'Something went wrong, please try again later'
            });
        },
        ns(title) {
            this.$Message.success(title);
        },
        ni(title) {
            this.$Message.info(title);
        },
        nw(title) {
            this.$Message.warning(title);
        },
        ne(title) {
            this.$Message.error(title);
        },
        nswr() {
            this.$Message.error('Something went wrong, please try again later');
        },

    }
}
