<template>
    <span>
			<Button @click="createModalfunc" size="small" type="primary">Edit</Button>

		<Modal v-model="createModal" draggable  class-name="vertical-center-modal" scrollable title="Edit Sub-subcategory">
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
							<FormItem :error="error.subcategory_id">
								<Select v-model="form.subcategory_id" filterable  placeholder="Select subcategory">
                                    <Option v-for="item in subcategories" :value="item.id" :key="item.id">{{ item.subcat_name }}</Option>
                                </Select>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.sub_subcat_name">
								<Input v-model="form.sub_subcat_name" @keyup.native="error.sub_subcat_name=''" size="large" type="text" placeholder="Sub-subcategory name"/>
							</FormItem>
						</div>
					</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button @click="editSubsubcategory" :loading="isLoading" :disabled="isLoading" icon="md-add" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Edit Sub-subcategory'}}</Button>
				<Button type="error" icon ="md-close" @click="createModal = false">Cancel</Button>
			</div>
		</Modal>
    </span>
</template>

<script>
export default {
	props:['subSubcategory'],
	data(){
		return{
            categories:[],
            subcategories:[],
			createModal: false,
			isLoading:false,
			form:{
                sub_subcat_id:'',
                category_id:'',
                subcategory_id:'',
				sub_subcat_name:''
			},

			error:{
                category_id:'',
                subcategory_id:'',
				sub_subcat_name:''
			},


		}
	},

	methods:{
		async editSubsubcategory() {

			this.clearDataError();

			let flag = 1
			if(!this.form.sub_subcat_name  || this.form.sub_subcat_name.trim()=='' || this.form.sub_subcat_name==null){
				this.error.sub_subcat_name ='Sub-subcategory name is required!'
				flag = 0
			}
			if(!this.form.category_id  || this.form.category_id==null){
				this.error.category_id ='Category is required!'
				flag = 0
			}
			if(!this.form.subcategory_id  || this.form.subcategory_id==null){
				this.error.subcategory_id ='Subategory is required!'
				flag = 0
			}

			if(flag==0) return

			this.isLoading = true;

			const res = await this.callApi('post','/category/editSubsubcategory', this.form)

			if(res.status==200){
                let data = res.data;
				this.createModal=false
				this.s("Sub-subcategory updated successfully!");
				this.subSubcategory.category_id = this.form.category_id
				this.subSubcategory.subcategory_id = this.form.subcategory_id
				this.subSubcategory.sub_subcat_name = this.form.sub_subcat_name
				this.subSubcategory.category.cat_name = data.category?data.category.cat_name :'';
				this.subSubcategory.subcategory.subcat_name = data.subcategory ? data.subcategory.subcat_name : '';
			}
			this.isLoading = false;

		},
        async getCategories(){
            const res = await this.callApi('get', '/category/getCategories')
            if(res.status == 200){
                this.categories = res.data;
            }
        },
        async getSubcategies(){
            const res = await this.callApi('get', '/category/getSubcategories')
            if(res.status == 200){
                this.subcategories = res.data;
            }
        },
		clearDataError() {
			this.error = {
                category_id:'',
                subcategory_id:'',
				sub_subcat_name:''
		   }
    	},
		clearData() {
			this.form = {
                category_id:'',
                subcategory_id:'',
				sub_subcat_name:''
			}
		},
		 createModalfunc(){
             this.form.sub_subcat_id = this.subSubcategory.id;
             this.form.category_id = this.subSubcategory.category_id;
             this.form.subcategory_id = this.subSubcategory.subcategory_id;
             this.form.sub_subcat_name = this.subSubcategory.sub_subcat_name;
            this.getCategories();
            this.getSubcategies();
            this.clearDataError();
			this.createModal =true;
		 },



	}






}
</script>
<style scoped>

</style>
