<template>
  <div id="app">
    <div :class="darkMode? 'darkMode' : ''" id="main-wrapper">
      <!-- Menu -->
      <nav v-if="$route.path != '/login' && $route.path != '/register' && $route.path != '/resetPassword' && $route.path != '/forgetPassword'" :class="sidebar? '_navbar _fixed_top _navbar_light _navbar_wap _mini_navbar' : '_navbar _fixed_top _navbar_light _navbar_wap'">
        <div class="_navbar_left">
          <div class="_navbar_logo">
            <a href="/" class="_navbar_logo_link">
              <h1>AppifyLab</h1>
            </a>
          </div>

          <div class="_navbar_left_button">
            <div @click="sidebar = !sidebar" class="_navbar_left_icon">
              <Icon type="md-list" />
            </div>

            <div @click="mobSidebar = !mobSidebar" class="_navbar_left_icon _mob_icon">
              <Icon type="md-list" />
            </div>
          </div>

          
        </div>

        <div class="_navbar_right">
          <ul class="_navbar_right_list">
            <li class="_mosearch" @click="mobSearchOpen = true"><Icon type="ios-search-outline" /></li>

            <li class="_nav_pro">
              <Dropdown trigger="click" placement="bottom-end">
                <a href="javascript:void(0)">
                  <div class="_nav_pro_pic">
                    <img class="_nav_pro_img" :src="authInfo.profile_pic ? authInfo.profile_pic : '/img/avater.png'" alt="" title="">
                    <!-- <img class="_nav_pro_img" src="/img/avater.png" alt="" title=""> -->
                  </div>
                </a>
                <DropdownMenu slot="list">
                  <div class="_nav_pro_main">
                    <div class="_nav_pro_top">
                      <div class="_nav_pro_top_pic">
                        <img class="_nav_pro_top_img" src="/img/avater.png" title="" alt="">
                      </div>

                      <div class="_nav_pro_top_details">
                        <p class="_nav_pro_top_name">{{authInfo.username}}</p>
                        <p class="_nav_pro_top_email">{{authInfo.email}}</p>
                      </div>
                    </div>

                    <div class="_nav_pro_list_main _1border_color">
                      <ul class="_nav_pro_list">
                        <li>
                          <router-link to="/profile">
                            <Icon type="md-person" />
                            <p class="_nav_pro_list_text">My Profile</p>
                          </router-link>
                        </li>
                      </ul>
                    </div>
                    <div class="_nav_pro_list_main _1border_color">
                      <ul class="_nav_pro_list">
                        <li>
                          <a @click="logout" href="javascript:void(0)">
                            <Icon type="ios-exit" />
                            <p class="_nav_pro_list_text">Log out</p>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </DropdownMenu>
              </Dropdown>
            </li>
          </ul>
        </div>

        <!-- Mobile Search -->
        <div class="_mob_search"  :class="mobSearchOpen? '_mob_search_open' : ''">
          <div class="_mob_search_main">
            <div class="_navbar_search_main_all">
              <div class="_navbar_search_main">
                <Icon type="ios-search-outline" />
                <input type="text"  placeholder="Search..">
                <div class="outline"></div>
              </div>
            </div>
          </div>
          <div class="_mob_search_close"><Icon @click="mobSearchOpen = false" type="md-close" /></div>
        </div>
        <!-- Mobile Search -->
      </nav>
      <!-- Menu end -->

      <!-- Sidebar  -->
      <aside v-if="$route.path != '/login' && $route.path != '/register' && $route.path != '/resetPassword' && $route.path != '/forgetPassword'" :class="[(sidebar? '_left_sidebar _hide_sidebar':'_left_sidebar') , (lightSidebar? '_light_sidebar' : ''), (darkSidebar? '_dark_sidebar' : ''), (mobSidebar? '_mobSidebarOpen':'')]">
        <div class="_left_sidebar_main">


          <div class="_left_sidebar_menu _1scrollbar">
            <Menu :theme="theme3" :active-name="activeRoute">
              <MenuGroup>
                <MenuItem to="/twitter_users" name="twitter_users">
                    <Icon type="ios-apps" />
                    <span class="submenu_text">Twitter Users</span>
                </MenuItem>
                <MenuItem to="/twitter" name="twitter">
                    <Icon type="ios-apps" />
                    <span class="submenu_text">Twitter posts</span>
                </MenuItem>
                <MenuItem to="/images" name="images">
                    <Icon type="ios-apps" />
                    <span class="submenu_text">Images</span>
                </MenuItem>
                <MenuItem to="/setting" name="setting">
                    <Icon type="ios-apps" />
                    <span class="submenu_text">Setting</span>
                </MenuItem>
             
              </MenuGroup>

            </Menu>
          </div>
        </div>
      </aside>
      <!-- Sidebar -->

      <div :class="[(sidebar? '_main_layout _mini_main_layout':'_main_layout') , ($route.path  != '/login' && $route.path  != '/register' && $route.path  != '/resetPassword' && $route.path  != '/forgetPassword'? '':'_login_layout')]">
        <router-view></router-view>

      </div>
      
    </div>
  </div>
</template>

<script>
export default {
 

  data(){
    return{
      activeRoute:'index',
      sidebar:false,
      isHovering: false,
      theme3: 'light',
      lightSidebar: true,
      darkSidebar: false,
      darkMode: false,
      mobSearchOpen: false,
      mobSidebar: false,
      spinLoading: false
    }
  },

  methods:{
     async logout(){
         const res = await this.callApi('get','/auth/logout')
         if(res.status==200){
           window.location.reload();
         }
     },

    lightSidebarClick(){
      this.lightSidebar = true
      this.darkSidebar = false
      this.darkMode = false
    },

    darkModeClick(){
      this.darkSidebar = true
      this.lightSidebar = false
      this.darkMode = true
    }
  },
  watch: {
    "$route.name": function (newVal, oldVal) {
       this.activeRoute = newVal;

      },
    },
  created(){
      this.activeRoute = this.$route.name;
  }
}
</script>

<style scoped>
.demo-spin-icon-load{
    animation: ani-demo-spin 1s linear infinite;
}
@keyframes ani-demo-spin {
    from { transform: rotate(0deg);}
    50%  { transform: rotate(180deg);}
    to   { transform: rotate(360deg);}
}
.demo-spin-col{
    height: 200px;
    position: relative;
    /* border: 1px solid #eee; */
}
</style>
