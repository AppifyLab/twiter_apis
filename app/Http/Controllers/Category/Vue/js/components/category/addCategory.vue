<template>
    <span>

		<div class="_1card_top_right">
			<ul class="_1card_top_right_list">
				<li><template>
					<Button @click="createModalfunc" icon="md-add" type="primary">Add Twitter Account</Button>
				</template></li>
			</ul>
		</div>

		<Modal v-model="createModal" draggable  class-name="vertical-center-modal" scrollable title="Create twitter account">
			<div class="_login_form">
			  <Form>
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.username">
								<Input v-model="form.username" @keyup.native="error.username=''" size="large" type="text" placeholder="Twitter name"/>
							</FormItem>
						</div>
					</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button @click="addCategory" :loading="isLoading" :disabled="isLoading" icon="md-add" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Add twitter account'}}</Button>
				<Button type="error" icon ="md-close" @click="createModal = false">Cancel</Button>
			</div>
		</Modal>
    </span>
</template>

<script>
export default {
	props:['category'],
	data(){
		return{
			createModal: false,
			isLoading:false,
			form:{
				username:''
			},

			error:{
				username:''
			},


		}
	},

	methods:{
		async addCategory() {

			this.clearDataError();

			let flag = 1
			if(!this.form.username  || this.form.username.trim()=='' || this.form.username==null){
				this.error.username ='Twitter account name is required!'
				flag = 0
			}

			if(flag==0) return

			this.isLoading = true;

			const res = await this.callApi('post','/category/addCategory', this.form)

			if(res.status==200 || res.status==201){
				this.createModal=false
				this.s("Twitter account created successfully!");
				this.category.total++
				this.category.data.unshift(res.data)
				this.clearData()
			}
			this.isLoading = false;

		},
		clearDataError() {
			this.error = {
				username:''
		   }
    	},
		clearData() {
			this.form = {
				username:''
			}
		},
		 createModalfunc(){
			this.clearData();
			this.createModal =true;
		 },



	}






}
</script>
<style scoped>
/* .ivu-btn[disabled]{
    background: #2d8cf0;
}

._1input_pass span{
	top: 2px;
}
._1input_pass span i{
	font-size: 18px;
} */

</style>
