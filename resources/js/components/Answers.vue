<template>
    <div class="card mt-2">
        <div class="card-body">
            <h3 class=" py-1"><b>{{counts }} </b>{{ answerCount}}</h3>
            <hr>

            <div  class="row"  >
                <div class="col-md-12">
                    <answer @deleted="remove(index)" v-for="(answer,index) in answers" :key="answer.id" :answer="answer"></answer>
                </div>
            </div>
        </div>

        <div class="mb-3 text-center">
            <button class="btn-sm btn-outline-info bg-info text-white" v-if="nextUrl" @click.prevent="fetch(nextUrl)">Show More Answers</button>
        </div>

        <new-answer @insertAnswer="newAnswer" :id="question"></new-answer>

    </div>

</template>

<script>
    import NewAnswer from "./NewAnswer";
    import Answer from "./Answer";
    export default {
        name: "Answers",
        components: {NewAnswer,Answer},
        props:['answercounts','question'],
        data(){
            return{
                answers: [],
                nextUrl: null,
                counts: this.answercounts,
            }
        },
        computed:{
            answerCount(){
                return this.counts > 0 ? 'Answers' : 'Answer';
            }
        },

        methods:{
            fetch(endpoint){
                axios.get(endpoint)
                    .then(({data})=>{

                        this.answers.push(...data.data);
                        this.nextUrl = data.next_page_url;
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            },

            remove(index){
                this.answers.splice(index,1);
                this.counts--;
            },

            newAnswer(answer){
                this.answers.push(answer);
                this.counts++
            }
        },

        created(){
            this.fetch(`/questions/${this.question}/answers`);
        }
    }
</script>

<style scoped>

</style>
