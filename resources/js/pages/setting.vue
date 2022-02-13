<template>
  <div>
    <div class="_main_content">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12 _mar_b10">
           
           <div>
               <div>
                <h2>Select Font</h2>
                    <Select v-model="fontAndColor.font" style="width:200px">
                    <Option value="font/Roboto-Black.ttf">Black</Option>
                    <Option value="font/Roboto-BlackItalic.ttf">BlackItalic</Option>
                    <Option value="font/Roboto-BoldItalic.ttf">BoldItalic</Option>
                    <Option value="font/Roboto-Italic.ttf">Italic</Option>
                    <Option value="font/Roboto-Light.ttf">Light</Option>
                    <Option value="font/Roboto-LightItalic.ttf">LightItalic</Option>
                    <Option value="font/Roboto-Medium.ttf">Medium</Option>
                    <Option value="font/Roboto-Regular.ttf">Regular</Option>
                    <Option value="font/Roboto-Thin.ttf">Thin</Option>
                    <Option value="font/Roboto-ThinItalic.ttf">ThinItalic</Option>
                </Select>
               </div>
               <div>
                <h2>Pick Color</h2>
                    <template>
                        <ColorPicker v-model="fontAndColor.color" format="rgb" />
                    </template>
               </div>

               <Button @click="addFontAndColor" v-if="fontAndColor.font != '' && fontAndColor.color != '' " type="success">Add Font And Color</Button>
           </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
          <div class="_box _b_radious3 _padd20">
            
            <div class="_table_responsive">
              <Table
                class=""
                border
                :columns="columns1"
                :data="imageData"
              >
                <template slot-scope="{ row }" slot="font">
                  <p> {{row.font.replace('font/','').replace('.ttf','')}} </p>
                </template>
                <template slot-scope="{ row }" slot="color">
                  <ColorPicker v-model="row.color" format="rgb" :disabled="true" />
                </template>
              </Table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from "lodash";

export default {
  data() {
    return {
        fontAndColor: {
            color: "",
            font: ""
        },
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
          title: "Font",
          // key: "font"
          slot: "font"
        },
        {
          title: "Color",
          slot: "color",
        },
      ],
      pages: [],
    };
  },

  methods: {
	  
    async addFontAndColor() {
      const res = await this.callApi(
        "post",
        "/fontandcolor/addFontAndColor", this.fontAndColor
      );
      if (res.status == 200 || res.status == 201) {
        // console.log(res.data);
        this.imageData = [res.data];
        this.fontAndColor.color = "";
        this.fontAndColor.font = "";
      }
    },

    async viewFontAndColor() {
      const res = await this.callApi(
        "get",
        "/fontandcolor/viewFontAndColor"
      );
      if (res.status == 200) {
        this.imageData = res.data;
      }
    },

  },

  async created() {
    this.viewFontAndColor();
  },
};
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper {
  width: 130%;
}
</style>
