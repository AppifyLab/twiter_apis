<template>
    <span>

		<div class="_1card_top_right">
			<ul class="_1card_top_right_list">
				<li><template>
					<Button @click="createModalfunc" icon="md-add" type="primary">Add New</Button>
				</template></li>
			</ul>
		</div>

		<Modal v-model="createModal" draggable  class-name="vertical-center-modal" scrollable title="Create New Info">
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
						<div class="col-12 col-md-12 col-lg-12" v-if="subcategories.length > 0">
							<FormItem :error="error.subcategory_id">
								<Select @on-change="handleSelect2" v-model="form.subcategory_id" filterable multiple placeholder="Select your subcategory">
                                    <Option v-for="item in subcategories" :value="item.id" :key="item.id">{{ item.subcat_name }}</Option>
                                </Select>
							</FormItem>
						</div>
						<div class="col-12 col-md-12 col-lg-12" v-if="subSubcategories.length > 0">
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
				<Button @click="addInfo" :loading="isLoading" :disabled="isLoading" icon="md-add" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Add Info'}}</Button>
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

		async addInfo() {

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

			const res = await this.callApi('post','/category/addInformation', this.form)

			if(res.status==200 || res.status==201){
				this.createModal=false
				this.s("Info created successfully!");
				this.info.total++
				this.info.data.unshift(res.data)
				this.clearData()
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
		clearData() {
			this.form = {
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
            this.getCategories();
			this.clearData();
            this.clearDataError();
			this.createModal =true;
		 },



	}






}
</script>
<style scoped>

</style>
