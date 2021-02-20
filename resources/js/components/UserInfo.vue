<template>
    <div class="float-lg-right" >
        <small>Label At</small>
        <small><b>{{createdDate}}</b></small>
        <br>
        <img style="width: 40px" :src="avatar" alt="">
        <b>{{userName}}</b>
    </div>
</template>

<script>
    export default {
        name: "UserInfo",
        props:['model'],
        data(){
            return{
                createdDate: this.model.created_date,
                avatar: this.model.user.avatar,
                userName: this.model.user.name,
            }
        }
    }
</script>

<style scoped>

</style>
