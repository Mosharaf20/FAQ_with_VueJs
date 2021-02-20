<template>
    <div>
        <a @click.prevent="accepted" v-if="canAccept" title="Choose the Best Answer for this Question" :class="classes" href="" >
            <i class="fas fa-check fa-2x"></i>
        </a>
        <div v-else>
            <a v-if="isBest" @click.prevent title="Choose the Best Answer for this Question" :class="classes" href="" >
                <i class="fas fa-check fa-2x"></i>
            </a>
        </div>

    </div>
</template>

<script>
    import eventBus from "../event_bus";
    export default {
        name: "Accept",
        props:['model'],
        data(){
            return{
                id: this.model.id,
                isBest: this.model.best_answer
            }
        },
        methods:{
            accepted(){
                axios.post(`/answers/accept/${this.id}`)
                    .then(response=>{
                        eventBus.$emit('chooseBest',this.id);
                        this.$toast.success(response.data.message,'success',{timeout:3000})
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            }
        },

        created(){
          eventBus.$on('chooseBest',id=>{
             this.isBest = (id===this.id)
          });
        },
        computed:{
            canAccept(){
                return this.signedIn && this.authorize('accept',this.model)
            },

            classes(){
                return [this.isBest ? 'accepted' : '']
            }
        }
    }
</script>

<style scoped>

</style>
