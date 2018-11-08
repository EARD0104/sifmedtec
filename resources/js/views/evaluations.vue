<template>

    <div class="">
        <div v-if="show_group_input" class="card">
            <div class="card-body">
                <h1 class="card-title text-center">
                    Sistema Informatico de Medición de Capacidades Tecnologicas
                </h1>
                <h4 class="card-subtitle mb-2 text-muted text-center">
                    Maestros de Educación Primaria y Básica
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
                                        <button  @click="verifyGroup" class="btn btn-primary" type="button" id="button-addon2">Siguiente ></button>
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
                        <button @click="storeTeacher" type="button" class="btn btn-primary btn-block">Siguiente ></button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="show_question" style="min-width: 57em;">
            <div class="progress" style="height: 20px;">
                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
            </div>
            <br>
            <div  class="card">
                <h1 class="card-header">Hardware</h1>
                <div class="card-body">
                    <h2 class="card-title">¿Una super  pregunta?</h2>
                    <div class="form-check">
                        <input v-model="answer" class="form-check-input" type="radio"  value="option1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Default radio
                        </label>
                    </div>
                        <div class="form-check">
                        <input v-model="answer" class="form-check-input" type="radio" value="option2">
                        <label class="form-check-label" for="exampleRadios2">
                            Second default radio
                        </label>
                        </div>
                </div>
                <div class="card-footer text-muted">
                    <a href="#" v-if="answer != ''" class="btn btn-primary btn-block">Siguiente ></a>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Group from '../models/Group';
import Evaluation from '../models/Evaluation';
export default {
    data(){
        return {
            show_group_input: true,
            show_teacher_inputs:false,
            show_question:false,
            create:{},
            errors : [],
            group:{},
            evaluation:{},
            answer:'',
        }
    },
    methods:{
        verifyGroup(){
            Group.show(this.create.group_id, data => {
                this.group               = data.data;
                this.show_group_input    = false;
                this.errors              = [];
                this.show_teacher_inputs = true;
            }, errors => this.errors = errors)
        },
        storeTeacher(){
            Evaluation.store(this.create, data => {
                this.$toastr.s("Datos correctos, ha iniciado el examen.");
                this.evaluation          = data.data;
                this.errors              = [];
                this.show_teacher_inputs = false;
                this.show_question        = true;
            }, errors => this.errors = errors)
        }
    }

}
</script>