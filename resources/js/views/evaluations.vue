<template>

    <div class="">
        <div v-if="show_group_input" class="card">
            <div class="card-body">
                <h1 class="card-title text-center">
                    Sistema Informatico de Medición de Capacidades Tecnologicas
                </h1>
                <h4 class="card-subtitle mb-2 text-muted text-center">
                    Maestros de Educación Primaria, Básica y Diversificada
                </h4>
                <div class="col-md-12 offset-md-4">
                    <div>
                        <div class="form-row align-items-center">
                            <div class="col-md-4 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend3">Grupo</span>
                                    </div>
                                    <input type="text" class="form-control" v-model="create.group_id" :class="{'is-invalid':errors.group_id }" id="validationServerUsername" placeholder="Codigo" >
                                    <div class="input-group-append">
                                        <button  @click="validateGroup" class="btn btn-primary" type="button" id="button-addon2">Siguiente ></button>
                                    </div>
                                    <div v-if="errors.group_id"  class="invalid-feedback">
                                        {{ errors.group_id[0]}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="show_teacher_inputs" class="card">
            <div class="card-body">
                 <h1 class="card-title text-center">
                   Ingrese sus datos personales
                </h1>
                <div class="">
                    <div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre Completo</label>
                            <input v-model="create.teacher_name" type="text" class="form-control">
                            <small v-if="errors.teacher_name"  class="form-text text-danger">{{ errors.teacher_name[0]}}</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">DPI</label>
                            <input v-model="create.teacher_dpi" type="text" class="form-control">
                            <small v-if="errors.teacher_dpi"  class="form-text text-danger">{{ errors.teacher_dpi[0]}}</small>
                        </div>
                        <button @click="validateTeacher" type="button" class="btn btn-primary btn-block">Siguiente ></button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="show_questions" style="min-width: 57em;">
            <div v-if="show_result" class="col-md-6 offset-md-3">
            <h1 class="display-4">{{ create.teacher_name }}</h1>
                <table class="table">
                    <thead>
                        <tr class="table-light">
                            <th>Grupo</th>
                            <th colspan="2">{{ group.id}}</th>
                        </tr>
                        <tr class="table-light">
                            <th>Escuela</th>
                            <th colspan="2">{{ group.school.name}}</th>
                        </tr>
                        <tr>
                            <th>Respuestas correctas</th>
                            <th>{{ correct_answers }}</th>
                            <th>
                                <div class="progress-bar" role="progressbar" :style="'width:'+correct_answers_percent+'%;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{correct_answers_percent}}%</div>
                            </th>
                        </tr>
                        <tr>
                            <th>Respuestas erroneas</th>
                            <th>{{ incorrect_answers }}</th>
                            <th>
                                <div class="progress-bar bg-danger" role="progressbar" :style="'width:'+incorrect_answers_percent+'%;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{incorrect_answers_percent}}%</div>
                            </th>
                        </tr>
                        <tr>
                            <th style="width:200px !important ">Total de Preguntas</th>
                            <th style="width:10px !important">{{ total_answers }}</th>
                            <th>
                                <div class="progress-bar" :class="{ 'bg-success': answers_proggress == 100 }" role="progressbar" :style="'width:'+answers_proggress+'%;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{answers_proggress}}%</div>
                            </th>
                        </tr>
                    </thead>
                </table>
                <p class="lead">
                    Agradecemos tu tiempo, el director del establecimiento, o el encargado de la evalución del grupo estará dándo a conocer el plan de capacitación para mejorar los resultados de la presente
                </p>

            </div>

            <div class="progress" style="height: 20px;" v-if="!show_result">
                <div class="progress-bar" :class="{ 'bg-success': answers_proggress == 100 }" role="progressbar" :style="'width:'+answers_proggress+'%;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{answers_proggress}}%</div>
            </div>
            <br>
            <div  class="card" v-if="show_question">
                <h1 class="card-header">{{ areas[current_area].name }}</h1>
                <div class="card-body">
                    <h2 class="card-title">{{ areas[current_area].questions[current_question].name}}</h2>
                    <div class="form-check" v-for="answer in areas[current_area].questions[current_question].answers_to_evaluate" :key="answer.id">
                        <input v-model="answered" class="form-check-input" name="answers" type="radio"  :value="answer">
                        <label class="form-check-label">
                            {{ answer.name }}
                        </label>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <button @click="next" type="button" class="btn btn-primary btn-block">Siguiente ></button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Group from '../models/Group';
import Evaluation from '../models/Evaluation';
import EvaluationQuestion from '../models/EvaluationQuestion';
export default {
    data(){
        return {
            show_group_input: true,
            show_teacher_inputs:false,
            show_questions:false,
            show_question:false,
            show_result:false,
            create:{},
            errors : [],
            group:{},
            evaluation:{},
            answers:[],
            areas:[],
            preferences:{},
            current_question:0,
            current_area:0,
            correct:0,
            answereds :0,
            answered :{},
            correct_answers:0,
            correct_answers_percent:0,
            incorrect_answers:0,
            incorrect_answers_percent:0,
        }
    },
    computed:{
        total_answers(){
            if (this.preferences) {
                return this.areas.length * this.preferences.answers_question;
            }

            return 0;
        },

        answers_proggress(){
            return (this.answereds /this.total_answers)  * 100 ;
        }
    },
    created(){
        this.loadAreaQuestions();
    },
    methods:{
        //validamos si el grupo existe o esta activo
        validateGroup(){
            Group.show(this.create.group_id, data => {
                this.group               = data.data;
                this.show_group_input    = false;
                this.errors              = [];
                this.show_teacher_inputs = true;
            }, errors => this.errors = errors)
        },
        //validamos si el profesor ya se ha realizado una evalución en este grupo
        validateTeacher(){
            Evaluation.get(this.create, data => {
                this.$toastr.s("Datos correctos, ha iniciado el examen.");
                this.preferences         = data.data;
                this.errors              = [];
                this.show_teacher_inputs = false;
                this.show_questions      = true;
                this.show_question       = true;
            }, errors => this.errors = errors)
        },
        //cargamos el listado de preguntas y respuestas y las agrupamos por areas
        loadAreaQuestions(){
            EvaluationQuestion.get({}, data => {
                this.areas = data.data
            });
        },
        //opcion de ir a la siguiente pregunta
        next(){
            //actualizamos el total de preguntas respondidas
            this.answereds         = this.answereds + 1;

            //al dar clic en siguiente automaticamente guardamos la respuesta en un array
            this.setAnswer();

            //verificamos si el número de la pregunta es igual al total del array de preguntas
            //y si esta area ya finalizo sus preguntas
            if (this.current_question == (this.preferences.answers_question - 1 ) &&  this.current_area  != this.areas.length - 1 ) {
                //si ya finalizo
                if (this.current_area != this.areas.length - 1) {
                    //nos pasamos a la siguiente area cambiando el index del array de areas
                    this.current_area     = this.current_area + 1 ;
                    //retornamos a 0 el index del array de preguntas
                    this.current_question = 0 ;
                }
            }
            //si todavia tenemos preguntas pendientes solo cambiamos el index de la siguiete pregunta
            else if (this.current_question != (this.preferences.answers_question - 1 )) {
                this.current_question = this.current_question +1 ;
            }
            // si ya se acabaron las areas y las preguntas cerramos el formulario de preguntas y mostramos los resultados
            else{
                this.show_question = false;
                this.show_result   = true;
            }

        },
        //agregamos una respuesta a una area en especifico
        setAnswer(){
            this.areas[this.current_area].answers.push(this.answered);
        },
        //realizamos los calculos de los resultados
        results(){
            let corrects = 0

            //obtenemos el porcentaje de la evaluación
            _.forEach(this.areas, function(area) {
                _.forEach(area.answers, function(answer) {
                    answer.is_the_answer == 1 ? corrects++: null ;
                });
            });

            this.correct_answers = corrects;
            this.correct_answers_percent = (corrects /this.total_answers)  * 100;

            this.incorrect_answers = this.total_answers - corrects;
            this.incorrect_answers_percent = (this.incorrect_answers /this.total_answers)  * 100;
        },

        //guardamos la evaluacion y terminamos
        storeEvaluation(){

            this.create.areas = this.areas;
            Evaluation.store(this.create, data => {
                this.$toastr.s("Evaluación finalizada con exito.");
                this.results();
            }, errors => this.errors = errors)
        }
    },

    watch:{
        //Este observador esta verificando si podemos mostrar los resultados y si es asi
        //mostramos el mensaje  de exito y los resultados en tabla
        show_result(){
            if (this.show_result) {
                this.storeEvaluation();
            }
        }
    }

}
</script>