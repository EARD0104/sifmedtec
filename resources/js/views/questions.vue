<template>
    <div>
        <questions-list v-if="showQuestions" @show="show"></questions-list>
        <answers-list v-if="showAnswers" :question_id="question_id" @end="end" ></answers-list>
    </div>
</template>
<script>
    import QuestionsList from './questionsList';
    import AnswersList from './answersList';
    export default{
        components:{QuestionsList, AnswersList},
        data(){
            return {
                showQuestions:true,
                showAnswers:false,
                question_id:''
            }
        },
        methods:{
            show(question_id){
                this.showQuestions = false;
                this.showAnswers = true;
                this.question_id = question_id;
            },
            end(){
                this.showQuestions = true;
                this.showAnswers = false;
            }
        }
    }
</script>
