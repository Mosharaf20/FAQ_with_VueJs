<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <question @deleteQuestion="removeQuestion" :question="question"></question>

                <answers :question="id" :answerCounts="answer_counts"></answers>
            </div>
        </div>
    </div>
</template>

<script>
    import Answers from "./Answers";
    import Question from "./Question";
    export default {
        components:{
            Answers,Question
        },
        name: "Questions",
        props:['question'],
        data(){
            return{
                id: this.question.id,
                answer_counts: this.question.answer_counts
            }
        },
        methods:{
            removeQuestion(){

            }
        }
    }
</script>

<style scoped>

</style>
