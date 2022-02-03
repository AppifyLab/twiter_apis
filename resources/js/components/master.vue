<template>
    <span>
         <register v-if="!authInfo && $route.name=='register'"></register>
         <login v-if="!authInfo && $route.name!='register'"></login>
         <app v-if="authInfo"></app>
        
         
    </span>
</template>

<script>
// import login from './components/auth/login.vue';
import login from './auth/login.vue'
import app from './app.vue'
import register from './auth/register'
export default {
    components: { login, app,register},

    data(){
        return{
            test: "hello world",
            tab:1
        }
    },
    created(){
        this.$store.commit('setAuthuser', window.authUser);
        if(this.$route.query && this.$route.query.tab){
           this.tab = this.$route.query.tab 
        }
        
    }
}
</script>
