<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						<span style="font-weight:bold;"> Total tweets : {{twitterData.total}}</span>
						<template slot="desc">All tweets.</template>
					</Alert>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="_box _b_radious3 _padd20">
						<div class="_1card_top _mar_b20">

							<div class="_1card_top_left">

								<div class="_1card_top_search">
                                    
                                    <a v-if="!$store.state.authUser.is_connected" href="/social/login"><Button>Connect</Button></a>
                                    <Button v-if="twitterData && twitterData.data && twitterData.data.length>0 && !$store.state.authUser.is_ins_scheduled && !isLoading" @click="postInstagramForFirstTime">Schedule instagram post</Button>
                                    <Button v-if="isLoading"> Loading..</Button>
                                    <!-- <Button v-if="!twitterData || !twitterData.data || twitterData.data.length==0" @click="featchTweetes">Fetch popular twitter post</Button> -->
                                    
								</div>

							</div>
					
						

						</div>
						<div class="_table_responsive">
							<Table class="" border :columns="columns1" :data="twitterData.data">
									<template slot-scope="{row}" slot="text">
										<p>{{row.text}}</p>
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

export default {

	data () {
		return {
            // isLoading:false,
            user:{},
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
					title: 'Total likes',
					key: 'like',
					width:150,
				},
				
                {
					title: 'Twitter post id',
					key: 'twitter_id',
					width:250,
				},
                 {
					title: 'Status',
					key: 'is_published',
					width:250,
				},
                {
					title: 'Content',
					slot: 'text',
					width:800,
				}
			

			],

		}
	},

	methods: {
    async connectFacebook(){
		const res = await this.callApi('get', `/social/login`)
        console.log(res)

    },
	async alltwitterData(){
		const res = await this.callApi('get', `/twitter/getAllTwitterPostList?page=${this.page}&perPage=${this.perPage}&str=${this.str}`)
			if(res.status==200){
				this.twitterData = res.data;
			}
	},
    async featchTweetes(){
        const res = await this.callApi('get', `/social/featchTweetes`)
			if(res.status==200){
				// this.twitterData = res.data;
			}
            console.log(res)
    },

    async postInstagramForFirstTime(){
        // this.isLoading = true
        // return 
        this.isLoading = true
        const res = await this.callApi('get', `/social/postInstagramForFirstTime`)
        this.isLoading = false
			if(res.status==200){
                if(!this.$store.state.authUser.is_ins_scheduled){
                    this.$store.state.authUser.is_ins_scheduled =1
                }
			}
            console.log(res)
    },
    

	serchResetlt:_.debounce(function (){
		this.perPage = 10
		this.paginateDataInfo(1)
	},200),

	getSizeChange(e){
		this.perPage =e
		this.paginateDataInfo(1)
	},
    async getUser(){
         const res = await this.callApi('get', `/twitter/geTwitterUser`)
			if(res.status==200){
				this.user = res.data
			}
    },
	paginateDataInfo(e){
	   this.page = e
		this.alltwitterData()
    }

	},

	async created () {
		this.alltwitterData()
        this.getUser()
	}
}
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper{
	width:130%;
}
</style>
