<template>
    <div>
        <div class="_login">

            <div class="_login_right">
                <div class="_login_main">
                    <div class="_login_top _1border_color">
                        <p class="_login_top_text">Register your account</p>
                    </div>

                    <div class="_login_form">
                        <Form>
                            <FormItem prop="password" :error="error.fullName">
                                <Input size="large"  v-model="form.username" placeholder="Full name">
                                   <Icon type="ios-person-outline" slot="prepend"></Icon>
                                </Input>
                            </FormItem>
                            <FormItem prop="user" :error="error.email">
                                <Input  size="large" type="text" v-model="form.email" placeholder="Email">
                                    <Icon type="ios-person-outline" slot="prepend"></Icon>
                                </Input>
                            </FormItem>
                            <FormItem prop="password" :error="error.password">
                                <Input size="large" type="password" v-model="form.password" placeholder="Password">
                                    <Icon type="ios-lock-outline" slot="prepend"></Icon>
                                </Input>
                            </FormItem>
                          
                            <FormItem>
                                <Button :loading="isLoading" :disabled="isLoading" @click.native="login()" class="_log_btn" >Register</Button>
                            </FormItem>
                        </Form>
                    </div>

                    <div class="_login_bottom">
                        <p class="_login_do">Don't have Account?  <router-link class="_3link _mar_l5" to="/">Login Now</router-link></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data(){
    return{
      form: {
            email: '',
            password: '',
            username: '',
        },
      error: {
            email: '',
            password: '',
            username: ''
        },
      isLoading:false,
      reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
    }
  },

  methods:{

    async login() {

        this.clearData()
        let flag = 1
        if(!this.form.username  || this.form.username.trim()=='' || this.form.username==null){
            this.error.username ='Full name is required!'
            flag = 0
        }
        if(!this.form.email  || this.form.email.trim()=='' || this.form.email==null){
            this.error.email ='Email is required!'
            flag = 0
        }
         
        if (this.form.email && !this.reg.test(this.form.email)) {
            this.error.email = "Invalid email format!";
            flag = 0;
        }

        if(!this.form.password  || this.form.password.trim()=='' || this.form.password==null){
            this.error.password ='Password is required!'
            return
        }

        if(this.form.password.trim().length <6 ){
            this.error.password ='Password must be at least 6 characters long!'
            flag = 0
        }

        if(flag==0) return

        this.isLoading = true;

        const res = await this.callApi('post','/auth/register', this.form)
        if(res.status==200){
            this.s("Login Successful")
            this.clearData2()
            window.location = '/'
        }

        this.isLoading = false;


    },

    clearData() {
       this.error = {
           email:'',
           password:''
       }
    },

    clearData2() {
        this.form = {
            email:'',
            password:'',
        }
    },
  }
}
</script>
