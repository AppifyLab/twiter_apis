<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						<!-- <span style="font-weight:bold;"> Total Twitter : {{twitterData.total}}</span> -->
						<template slot="desc">Twitter user name.</template>
					</Alert>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="_box _b_radious3 _padd20">
						<div class="_1card_top _mar_b20">

							<div class="_1card_top_left">

								<div class="_1card_top_search">
									<!-- <Input @on-change="serchResetlt" v-model="str" suffix="ios-search" placeholder="Search twiter by name ..." /> -->
								</div>

							</div>
					
							<addCategory v-if="!twitterData.data || twitterData.data.length<=0" :category="twitterData"/>
						

						</div>
						<div class="_table_responsive">
							<Table class="" border :columns="columns1" :data="twitterData.data">
									<template slot-scope="{row}" slot="username">
										<p>{{row.username}}</p>
									</template>
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
							<Page :total="twitterData.total"  show-sizer :page-size-opts="pageOption" @on-page-size-change="getSizeChange"  @on-change="paginateDataInfo" />
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
            twitterData:[],
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
					title: 'User name',
					slot: 'username',
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
	async alltwitterData(){
		const res = await this.callApi('get', `/category/getAlltwitterData?page=${this.page}&perPage=${this.perPage}&str=${this.str}`)
			if(res.status==200){
				this.twitterData = res.data;
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
		this.alltwitterData()
    },

    deleteCategory(cat, i){
	this.$Modal.confirm({
          title: 'Message',
          content: '<p>Are you sure to delete this Twitter account ?</p>',
          onOk: async() => {
                    let obj ={
						cat_id: cat.id
					}
				const res = await this.callApi('post',`/category/deleteCategory/`, obj)

				if(res.status == 200){
					this.s('Twitter account deleted successfully !!')
					this.twitterData.data.splice(i, 1);
					this.twitterData.total--
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
		this.alltwitterData()
	}
}
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper{
	width:130%;
}
</style>
