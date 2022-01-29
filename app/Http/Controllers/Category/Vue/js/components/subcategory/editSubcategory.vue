<template>
    <span>
		<Button @click="createModalfunc" size="small" type="primary">Edit</Button>

		<Modal v-model="createModal" draggable  class-name="vertical-center-modal" scrollable title="Edit Subcategory">
			<div class="_login_form">
			  <Form>
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.category_id">
								<Select v-model="form.category_id" filterable placeholder="Select category">
                                    <Option v-for="item in categories" :value="item.id" :key="item.id">{{ item.cat_name }}</Option>
                                </Select>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.subcat_name">
								<Input v-model="form.subcat_name" @keyup.native="error.subcat_name=''" type="text" placeholder="Subcategory name"/>
							</FormItem>
						</div>
					</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button @click="editSubcategory" :loading="isLoading" :disabled="isLoading" icon="md-add" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Edit Subcategory'}}</Button>
				<Button type="error" icon ="md-close" @click="createModal = false">Cancel</Button>
			</div>
		</Modal>
    </span>
</template>

<script>
export default {
	props:['subcategory'],
	data(){
		return{
            categories:[],
			createModal: false,
			isLoading:false,
			form:{
                subcat_id:'',
                category_id:'',
				subcat_name:''
			},

			error:{
                category_id:'',
				subcat_name:''
			},


		}
	},

	methods:{
		async editSubcategory() {

			this.clearDataError();

			let flag = 1
			if(!this.form.subcat_name  || this.form.subcat_name.trim()=='' || this.form.subcat_name==null){
				this.error.subcat_name ='Subcategory name is required!'
				flag = 0
			}
			if(!this.form.category_id  || this.form.category_id==null){
				this.error.category_id ='Category is required!'
				flag = 0
			}

			if(flag==0) return

			this.isLoading = true;

			const res = await this.callApi('post','/category/editSubcategory', this.form)

			if(res.status==200){
				this.createModal=false
				this.s("Subcategory created successfully!");
				this.subcategory.subcat_name = this.form.subcat_name
				this.subcategory.category_id = this.form.category_id
				this.subcategory.category.cat_name = res.data.category ? res.data.category.cat_name : '';
				this.clearData()
			}
			this.isLoading = false;

		},
        async getCategories(){
            const res = await this.callApi('get', '/category/getCategories')
            if(res.status == 200){
                this.categories = res.data;
            }
        },
		clearDataError() {
			this.error = {
                category_id:'',
				subcat_name:''
		   }
    	},
		clearData() {
			this.form = {
                category_id:'',
				subcat_name:''
			}
		},
		 createModalfunc(){
            this.form.subcat_id = this.subcategory.id;
            this.form.category_id = this.subcategory.category_id;
            this.form.subcat_name = this.subcategory.subcat_name;
            this.getCategories();
            this.clearDataError();
			this.createModal =true;
		 },



	}






}
</script>
<style scoped>

</style>
