<template>
    <div class="card mt-2">
        <div class="card-header">Create New Answer</div>

        <div class="card-body">
            <form >
                <div class="form-group">
                    <form @submit.prevent="create">
                         <div class="form-group">
                            <label for="body">Write down Answer description</label>
                            <textarea v-model="body"  name="body" id="body" class="form-control " rows="7"></textarea>
                            <span class="text-danger" v-if="errors">{{errors.body[0]}}</span>

                         </div>

                        <button :disabled="!signedIn" class="btn btn-success">Submit</button>
                        <br>
                        <span v-if="!signedIn" class="text-info"><small>Please Login First then share your answer</small></span>
                    </form>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NewAnswer",
        props:['id'],
        data(){
            return {
                body: null,
                errors: null,
            }
        },
        methods:{
            create(){
                axios.post(this.endpoint,{
                    body:this.body,
                })
                    .then(({data})=>{
                        this.body = '';
                        console.log(data.answer);
                        this.$toast.success(data.message,'success',{timeout:2000});
                        this.$emit('insertAnswer',data.answer)
                    })
                    .catch(({response})=>{
                        this.errors =response.data.errors;
                    })
            }
        },

        computed:{
            endpoint(){
                return `/questions/${this.id}/answers`;
            }
        }
    }

</script>
