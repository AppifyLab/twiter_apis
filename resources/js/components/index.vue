<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						Custom icon
						<Icon type="ios-bulb-outline" slot="icon"></Icon>
						<template slot="desc">Custom icon copywriting. Custom icon copywriting. Custom icon copywriting. </template>
					</Alert>
				</div>

				<div class="col-12 col-md-6 col-lg-3 _mar_b20" >
					<div class="_box _b_radious3">
						<div class="_dash_card">
							<div class="_dash_card_icon">
								<Icon type="md-cash" />
							</div>
							<div class="_dash_card_details">
								<p class="_dash_card_amm">110</p>
								<p class="_dash_card_title">Total Items</p>
							</div>
						</div>
					</div>
				</div>
					<div class="col-12 col-md-6 col-lg-3 _mar_b20" >
					<div class="_box _b_radious3">
						<div class="_dash_card">
							<div class="_dash_card_icon">
								<Icon type="md-cash" />
							</div>
							<div class="_dash_card_details">
								<p class="_dash_card_amm">200</p>
								<p class="_dash_card_title">Total Categories</p>
							</div>
						</div>
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3 _mar_b20"  >
					<div class="_box _b_radious3">
						<div class="_dash_card">
							<div class="_dash_card_icon">
								<Icon type="ios-cart" />
							</div>
							<div class="_dash_card_details" >
								<p class="_dash_card_amm">300</p>
								<p class="_dash_card_title">Total Subcategories</p>
							</div>
						</div>
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3 _mar_b20" >
					<div class="_box _b_radious3">
						<div class="_dash_card">
							<div class="_dash_card_icon">
								<Icon type="ios-link" />
							</div>
							<div class="_dash_card_details" >
								<p class="_dash_card_amm">400</p>
								<p class="_dash_card_title">Total Sub-subcategories</p>
							</div>
						</div>
					</div>
				</div>


			
			</div>
		</div>
	</div>
</template>

<script>

// import LineChart from "./charJS_component.vue";

export default {
	components: {
		// LineChart
	},

	data () {
		return {
			alldata:[],
			datacollection: null,
			// columns1: [
			// 	{
			// 		title: 'Name',
			// 		key: 'name'
			// 	},
			// 	{
			// 		title: 'Age',
			// 		key: 'age'
			// 	},
			// 	{
			// 		title: 'Address',
			// 		key: 'address'
			// 	}
			// ],
			// data1: [
			// 	{
			// 		name: 'John Brown',
			// 		age: 18,
			// 		address: 'New York No. 1 Lake Park',
			// 		date: '2016-10-03'
			// 	},
			// 	{
			// 		name: 'Jim Green',
			// 		age: 24,
			// 		address: 'London No. 1 Lake Park',
			// 		date: '2016-10-01'
			// 	},
			// 	{
			// 		name: 'Joe Black',
			// 		age: 30,
			// 		address: 'Sydney No. 1 Lake Park',
			// 		date: '2016-10-02'
			// 	},
			// 	{
			// 		name: 'Jon Snow',
			// 		age: 26,
			// 		address: 'Ottawa No. 2 Lake Park',
			// 		date: '2016-10-04'
			// 	},
			// 	{
			// 		name: 'Jim Green',
			// 		age: 24,
			// 		address: 'London No. 1 Lake Park',
			// 		date: '2016-10-01'
			// 	},
			// 	{
			// 		name: 'Joe Black',
			// 		age: 30,
			// 		address: 'Sydney No. 1 Lake Park',
			// 		date: '2016-10-02'
			// 	},
			// 	{
			// 		name: 'Jon Snow',
			// 		age: 26,
			// 		address: 'Ottawa No. 2 Lake Park',
			// 		date: '2016-10-04'
			// 	}
			// ]
		}
	},

	methods: {
		fillData () {
			this.datacollection = {
			labels: [this.getRandomInt(), this.getRandomInt()],
			datasets: [
				{
				label: 'Data One',
				backgroundColor: '#f87979',
				data: [this.getRandomInt(), this.getRandomInt()]
				}, {
				label: 'Data One',
				backgroundColor: '#f87979',
				data: [this.getRandomInt(), this.getRandomInt()]
				}
			]
			}
		},
		getRandomInt () {
			return Math.floor(Math.random() * (50 - 5 + 1)) + 5
		}
	},

	mounted () {
		this.fillData()
	},
	async created(){
		// const res = await this.callApi('get', `/category/stath`)
		// 	if(res.status==200){
		// 		this.alldata = res.data
		// 	}
		
	}
}
</script>
