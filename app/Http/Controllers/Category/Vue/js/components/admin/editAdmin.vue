<template>
    <span>
		<Button @click="createModalfunc" size="small" type="primary">Edit</Button>

		<Modal v-model="createModal" draggable  class-name="vertical-center-modal" scrollable title="Edit User">
			<div class="_login_form">
			 <Form>
					<div class="row">
					

						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.username">
								<Input  v-model="form.username" @keyup.native="error.username=''" size="large" type="text" placeholder="Username"/>
							</FormItem>
						</div>

						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.email">
								<Input  v-model="form.email" @keyup.native="error.email=''" size="large" type="text" placeholder="Email"/>
							</FormItem>
						</div>

						<!-- <div class="col-12 col-md-6 col-lg-6">
							<FormItem :error="error.password">
									<Input type="password" @keyup.native="error.password=''" v-model="form.password" size="large" password placeholder="Password"/>
							</FormItem>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<FormItem :error="error.repassword">
									<Input type="password" @keyup.native="error.repassword=''" v-model="repassword" size="large" password placeholder="Confirm Password"/>
							</FormItem>
						</div> -->
					</div>

			
				</Form>
			</div>
			 <div slot="footer">
				<Button @click="editAdmin" :loading="isLoading" :disabled="isLoading" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Edit User'}}</Button>
				<Button type="error" icon ="md-close" @click="createModal = false">Cancel</Button>
			</div>
		</Modal>
    </span>
</template>

<script>
export default {
	props:['admin'],
	data(){
		return{
			createModal: false,
			isLoading:false,
			form:{
                uid:'',
				username:'',
				email:'',
				password:'',
			},

			repassword:'',

			error:{
				username:'',
				email:'',
				password:'',
			},

			reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,

		}
	},

	methods:{
		async editAdmin() {

			this.clearDataError()

			let flag = 1
			
			if (this.form.username.trim() == "") {
				this.error.username = "Username is required!";
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


			// if(this.form.password && this.form.password.trim().length <6 ){
			// 	this.error.password ='Password must be at least 6 characters long!'
			// 	flag = 0
			// }

			// if(this.form.password && (!this.repassword  || this.repassword.trim()=='' || this.repassword==null)){
			// 	this.error.repassword ='Confirm password is required!'
			// 	flag = 0
			// }
			// if (this.form.password && this.repassword && (this.form.password != this.repassword)) {
			// 	this.error.repassword = "Password does not match!";
			// 	flag = 0;
			// }

			if(flag==0) return

			this.isLoading = true;
			let formObj =this.form;
			const res = await this.callApi('post','/category/editAdmin', formObj)

			if(res.status==200){
				this.createModal=false
				this.s("User updated successfully !")
				this.admin.email = this.form.email
				this.admin.username = this.form.username
			}
			this.isLoading = false;

		},
		clearDataError() {
			this.error = {
				username:'',
				email:'',
				password:'',
		   }
    	},
		formData() {
			this.form = {
				uid:this.admin.id,
				username:this.admin.username,
				email:this.admin.email,
			},
			this.repassword=''
		},
		 createModalfunc(){
             this.formData();
			this.clearDataError();
			this.createModal =true;
		 },



	},







}
</script>
