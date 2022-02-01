<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						<span style="font-weight:bold;"> Total users : {{admins.total}}</span>
						<template slot="desc">All users with search, create, edit and delete options.</template>
					</Alert>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="_box _b_radious3 _padd20">
						<div class="_1card_top _mar_b20">

							<div class="_1card_top_left">

								<!-- <div class="_1card_top_search">
									<Input @on-change="serchResetlt" v-model="str" suffix="ios-search" placeholder="Search admins by name, email, user & ..." />
								</div> -->

							</div>
							<!--create-modal-start-->
							<createAdmin :admin="admins"/>
							<!--create-modal-end-->

						</div>
						<div class="_table_responsive">
							<Table class="" border :columns="columns1" :data="admins.data">
									<template slot-scope="{row }" slot="name">
										<p>{{row.username}} </p>
									</template>

									<template slot-scope="{row}" slot="email">
                                        <p>{{row.email}}</p>
									</template>

								


									<template slot-scope="{row, index }" slot="action">
											<!--create-modal-start-->
												<editAdmin :admin="row"/>
											<!--create-modal-end-->
										<Button type="error" size="small" @click="deleteAdmin(row, index)">Delete</Button>
									</template>
							</Table>
						</div>
						<div class="_pagination _padd_t20">
							<Page :total="admins.total"  show-sizer :page-size-opts="pageOption" @on-page-size-change="getSizeChange"  @on-change="paginateDataInfo" />
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>

import _ from 'lodash';
import createAdmin from '../../../../Category/Vue/js/components/admin/createAdmin'
import editAdmin from '../../../../Category/Vue/js/components/admin/editAdmin'

export default {

	components: {
		createAdmin,
		editAdmin
	},
	data () {
		return {
            admins:[],
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
					title: 'Name',
					slot: 'name',
					width:250,
				},
				{
					title: 'Email',
					width:320,
					key: 'email'
				},
			
				{
					title: 'Action',
                    minWidth: 250,
                    align: 'center',
					slot: 'action',
				},

			],
		}
	},

	methods: {
	async allAdmins(){
		const res = await this.callApi('get', `/category/getAllAdmins?page=${this.page}&perPage=${this.perPage}&str=${this.str}`)
			if(res.status==200){
				this.admins = res.data;
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
		this.allAdmins()
    },

    deleteAdmin(user, i){
	this.$Modal.confirm({
          title: 'Message',
          content: '<p>Are you sure to delete this Admin ?</p>',
          onOk: async() => {
                    let obj ={
						uid: user.id
					}
				const res = await this.callApi('post',`/category/deleteAdmin/`, obj)

				if(res.status == 200){
					this.s('Admin deleted successfully !!')
					this.admins.data.splice(i, 1);
					this.admins.total--
				}
          },

          onCancel: () => {

          }
      });
    },




	},

	async created () {
		this.allAdmins()
	}
}
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper{
	width:130%;
}
</style>
