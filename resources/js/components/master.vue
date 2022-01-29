<template>
    <span>
         <login v-if="!authInfo"></login>
         <app v-if="authInfo"></app>
    </span>
</template>

<script>
import login from './login.vue';
import app from './app.vue'
export default {
    components: { login, app},

    data(){
        return{
            test: "hello world",
        }
    },
    created(){
        this.$store.commit('setAuthuser', window.authUser);
    }
}
</script>
