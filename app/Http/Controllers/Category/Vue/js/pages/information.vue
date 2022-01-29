<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						<span style="font-weight:bold;"> Total Informations : {{infos.total}}</span>
						<template slot="desc">All Informations with search, create, edit and delete options.</template>
					</Alert>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="_box _b_radious3 _padd20">
						<div class="_1card_top _mar_b20">

							<div class="_1card_top_left">

								<div class="_1card_top_search">
									<Input @on-change="serchResetlt" v-model="str" suffix="ios-search" placeholder="Search Informations ..." />
								</div>

							</div>
							<!--create-modal-start-->
							<addInfo :info="infos"/>
							<!--create-modal-end-->

						</div>
						<div class="_table_responsive">
							<Table class="" border :columns="columns1" :data="infos.data">
									<template slot-scope="{row}" slot="info_name">
										<p>{{row.action}}</p>
									</template>
									<template slot-scope="{row}" slot="challenge">
                                        <p>{{row.challenge}}</p>
									</template>
									<template slot-scope="{row}" slot="address">
                                        <p>{{row.address}}</p>
									</template>
									<template slot-scope="{row}" slot="phone">
                                        <p>{{row.phone}}</p>
									</template>
									<template slot-scope="{row}" slot="food_type">
                                        <p>{{row.food_type}}</p>
									</template>
									<template slot-scope="{row}" slot="description">
                                        <p>{{row.description}}</p>
									</template>
									<template slot-scope="{row}" slot="website">
                                        <p>{{row.website}}</p>
									</template>
									<template slot-scope="{row}" slot="star_rating">
                                        <p>{{row.star_rating}}</p>
									</template>
									<template slot-scope="{row}" slot="google_rating">
                                        <p>{{row.action}}</p>
									</template>
									<template slot-scope="{row}" slot="category">
                                        <p>
                                            <span style="margin-right: 2px;" v-for="(item,i) in row.categories" :key="i">
                                                <Button size="small">{{item.cat_name}}</Button>
                                            </span>
                                        </p>
									</template>
									<template slot-scope="{row}" slot="subcategory">
                                        <p>
                                            <span style="margin-right: 2px;" v-for="(item,i) in row.subcategories" :key="i">
                                                <Button size="small">{{item.subcat_name}}</Button>
                                            </span>
                                        </p>
									</template>
									<template slot-scope="{row}" slot="subSubcategory">
                                        <p>
                                            <span style="margin-right: 2px;" v-for="(item,i) in row.sub_subcategories" :key="i">
                                                <Button size="small">{{item.sub_subcat_name}}</Button>
                                            </span>
                                        </p>
									</template>
									<template slot-scope="{row, index }" slot="action">
                                        <p>
											<!--create-modal-start-->
											<editInfo :info="row"/>
											<!--create-modal-end-->
										    <Button type="error" size="small" @click="deleteCategory(row, index)">Delete</Button>
                                        </p>
									</template>
							</Table>
						</div>
						<div class="_pagination _padd_t20">
							<Page :total="infos.total"  show-sizer :page-size-opts="pageOption" @on-page-size-change="getSizeChange"  @on-change="paginateDataInfo" />
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>

import _ from 'lodash';
import addInfo from '../../../../Category/Vue/js/components/information/addInfo.vue'
import editInfo from '../../../../Category/Vue/js/components/information/editInfo'

export default {

	components: {addInfo,editInfo},
	data () {
		return {
            infos:[],
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
					title: 'Info name',
					slot: 'info_name',
					width:200,
				},
				{
					title: 'Challenge',
					width:200,
					slot: 'challenge'
				},
				{
					title: 'Address',
					width:200,
					slot: 'address'
				},
				{
					title: 'Phone',
					width:200,
					slot: 'phone'
				},
				{
					title: 'Food Type',
					width:200,
					slot: 'food_type'
				},
				{
					title: 'Description',
					width:200,
					slot: 'description'
				},
				{
					title: 'Website',
					width:200,
					slot: 'website'
				},
				{
					title: 'Star Rating',
					width:200,
					slot: 'star_rating'
				},
				{
					title: 'Google Rating',
					width:200,
					slot: 'google_rating'
				},
				{
					title: 'Category',
					width:300,
					slot: 'category'
				},
				{
					title: 'Subcategory',
					width:300,
					slot: 'subcategory'
				},
				{
					title: 'Sub-subcategory',
					width:300,
					slot: 'subSubcategory'
				},
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
	async allinfos(){
		const res = await this.callApi('get', `/category/getAllInfo?page=${this.page}&perPage=${this.perPage}&str=${this.str}`)
			if(res.status==200){
				this.infos = res.data;
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
		this.allinfos()
    },

    deleteCategory(inf, i){
	this.$Modal.confirm({
          title: 'Message',
          content: '<p>Are you sure to delete this information ?</p>',
          onOk: async() => {
                    let obj ={
						info_id: inf.id
					}
				const res = await this.callApi('post',`/category/deleteInformation/`, obj)

				if(res.status == 200){
					this.s('Information deleted successfully !')
					this.infos.data.splice(i, 1);
					this.infos.total--
				}
          },

          onCancel: () => {

          }
      });
    },




	},

	async created () {
		this.allinfos()
	}
}
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper{
	width:130%;
}
</style>
