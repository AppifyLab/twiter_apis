<template>
    <div>
        <h1 @click="logout">{{test}}</h1>
    </div>
</template>

<script>

export default {
    data(){
        return{
            test: "hello world test",
        }
    },
    methods:{
        async logout(){
            const res = await this.callApi('get','/auth/logout')
            if(res.status==200){
              window.location.reload();
            }
        }
    }
}
</script>
