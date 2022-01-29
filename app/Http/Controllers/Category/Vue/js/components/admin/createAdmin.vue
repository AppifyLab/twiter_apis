<template>
    <span>

		<div class="_1card_top_right">
			<ul class="_1card_top_right_list">
				<li><template>
					<Button @click="createModalfunc" icon="md-add" type="primary">Create Admin</Button>
				</template></li>
			</ul>
		</div>

		<Modal v-model="createModal" draggable  class-name="vertical-center-modal" scrollable title="Create New Admin">
			<div class="_login_form">
			 <Form>
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6">
							<FormItem :error="error.first_name">
								<Input v-model="form.first_name" @keyup.native="error.first_name=''" size="large" type="text" placeholder="First Name"/>
							</FormItem>
						</div>

						<div class="col-12 col-md-6 col-lg-6">
							<FormItem :error="error.last_name">
								<Input v-model="form.last_name" @keyup.native="error.last_name=''" size="large" type="text" placeholder="Last Name"/>
							</FormItem>
						</div>

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

						<div class="col-12 col-md-6 col-lg-6">
							<FormItem :error="error.password">

									<Input type="password" @keyup.native="error.password=''" v-model="form.password" size="large" password placeholder="Password"/>

							</FormItem>
						</div>
						<div class="col-12 col-md-6 col-lg-6">
							<FormItem :error="error.repassword">
									<Input type="password" @keyup.native="error.repassword=''" v-model="repassword" size="large" password placeholder="Confirm Password"/>
							</FormItem>
						</div>
					</div>

					<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.gender">
								<RadioGroup v-model="form.gender" @on-change="error.gender=''">
									<Radio label="MALE">
										<span>Male</span>
									</Radio>
									<Radio label="FEMALE">
										<span>Female</span>
									</Radio>
									<Radio label="OTHER">
										<span>Others</span>
									</Radio>
								</RadioGroup>
							</FormItem>
						</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button @click="createAdmin" :loading="isLoading" :disabled="isLoading" icon="md-add" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Create Admin'}}</Button>
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
				first_name:'',
				last_name:'',
				username:'',
				email:'',
				password:'',
				gender:'',
			},

			repassword:'',

			error:{
				first_name:'',
				last_name:'',
				username:'',
				email:'',
				password:'',
				gender:'',
			},

			reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,

		}
	},

	methods:{
		async createAdmin() {

			this.clearDataError()

			let flag = 1
			if(!this.form.first_name  || this.form.first_name.trim()=='' || this.form.first_name==null){
				this.error.first_name ='First name is required!'
				flag = 0
			}
			if(!this.form.last_name  || this.form.last_name.trim()=='' || this.form.last_name==null){
				this.error.last_name ='Last name is required!'
				flag = 0
			}
			if (this.form.username.trim() == "") {
				this.error.username = "Username is required!";
				flag = 0
			}
			if (this.form.username.indexOf(" ") !== -1) {
				this.error.username = "Username can not contain blank spaces!";
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

			if(!this.repassword  || this.repassword.trim()=='' || this.repassword==null){
				this.error.repassword ='Confirm password is required!'
				flag = 0
			}
			if (this.repassword && this.form.password != this.repassword) {
				this.error.repassword = "Password does not match!";
				flag = 0;
			}

			if (!this.form.gender) {
				this.error.gender = "Please select a gender!";
				flag=0;
			}

			if(flag==0) return

			this.isLoading = true;
			let formObj =this.form;
			const res = await this.callApi('post','/category/createAdmin', formObj)

			if(res.status==200 || res.status==201){
				this.createModal=false
				this.s("Admin created successful")
				this.admin.total++
				this.admin.data.unshift(res.data)
				this.clearData()
			}
			this.isLoading = false;

		},
		clearDataError() {
			this.error = {
				first_name:'',
				last_name:'',
				username:'',
				email:'',
				password:'',
				gender:'',
		   }
    	},
		clearData() {
			this.form = {
				first_name:'',
				last_name:'',
				username:'',
				email:'',
				password:'',
				gender:'',
			},
			this.repassword=''
		},
		 createModalfunc(){
			this.clearData();
			this.clearDataError();
			this.createModal =true;
		 },



	},







}
</script>
