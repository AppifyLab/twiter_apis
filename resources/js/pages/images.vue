<template>
  <div>
    <div class="_main_content">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12 _mar_b10">
          <!-- <Alert show-icon>
						<span style="font-weight:bold;"> Total tweets : {{imageData.total}}</span>
						<template slot="desc">All tweets.</template>
					</Alert> -->
          <Modal
            v-model="modal1"
            title="Common Modal dialog box title"
            :footer-hide="true"
          >
            <Upload
              ref="upload"
              type="drag"
              :show-upload-list="false"
              :with-credentials="true"
              :headers="crfObj"
              :on-success="handleSuccess"
              :format="['jpg', 'jpeg', 'png', 'webp']"
              :max-size="5000"
              :action="`/images/iviewShowImage`"
              :on-format-error="handleFormatError"
              :on-exceeded-size="handleMaxSize"
            >
              <div style="padding: 20px 0">
                <Icon
                  type="ios-cloud-upload"
                  size="52"
                  style="color: #3399ff"
                ></Icon>
                <p>Click or drag files here to upload</p>
              </div>
            </Upload>
          </Modal>
        </div>
        <div v-if="image">
          <img style="width: 250px" v-if="image" :src="image" alt="" />
          <Button @click="image = false">Delete</Button>
          <Button @click="imageUpload(image)">Upload</Button>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
          <div class="_box _b_radious3 _padd20">
            <div class="_1card_top _mar_b20">
              <div class="_1card_top_left">
                <div class="_1card_top_search">
                  <a
                    @click="modal1 = true"
                    ><Button>Upload Image</Button></a
                  >
                  <Button
                    v-if="
                      imageData &&
                      imageData.data &&
                      imageData.data.length > 0 &&
                      !$store.state.authUser.is_ins_scheduled &&
                      !isLoading &&
                      $store.state.authUser.bussness_id
                    "
                    @click="postInstagramForFirstTime"
                    >Schedule instagram post</Button
                  >
                  <Button v-if="isLoading"> Loading..</Button>
                  <Button
                    @click="getYourFbPages"
                    v-if="
                      !isLoading &&
                      !$store.state.authUser.bussness_id &&
                      $store.state.authUser.is_connected
                    "
                  >
                    Connect your facebook page..</Button
                  >
                </div>
              </div>
            </div>
            <div class="_table_responsive">
              <!-- <Table
                class=""
                border
                :columns="columns1"
                :data="imageData.data"
              >
                <template slot-scope="{ row }" slot="image">
                  <img style="width: 28px" :src="row.image" alt="" />
                </template>
				<template slot-scope="{ row }" slot="action">
                  <Button type="error" size="small" @click="remove(row)"
                    >Delete
                  </Button>
                </template>
              </Table> -->
              <div v-for="(item,index) in imageData" :key="index" class="_table_item">
                <!-- <p> {{item.image}} </p> -->
                  <img style="width: 100px" :src="item.image" alt="">
                  <Button type="error" size="small" @click="remove(item, index)"
                    >Delete
                  </Button>
                  <Button type="primary" size="small" @click="viewImage(item)"
                    >View
                  </Button>
              </div>
            </div>
            <!-- <div class="_pagination _padd_t20">
              <Page
                :total="imageData.total"
                show-sizer
                :page-size-opts="pageOption"
                @on-page-size-change="getSizeChange"
                @on-change="paginateDataInfo"
              />
            </div> -->
          </div>
        </div>
      </div>
    </div>
    <Modal
      v-model="fbPagesModal"
      draggable
      class-name="vertical-center-modal"
      scrollable
      title="Add Image"
    >
      <div class="_login_form">
        <Form>
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12" v-if="pages.length">
              <FormItem>
                <Select v-model="pageIndex" style="width: 200px">
                  <Option
                    v-for="(item, index) in pages"
                    :value="index"
                    :key="index"
                    >{{ item.name }}</Option
                  >
                </Select>
              </FormItem>
            </div>
          </div>
        </Form>
      </div>
      <div slot="footer">
        <Button
          @click="connectBussnessId"
          :loading="isLoading"
          :disabled="isLoading"
          icon="md-add"
          type="primary"
          >{{
            isLoading
              ? "Please wait . . ."
              : "Add instagram account and post twitits"
          }}</Button
        >
        <Button type="error" icon="md-close" @click="fbPagesModal = false"
          >Cancel</Button
        >
      </div>
    </Modal>

    <Modal
        v-model="viewImageModal">
        <img :src="modelImage" alt="">
    </Modal>
  </div>
