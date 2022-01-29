<template>
    <div>
        <div class="_content">
            <div class="container">
                <div class="row">
                    
                    <!-- Left section -->
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="_advertise_card _mar_b30">
                            <!-- Step one -->
                            <p class="_advertise_Sub_title _3title"><i class="fas fa-user"></i> Basic</p>
                            <!-- <div class="_advertise_card_img_all">
                                
                            </div> -->
                             <!-- <p @click="isUploadModal('cover')" style="cursor:pointer;">change</p> -->
                            <div class="_advertise_card_img_all" style="display:none;">
                                <img :src="$store.state.authUser.cover" alt="image" class="_advertise_cover_img" >

                                <div v-if="$store.state.authUser.profile_pic" class="_advertise_card_pro_pic" style="cursor:pointer;" @click="isUploadModal('profile_pic')">
                                     <img :src="$store.state.authUser.profile_pic" alt="image" />
                                </div> 
                                <div class="_advertise_card_edit d-flex" style="cursor:pointer;" @click="isUploadModal('cover')">
                                    <span>
                                        <i class="fas fa-camera"></i>
                                    </span>
                                    <p class="_advertise_edit_txt">
                                        Upload Img
                                    </p>
                                </div>   
                            </div>
                            

                            <div class="_advertise_step_form">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="_1input_group">
                                            <p class="_1label">First Name</p>
                                            <Input v-model="userData.first_name" placeholder="First Name" value="Marian" />
                                            <p v-if="userDataError.first_name" class="_inpt1_eror_p">{{userDataError.first_name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="_1input_group">
                                            <p class="_1label">Last Name</p>
                                            <Input v-model="userData.last_name" placeholder="Last Name" value="Alex" />
                                            <p v-if="userDataError.last_name" class="_inpt1_eror_p">{{userDataError.last_name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="_1input_group">
                                            <p class="_1label">Email</p>
                                            <Input  v-model="userData.email"  placeholder="Email"/>
                                            <p v-if="userDataError.email" class="_inpt1_eror_p">{{userDataError.email}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="_1input_group">
                                            <p class="_1label">Username</p>
                                            <Input  v-model="userData.username" placeholder="Username"/>
                                            <p v-if="userDataError.username" class="_inpt1_eror_p">{{userDataError.username}}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="_advertise_step_button">
                                            <Button @click="updateBasicInfo()" :loading="isLoading" :disabled="isLoading" class="_btn1 _btn_150" style="padding-top:7px !important;padding-bottom:7px !important;">{{ isLoading ? 'Please wait . . .' : 'Save Changes'}}</Button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Step one -->
                        </div>
                    </div>
                    <!-- Left section -->

                    <!-- Left section -->
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="_advertise_card _mar_b30">
                            <!-- Step one -->
                            <p class="_advertise_Sub_title _3title"><i class="fas fa-user"></i> Change Password</p>

                            <div class="_advertise_step_form">
                                <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="_1input_group">
                                                    <p class="_1label">Confirm Current Password</p>

                                                    <Input type="password"
                                                        v-model="form.currentPassword" password
                                                        placeholder="Confirm Current Password"
                                                        @keyup.native="formError.currentPassword=''"
                                                        
                                                    />
                                                    <p v-if="formError.currentPassword" class="_inpt1_eror_p">{{formError.currentPassword}}</p>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="_1input_group">
                                                    <p class="_1label">Your New Password</p>

                                                    <Input type="password"
                                                        v-model="form.newPassword" password
                                                        placeholder="Your New Password"
                                                        @keyup.native="formError.newPassword=''"
                                                    />
                                                    <p v-if="formError.newPassword" class="_inpt1_eror_p">{{formError.newPassword}}</p>
                                                    
                                                </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-6">
                                                <div class="_1input_group">
                                                    <p class="_1label">Confirm New Password</p>

                                                    <Input type="password"
                                                        v-model="repassword" password
                                                        placeholder="Confirm New Password"
                                                        @keyup.native="formError.repassword=''"
                                                    />
                                                    <p v-if="formError.repassword" class="_inpt1_eror_p">{{formError.repassword}}</p>
                                                    
                                                </div>
                                                </div>
                                    
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="_advertise_step_button">
                                            <Button @click="changePassword" :loading="isLoading" :disabled="isLoading" class="_btn1 _btn_150">{{ isLoading ? 'Please wait . . .' : 'Save Changes'}}</Button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Step one -->
                        </div>
                    </div>
                    <!-- Left section -->
                    
                        <!-- upload profile picture -->
                    <Modal
                    v-model="isUpload"
                    :mask-closable="false"
                    :footer-hide="true"
                    :closable="true"
                    >
                    <p slot="header">
                        <span>{{imgData.uploadType=='profile_pic'?'Upload Profile Picture':'Upload Cover Picture'}}</span>
                        <!-- <Icon type="md-close" /> -->
                    </p>

                        <Upload
                            ref="upload"
                            type="drag"
                            :with-credentials="true" 
                            :data="imgData"
                            :on-success="handleSuccess"
                            :format="['jpg','jpeg','png','webp']"
                            :max-size="5000"  
                            :action= "`/profile/uploadUserPic`"
                            :on-format-error="handleFormatError" 
                            :on-exceeded-size="handleMaxSize" >
                         
                            <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                            </div>
                        </Upload>
                    </Modal>
    <!-- upload profile picture -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>


export default {
 head() {
   return {
    //  title: 'Profile | ' + this.$config.SITE_TITLE,
   }
 },
  data(){
    return{
      isUpload:false,
      imgData:{
          uploadType:''
      },
      userData:{
          first_name:'',
          last_name:'',
          email:'',
          username:'',
          gender:'',
      },
      
      userDataError:{
          first_name:'',
          last_name:'',
          email:'',
          username:'',
          gender:'',
      },
      
      form:{
          newPassword:'',
          currentPassword:'',
      },
      repassword:'',
      formError:{
        currentPassword: "",
        newPassword: "",
        repassword:"",
      },
      isLoading:false,
     reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,


    }
  },

  methods:{
      
    isUploadModal(type){
        this.imgData.uploadType = type
        this.isUpload =true
    },
    async updateBasicInfo() {
        
        this.clearBasicData()
        
        if(this.$store.state.authUser.first_name == this.userData.first_name && this.$store.state.authUser.last_name == this.userData.last_name && this.$store.state.authUser.username == this.userData.username && this.$store.state.authUser.email == this.userData.email){
          this.i("Nothing to update");
          return
        }
        
        let flag = 1
        
        if(!this.userData.first_name  || this.userData.first_name.trim()=='' || this.userData.first_name==null){
            this.userDataError.first_name ='First name is required!'
            flag = 0
        }
        if(!this.userData.last_name  || this.userData.last_name.trim()=='' || this.userData.last_name==null){
             this.userDataError.last_name ='Last name is required!'
            flag = 0
        }
        if(!this.userData.email  || this.userData.email.trim()=='' || this.userData.email==null){
            this.userDataError.email ='Email is required!'
            flag = 0
        }
        if (this.userData.email && !this.reg.test(this.userData.email)) {
            this.userDataError.email ='Invalid email format!'
            flag = 0
        }
        if (this.userData.username.trim() == "") {
            this.userDataError.username = "Username is required!";
            flag = 0
        }
        if (this.userData.username.indexOf(" ") !== -1) {
            this.userDataError.username = "Username can not contain blank spaces!";
            flag = 0
        }
        // if(!this.userData.gender  || this.userData.gender.trim()=='' || this.userData.gender==null){
        //      this.userDataError.gender ='Gender is required!'
        //     flag = 0
        // }
        
        if(flag==0) return
       
        this.isLoading = true;
        let obj =this.userData
        obj.id =this.$store.state.authUser.id
        
        const res = await this.callApi('post','/category/editAdminUser', obj)
        if(res.status==200){
            this.s("Profile updated successfully")
            this.$store.state.authUser.first_name =this.userData.first_name
            this.$store.state.authUser.last_name =this.userData.last_name
            this.$store.state.authUser.email =this.userData.email
            this.$store.state.authUser.username =this.userData.username
            this.$store.state.authUser.gender =this.userData.gender
            
            
        }

        else if(res.status==401){
            if(res.data.message){ this.e(res.data.message)}
        }
        else{
            this.swr();
        }
        this.isLoading = false;
    },
    
    
    clearBasicData() {
        this.userDataError = {
          first_name:'',
          last_name:'',
          email:'',
          username:'',
          gender:'',
        }
    },
    
    clearBasicData2() {
        this.userData = {
          first_name:'',
          last_name:'',
          email:'',
          username:'',
          gender:'',
        }
    },
    async changePassword() {
      
      this.clearFormError();
      let flag = 1
      
      if (
        !this.form.currentPassword ||
        this.form.currentPassword.trim() == "" ||
        this.form.currentPassword == null
      ) {
        this.formError.currentPassword ='Current password is required!'
        flag = 0
      }
      
      if (this.form.currentPassword && this.form.currentPassword.trim().length < 6) {
        this.formError.currentPassword ='Password must be at least 6 characters long!'
        flag = 0
      }

      if (
        !this.form.newPassword ||
        this.form.newPassword.trim() == "" ||
        this.form.newPassword == null
      ) {
        this.formError.newPassword ='New password is required!'
        flag = 0
      }

      if (this.form.newPassword && this.form.newPassword.trim().length < 6) {
        this.formError.newPassword ='Password must be at least 6 characters long!'
        flag = 0
      }

      if (
        !this.repassword ||
        this.repassword.trim() == "" ||
        this.repassword == null
      ) {
        this.formError.repassword ='Confirm password is required!'
        flag = 0
      }
      if (this.repassword && this.form.newPassword != this.repassword) {
        this.formError.repassword ='New password & confirm password doesn`t match !'
        flag = 0
      }

    if(flag==0) return
    
      this.isLoading = true;
      let obj =this.form;
      obj.id =this.$store.state.authUser.id
      const res = await this.callApi("post","/category/editAdminPassword",obj);
      if (res.status == 200) {
        this.s("Password changed successfully !");
        // console.log(res.data)
        this.clearData2();
      } else if (res.status == 401) {
        
        //  if(res.data.message){
        //     this.e(res.data.message)
        //     this.formError.currentPassword = res.data.message
        //     }
         if(res.data.updated){
            this.i(res.data.updated)
            this.formError.newPassword = res.data.message
            }
         
      } else {
        this.swr();
      }
      this.isLoading = false;
    },
    
    clearFormError() {
        this.formError = {
        currentPassword: "",
        newPassword: "",
        repassword:"",
        }
    },

    clearData2() {
      this.form = {
        currentPassword: "",
        newPassword: "",
      };
      this.repassword =""
    },
     handleSuccess(res, file) {
      this.isUpload = false;
      res.isProfile?this.$store.state.authUser.profile_pic = res.picture:this.$store.state.authUser.cover = res.picture
      this.s("Picture Updated Successfully !");
    },

    handleFormatError(file) {
      this.e("The file format is incorrect");
    },

    handleMaxSize(file) {
      this.e("File  " + file.name + " is too large, not more than 4M.");
    },
    
  },
  
  created(){
      this.userData = JSON.parse(JSON.stringify(this.$store.state.authUser))
  }
}
</script>

<style scoped>
.ivu-btn[disabled]{
    background: #ce6a6a;
}

</style>