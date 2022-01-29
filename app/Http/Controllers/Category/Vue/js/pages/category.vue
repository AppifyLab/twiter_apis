<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						<span style="font-weight:bold;"> Total Categories : {{categories.total}}</span>
						<template slot="desc">All categories with search, create, edit and delete options.</template>
					</Alert>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="_box _b_radious3 _padd20">
						<div class="_1card_top _mar_b20">

							<div class="_1card_top_left">

								<div class="_1card_top_search">
									<Input @on-change="serchResetlt" v-model="str" suffix="ios-search" placeholder="Search categories by name ..." />
								</div>

							</div>
							<!--create-modal-start-->
							<addCategory :category="categories"/>
							<!-- <createAdmin :authorData="getAuthor"/> -->
							<!--create-modal-end-->

						</div>
						<div class="_table_responsive">
							<Table class="" border :columns="columns1" :data="categories.data">
									<template slot-scope="{row}" slot="cat_name">
										<p>{{row.cat_name}}</p>
									</template>
									<!-- <template slot-scope="{row}" slot="date">
                                        <p>{{row.created_at | dateFormat}}</p>
									</template> -->
									<template slot-scope="{row, index }" slot="action">
                                        <p>
											<!--create-modal-start-->
											<editCategory :category="row"/>
											<!--create-modal-end-->
										    <Button type="error" size="small" @click="deleteCategory(row, index)">Delete</Button>
                                        </p>
									</template>
							</Table>
						</div>
						<div class="_pagination _padd_t20">
							<Page :total="categories.total"  show-sizer :page-size-opts="pageOption" @on-page-size-change="getSizeChange"  @on-change="paginateDataInfo" />
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>

import _ from 'lodash';
import addCategory from '../../../../Category/Vue/js/components/category/addCategory'
import editCategory from '../../../../Category/Vue/js/components/category/editCategory'

export default {

	components: {
		addCategory,
		editCategory
	},
	data () {
		return {
            categories:[],
			// allCounts:'',
			isLoading:false,
			pageOption:[5,10,15,20],
			str:'',
			page:1,
			perPage:10,


			datacollection: null,
			columns1: [
				 {
                    title: 'Sl.',
                    width: 150,
					type:'index',
                    align: 'center',

					indexMethod: (row) => {
                        return (row._index + 1) + (this.perPage * this.page) - this.perPage;
                    }
                },
				{
					title: 'Category name',
					slot: 'cat_name',
					width:400,
				},
				// {
				// 	title: 'Date',
                //     align: 'center',
				// 	width:160,
				// 	slot: 'date'
				// },
				{
					title: 'Action',
                    minWidth: 350,
                    align: 'center',
					slot: 'action',
				},

			]
		}
	},

	methods: {
	async allCategories(){
		const res = await this.callApi('get', `/category/getAllCategories?page=${this.page}&perPage=${this.perPage}&str=${this.str}`)
			if(res.status==200){
				this.categories = res.data;
			}
	},

	serchResetlt:_.debounce(function (){
		this.perPage = 10
		this.paginateDataInfo(1)
	},200),

	getSizeChange(e){
		this.perPage =e
		this.paginateDataInfo(1)
	},
	paginateDataInfo(e){
	   this.page = e
		this.allCategories()
    },

    deleteCategory(cat, i){
	this.$Modal.confirm({
          title: 'Message',
          content: '<p>Are you sure to delete this Category ?</p>',
          onOk: async() => {
                    let obj ={
						cat_id: cat.id
					}
				const res = await this.callApi('post',`/category/deleteCategory/`, obj)

				if(res.status == 200){
					this.s('Category deleted successfully !!')
					this.categories.data.splice(i, 1);
					this.categories.total--
				}
				else{
					this.swr()
				}
          },

          onCancel: () => {

          }
      });
    },




	},

	async created () {
		this.allCategories()
	}
}
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper{
	width:130%;
}
</style>
