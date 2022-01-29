<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						<span style="font-weight:bold;"> Total Sub-subcategories : {{subSubcategories.total}}</span>
						<template slot="desc">All Sub-subcategories with search, create, edit and delete options.</template>
					</Alert>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="_box _b_radious3 _padd20">
						<div class="_1card_top _mar_b20">

							<div class="_1card_top_left">

								<div class="_1card_top_search">
									<Input @on-change="serchResetlt" v-model="str" suffix="ios-search" placeholder="Search Sub-subcategories by name ..." />
								</div>

							</div>
							<!--create-modal-start-->
							<addSubsubcategory :subSubcategory="subSubcategories"/>
							<!--create-modal-end-->

						</div>
						<div class="_table_responsive">
							<Table class="" border :columns="columns1" :data="subSubcategories.data">
									<template slot-scope="{row}" slot="subcat_name">
										<p>{{row.sub_subcat_name}}</p>
									</template>
									<template slot-scope="{row}" slot="category">
                                        <p>{{row.category? row.category.cat_name :''}}</p>
									</template>
									<template slot-scope="{row}" slot="subcategory">
                                        <p>{{row.subcategory? row.subcategory.subcat_name :''}}</p>
									</template>
									<template slot-scope="{row, index }" slot="action">
                                        <p>
											<!--create-modal-start-->
											<editSubsubcategory :subSubcategory="row"/>
											<!--create-modal-end-->
										    <Button type="error" size="small" @click="deleteSubsubcategory(row, index)">Delete</Button>
                                        </p>
									</template>
							</Table>
						</div>
						<div class="_pagination _padd_t20">
							<Page :total="subSubcategories.total"  show-sizer :page-size-opts="pageOption" @on-page-size-change="getSizeChange"  @on-change="paginateDataInfo" />
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>

import _ from 'lodash';
import addSubsubcategory from '../../../../Category/Vue/js/components/subSubcategory/addSubsubcategory'
import editSubsubcategory from '../../../../Category/Vue/js/components/subSubcategory/editSubsubcategory'

export default {

	components: {
		addSubsubcategory,
		editSubsubcategory
	},
	data () {
		return {
            subSubcategories:[],
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
					title: 'Subcategory name',
					slot: 'subcat_name',
					width:250,
				},
				{
					title: 'Category',
					width:250,
					slot: 'category'
				},
				{
					title: 'Subcategory',
					width:250,
					slot: 'subcategory'
				},
				{
					title: 'Action',
                    minWidth: 250,
                    align: 'center',
					slot: 'action',
				},

			]
		}
	},

	methods: {
	async allSubsubcategories(){
		const res = await this.callApi('get', `/category/getAllSubsubcategories?page=${this.page}&perPage=${this.perPage}&str=${this.str}`)
			if(res.status==200){
				this.subSubcategories = res.data;
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
		this.allSubsubcategories()
    },

    deleteSubsubcategory(subcat, i){
	this.$Modal.confirm({
          title: 'Message',
          content: '<p>Are you sure to delete this Sub-subcategory ?</p>',
          onOk: async() => {
                    let obj ={
						sub_subcat_id: subcat.id
					}
				const res = await this.callApi('post',`/category/deleteSubsubcategory/`, obj)

				if(res.status == 200){
					this.s('Sub-subcategory deleted successfully !!')
					this.subSubcategories.data.splice(i, 1);
					this.subSubcategories.total--
				}
          },

          onCancel: () => {

          }
      });
    },




	},

	async created () {
		this.allSubsubcategories()
	}
}
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper{
	width:130%;
}
</style>
