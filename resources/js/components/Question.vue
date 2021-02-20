<template>
    <div class="card">
        <div class="card-header d-flex">
            <h3>{{title}}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-1">
                    <vote :model="question" name="question"></vote>
                </div>
                <div class="col-md-11">
                    <div v-if="!editing" class="">
                        <h3><a href=""></a></h3>
                        <p v-html="bodyHtml"></p>

                        <div class="btn-group" v-if="authorize('modify',question) && signedIn">
                            <button @click.prenvent="edit" class="btn-sm btn-success">Edit</button>
                            <button @click.prenvent="destroy"  class="btn-sm btn-danger ml-1">Delete</button>
                        </div>
                    </div>

                    <div v-else>
                        <form @submit.prevent="update">
                            <input type="text" name="title" v-model="title" class="form-control">
                            <hr>
                            <textarea  v-model="bodyHtml" class="form-control" name="body" id="" rows="10"></textarea>
                            <div class="btn-group mt-2">
                                <button  class="btn-sm btn-success">Submit</button>
                                <button @click.prenvent="cancel" type="button" class="btn-sm btn-danger ml-1">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <user-info :model="question"></user-info>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import UserInfo from "./UserInfo";
    import Vote from "./Vote";
    import eventBus from "../event_bus";
    export default {
        components: {Vote, UserInfo},
        comments:{UserInfo},
        name: "Question",
        props:['question','model'],
        data(){
            return{
                title: this.question.title,
                bodyHtml: this.question.body_html,
                editing: false,
                beforeEditCache: null,
                id: this.question.id,
            }
        },

        methods:{
            edit(){
                this.editing = true;
                this.beforeEditCache = {
                    title:this.title,
                    bodyHtml:this.bodyHtml,
                }
            },
            cancel(){
                this.editing = false;
                this.bodyHtml =  this.beforeEditCache.bodyHtml;
                this.title =  this.beforeEditCache.title;
            },
            update(){
                axios.patch(this.endpoint,{
                    body: this.bodyHtml,
                    title: this.title,
                })
                    .then(response=>{

                        this.editing = false;
                        this.$toast.success(response.data.message,'Success:',{timeout:3000,position: 'bottomLeft'})
                    })
                    .catch(error=>{
                        alert(error.response.data.errors.body[0]);
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
                                    setInterval(()=>{
                                        window.location.href = '/questions'
                                    },2000)
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
                return `/questions/${this.id}/`;
            }
        }
    }
</script>

<style scoped>

</style>
