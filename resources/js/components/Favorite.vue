<template>
    <div>
        <a :class="classes" @click.prevent="favorite"  href="">
            <i class="fas fa-star fa-2x"></i>
        </a>
    </div>
</template>

<script>
    export default {
        name: "Favorite",
        props: ['model'],
        data(){
            return {
                id: this.model.id,
                isFavourite: this.model.is_favourite,
            }
        },
        computed:{
            classes()
            {
                return [!this.signedIn ? '' : this.isFavourite ? 'favourite' : ''];
            },
        },

        methods:{
            favorite(){
                console.log(this.isFavourite);
                axios.post(`/questions/${this.id}/favourite`)
                    .then(response=>[
                        this.isFavourite = !this.isFavourite ,
                        console.log(response.data.message)
                    ])
                    .catch(error=>{
                        console.log(error)
                    })
            }
        }
    }
</script>

<style scoped>

</style>
