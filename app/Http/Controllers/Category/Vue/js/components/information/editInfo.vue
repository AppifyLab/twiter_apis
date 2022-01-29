<template>
    <span>
		<Button @click="createModalfunc" size="small" type="primary">Edit</Button>

		<Modal v-model="createModal" draggable  class-name="vertical-center-modal" scrollable title="Edit Info">
			<div class="_login_form">
			  <Form>
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.action">
								<Input v-model="form.action" @keyup.native="error.action=''" type="text" placeholder="Info name"/>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.challenge">
								<Input v-model="form.challenge" @keyup.native="error.challenge=''" type="text" placeholder="Challenge"/>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.address">
								<Input v-model="form.address" @keyup.native="error.address=''" type="text" placeholder="Address"/>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.phone">
								<Input v-model="form.phone" @keyup.native="error.phone=''" type="text" placeholder="Phone"/>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.food_type">
								<Input v-model="form.food_type" @keyup.native="error.food_type=''" type="text" placeholder="Food Type"/>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.description">
								<Input v-model="form.description" @keyup.native="error.description=''" type="text" placeholder="Description"/>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.website">
								<Input v-model="form.website" @keyup.native="error.website=''" type="text" placeholder="Website"/>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.star_rating">
								<Input v-model="form.star_rating" @keyup.native="error.star_rating=''" type="text" placeholder="Star Rating"/>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.google_ratings">
								<Input v-model="form.google_ratings" @keyup.native="error.google_ratings=''" type="text" placeholder="Google Rating"/>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.category_id">
								<Select @on-change="handleSelect1" v-model="form.category_id" filterable multiple  placeholder="Select your category">
                                    <Option v-for="item in categories" :value="item.id" :key="item.id">{{ item.cat_name }}</Option>
                                </Select>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.subcategory_id">
								<Select @on-change="handleSelect2" v-model="form.subcategory_id" filterable multiple placeholder="Select your subcategory">
                                    <Option v-for="item in subcategories" :value="item.id" :key="item.id">{{ item.subcat_name }}</Option>
                                </Select>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.subSubcategory_id">
								<Select @on-change="handleSelect3" v-model="form.subSubcategory_id" filterable multiple placeholder="Select your sub-subcategory">
                                    <Option v-for="item in subSubcategories" :value="item.id" :key="item.id">{{ item.sub_subcat_name }}</Option>
                                </Select>
							</FormItem>
						</div>
					</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button @click="editInfo" :loading="isLoading" :disabled="isLoading" icon="md-add" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Edit Info'}}</Button>
				<Button type="error" icon ="md-close" @click="createModal = false">Cancel</Button>
			</div>
		</Modal>
    </span>
</template>

<script>
export default {
	props:['info'],
	data(){
		return{
            categories:[],
            subcategories:[],
            subSubcategories:[],
			createModal: false,
			isLoading:false,
			form:{
                action:'',
                challenge:'',
                address:'',
                phone:'',
                food_type:'',
                description:'',
                website:'',
                star_rating:'',
                google_ratings:'',
                category_id:[],
                subcategory_id:[],
                subSubcategory_id:[],
			},

			error:{
                action:'',
                challenge:'',
                address:'',
                phone:'',
                food_type:'',
                description:'',
                website:'',
                star_rating:'',
                google_ratings:'',
                category_id:'',
                subcategory_id:'',
                subSubcategory_id:'',
			},


		}
	},

	methods:{

		async editInfo() {

			this.clearDataError();

			let flag = 1
			if(!this.form.action  || this.form.action.trim()=='' || this.form.action==null){
				this.error.action ='Info name is required!'
				flag = 0
			}
			if(!this.form.challenge  || this.form.challenge==null){
				this.error.challenge ='Challenge is required!'
				flag = 0
			}

			if(flag==0) return

			this.isLoading = true;

			const res = await this.callApi('post','/category/editInformation', this.form)

			if(res.status==200 || res.status==201){
                let data = res.data;
				this.createModal=false
				this.s("Info updated successfully!");
				// this.info.total++
				this.info.action= this.form.action;
                this.info.challenge= this.form.challenge;
                this.info.address= this.form.address;
                this.info.phone= this.form.phone;
                this.info.food_type= this.form.food_type;
                this.info.description= this.form.description;
                this.info.website= this.form.website;
                this.info.star_rating= this.form.star_rating;
                this.info.google_ratings= this.form.google_ratings;
                this.info.categories= data.categories;
                this.info.subcategories= data.subcategories;
                this.info.sub_subcategories= data.sub_subcategories;
				// this.clearData()
			}
			this.isLoading = false;

		},
        async handleSelect1(data){
            this.getSubcategies(this.form.category_id)
        },
        async handleSelect2(data){
            this.getSubsubcategies(this.form.subcategory_id)
        },
        async handleSelect3(data){
            // this.getSubsubcategies(this.form.subcategory_id)
        },
        async getCategories(){
            const res = await this.callApi('get', '/category/getCategories')
            if(res.status == 200){
                this.categories = res.data;
            }
        },
        async getSubcategies(ids){
            const res = await this.callApi('get', `/category/getSubcategories?cat_id=${ids}`)
            if(res.status == 200){
                this.subcategories = res.data;
            }
        },
        async getSubsubcategies(ids){
            const res = await this.callApi('get', `/category/getSubsubcategories?subcat_id=${ids}`)
            if(res.status == 200){
                this.subSubcategories = res.data;
            }
        },
		clearDataError() {
			this.error = {
                info_id:'',
                action:'',
                challenge:'',
                address:'',
                phone:'',
                food_type:'',
                description:'',
                website:'',
                star_rating:'',
                google_ratings:'',
                category_id:'',
                subcategory_id:'',
                subSubcategory_id:'',
		   }
    	},

		 createModalfunc(){
             let categories = [];
             for(let item of this.info.categories){
                 categories.push(item.id)
             }

             let subcategories = [];
             for(let item of this.info.subcategories){
                 subcategories.push(item.id)
             }

             let sub_subcategories = [];
             for(let item of this.info.sub_subcategories){
                 sub_subcategories.push(item.id)
             }

                this.form.info_id= this.info.id,
                this.form.action= this.info.action,
                this.form.challenge= this.info.challenge,
                this.form.address= this.info.address,
                this.form.phone= this.info.phone,
                this.form.food_type= this.info.food_type,
                this.form.description= this.info.description,
                this.form.website= this.info.website,
                this.form.star_rating= this.info.star_rating,
                this.form.google_ratings= this.info.google_ratings,
                this.form.category_id= categories,
                this.form.subcategory_id= subcategories,
                this.form.subSubcategory_id= sub_subcategories,
            this.getCategories();
			this.getSubcategies(this.form.category_id)
            this.getSubsubcategies(this.form.subcategory_id)
            this.clearDataError();
			this.createModal =true;
		 },



	}






}
</script>
<style scoped>

</style>
