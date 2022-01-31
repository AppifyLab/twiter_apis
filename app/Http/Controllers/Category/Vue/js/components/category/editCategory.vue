<template>
    <span>

        <Button @click="editModalfunc" size="small" type="primary">Edit</Button>

		<Modal v-model="editModal" draggable  class-name="vertical-center-modal" scrollable title="Edit Category">
			<div class="_login_form">
			  <Form>
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.username">
								<Input v-model="form.username" @keyup.native="error.username=''" size="large" type="text" placeholder="Twitter account name"/>
							</FormItem>
						</div>
					</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button @click="editCategory" :loading="isLoading" :disabled="isLoading" icon="md-add" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Edit Twitter Account'}}</Button>
				<Button type="error" icon ="md-close" @click="editModal = false">Cancel</Button>
			</div>
		</Modal>
    </span>
</template>

<script>
export default {
	props:['category'],
	data(){
		return{
			editModal: false,
			isLoading:false,
			form:{
                cat_id:'',
				username:''
			},

			error:{
				username:''
			},


		}
	},

	methods:{
		async editCategory() {

			this.clearDataError();

			let flag = 1
			if(!this.form.username  || this.form.username.trim()=='' || this.form.username==null){
				this.error.username ='Twitter user  name is required!'
				flag = 0
			}

			if(flag==0) return

			this.isLoading = true;

			const res = await this.callApi('post','/category/editCategory', this.form)

			if(res.status==200 || res.status==201){
				this.editModal=false
				this.s("Twitter user  updated successfully!");
				this.category.username = this.form.username;
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
		 editModalfunc(){
			this.form.cat_id = this.category.id;
			this.form.username = this.category.username;
			this.editModal =true;
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