</template>

<script>
import _ from "lodash";

export default {
  data() {
    return {
      viewImageModal: false,
      modelImage: "",
      modal1: false,
      image: false,
      crfObj: {
        "X-CSRF-TOKEN": document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
      },

      imgData: {
        uploadType: "",
      },

      pageIndex: -1,
      fbPagesModal: false,
      user: {},
      imageData: [],
      // allCounts:'',
      isLoading: false,
      pageOption: [5, 10, 15, 20],
      str: "",
      page: 1,
      perPage: 10,

      datacollection: null,
      columns1: [
        {
          title: "id",
          key: "id",
        },

        {
          title: "Image",
          slot: "image",
        },
		{
          title: "Action",
          slot: "action",
          width: 150,
          align: "center",
        },
      ],
      pages: [],
    };
  },

  methods: {
	  
    async imageUpload(imagePath) {
      const res = await this.callApi(
        "post",
        "/images/imageUpload", {image: imagePath}
      );
	//   console.log(res.data)
      if (res.status == 201) {
        console.log(this.imageData);
        // this.imageData.data.unshift(res.data);
        this.imageData.unshift(res.data);
		// this.imageData.concat([res.data]);
		this.image = false;
      }
    },

    viewImage(item){
      this.modelImage = item.image;
      this.viewImageModal = true;
    },

	async remove(row, index) {
      if (confirm("Are you sure you want to DELETE permanently?")) {
        const res = await this.callApi("post", "/images/deleteImageRow", {id:row.id});
        if (res.status == 200) {
          this.imageData.splice(index, 1);
          // this.imageData.data.splice(row._index, 1);
          this.s("Data Deleted.");
        }
      }
    },

    isUploadModal(type) {
      this.imgData.uploadType = type;
      this.isUpload = true;
    },

    handleSuccess(res, file) {
      this.image = res;
      this.modal1 = false;
      this.s("Picture Updated Successfully !");
    },

    handleFormatError(file) {
      this.e("The file format is incorrect");
    },

    handleMaxSize(file) {
      this.e("File  " + file.name + " is too large, not more than 4M.");
    },

    async connectFacebook() {
      const res = await this.callApi("get", `/social/login`);
    //   console.log(res);
    },
    async allImageData() {
      const res = await this.callApi(
        "get",
        "/images/showAllImages"
        // `/images/showAllImages?page=${this.page}&perPage=${this.perPage}&str=${this.str}`
      );
      if (res.status == 200) {
        this.imageData = res.data;
		// console.log(this.imageData)
      }
    },

    async postInstagramForFirstTime() {
      // this.isLoading = true
      // return
      this.isLoading = true;
      const res = await this.callApi(
        "get",
        `/social/postInstagramForFirstTime`
      );
      this.isLoading = false;
      if (res.status == 200) {
        if (!this.$store.state.authUser.is_ins_scheduled) {
          this.$store.state.authUser.is_ins_scheduled = 1;
        }
      }
      console.log(res);
    },

    serchResetlt: _.debounce(function () {
      this.perPage = 10;
      this.paginateDataInfo(1);
    }, 200),

    getSizeChange(e) {
      this.perPage = e;
      this.paginateDataInfo(1);
    },
    async getUser() {
      const res = await this.callApi("get", `/twitter/geTwitterUser`);
      if (res.status == 200) {
        this.user = res.data;
      }
    },
    paginateDataInfo(e) {
      this.page = e;
      this.allImageData();
    },
    async getYourFbPages() {
      this.isLoading = true;
      const res = await this.callApi("get", "/social/getFbPage");
      this.isLoading = false;
      if (res.status == 200) {
        this.pages = res.data;
        this.fbPagesModal = true;
      }
    },
    async connectBussnessId() {
      console.log(this.pageIndex);
      if (this.pageIndex == null || this.pageIndex <= -1) return;

      let ob = this.pages[this.pageIndex];
      const res = await this.callApi("post", "/social/connectBussnessId", ob);
      this.isLoading = false;
      if (res.status == 200) {
        this.$store.state.authUser.bussness_id = 1;
        this.s("You are successfully connected your instagram account!");
        this.fbPagesModal = false;
      }
    },
  },

  async created() {
    this.allImageData();
    this.getUser();
  },
};
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper {
  width: 130%;
}

._table_responsive {
  display: flex;
  flex-wrap: wrap;
}

._table_item {
  padding: 0 10px;
  margin: 10px 0;
  display: flex;
  flex-direction: column;
}
</style>
