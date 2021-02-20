<template>
<div class="row py-3 border-bottom">
    <div class="col-md-1">
        <vote :model="answer" name="answer"></vote>
    </div>
    <div class="col-md-11">
        <div v-if="!editing">
            <p v-html="bodyHtml"></p>
            <div class="">
                <div class="btn-group">
                    <button v-if="authorize('modify',answer)"  @click.prevent="edit" class="btn-sm btn-success mr-1">
                        <a class="text-decoration-none text-white" href="">Edit</a>
                    </button>
                    <button v-if="authorize('modify',answer)" @click.prevent="destroy" class="btn-sm btn-danger">Delete</button>
                </div>
            </div>
        </div>
        <div v-else>
            <form @submit.prevent="update">
                <div class="form-group">
                    <textarea v-model="bodyHtml" name="body" id="body" class="form-control" rows="7"></textarea>
                </div>
                <button :disabled="isInvalid" class="btn-sm btn-success">Submit</button>
                <button type="button" @click.prevent="cancel" class="btn-sm btn-danger">Cancel</button>
            </form>
        </div>

        <user-info :model="answer"></user-info>
    </div>

    <hr>
</div>
</template>

<script>
    import Vote from "./Vote";
    import UserInfo from "./UserInfo";
    export default {
        components:{UserInfo, Vote},
        name: "Answer",
        props:['answer'],

        data(){
            return{
                bodyHtml : this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                editing: false,
                beforeEditCache: null,
            }
        },
        methods:{
            edit(){
                this.beforeEditCache = this.bodyHtml;
                this.editing = true;
            },
            cancel(){
                this.bodyHtml = this.beforeEditCache;
                this.editing = false;
            },
            update(){
                axios.patch(this.endpoint,{
                    body: this.bodyHtml
                })
                    .then(response=>{
                        this.bodyHtml = response.data.body;
                        this.editing = false;
                        this.$toast.success(response.data.message,'Success:',{timeout:3000,position: 'bottomLeft'})
                    })
                    .catch(err=>{
                        console.log(err)
                    })
            },
            destroy(){

                this.$toast.question('Are You Sure Want to Delete this','Confirm',{
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Hey',
                    message: 'Are you sure about that?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>',  (instance, toast)=> {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                            axios.delete(this.endpoint)
                                .then(response=>{
                                    this.$emit('deleted');
                                })
                                .catch(error=>{
                                    console.log(error)
                                })

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }],
                    ],
                    onClosing: function(instance, toast, closedBy){
                        console.info('Closing | closedBy: ' + closedBy);
                    },
                    onClosed: function(instance, toast, closedBy){
                        console.info('Closed | closedBy: ' + closedBy);
                    }
                });

            }
        },

        computed:{
            endpoint(){
                return `/questions/${this.questionId}/answers/${this.id} `
            },

            isInvalid(){
                return this.bodyHtml.length <15
            }
        }
    }
</script>

<style scoped>

</style>
