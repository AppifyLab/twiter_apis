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
                                    <Button v-if="twitterData && twitterData.data && twitterData.data.length>0 && !$store.state.authUser.is_ins_scheduled && !isLoading && $store.state.authUser.bussness_id" @click="postInstagramForFirstTime">Schedule instagram post</Button>
                                    <Button v-if="isLoading"> Loading..</Button>
                                    <Button @click="getYourFbPages" v-if="!isLoading && !$store.state.authUser.bussness_id && $store.state.authUser.is_connected"> Connect your facebook page..</Button>
                                    
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
			<Modal v-model="fbPagesModal" draggable  class-name="vertical-center-modal" scrollable title="Create twitter account">
			<div class="_login_form">
			  <Form>
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12" v-if="pages.length">
							<FormItem >
								   <Select v-model="pageIndex" style="width:200px">
										<Option v-for="(item,index) in pages" :value="index" :key="index">{{ item.name }}</Option>
									</Select>

							</FormItem>
						</div>
					</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button @click="connectBussnessId" :loading="isLoading" :disabled="isLoading" icon="md-add" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Add instagram account and post twitits'}}</Button>
				<Button type="error" icon ="md-close" @click="fbPagesModal = false">Cancel</Button>
			</div>
		</Modal>

	</div>
</template>

<script>

import _ from 'lodash';

export default {

	data () {
		return {
			pageIndex:-1,
            fbPagesModal:false,
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
			pages:[]

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
    },
	async getYourFbPages(){
		this.isLoading = true
		const res = await this.callApi('get','/social/getFbPage')
		this.isLoading = false
		if(res.status==200){
			this.pages = res.data
			this.fbPagesModal = true
		}
		
	},
	async connectBussnessId(){
		console.log(this.pageIndex)
		if(this.pageIndex==null || this.pageIndex<=-1) return
		
		let ob = this.pages[this.pageIndex]
		const res = await this.callApi('post','/social/connectBussnessId',ob)
		this.isLoading = false
		if(res.status==200){
			this.$store.state.authUser.bussness_id =1
			this.s("You are successfully connected your instagram account!")
			this.fbPagesModal = false
		}
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
