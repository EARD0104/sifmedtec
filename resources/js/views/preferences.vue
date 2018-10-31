<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Preferencias
                        </h5>
                    </div>
                    <div class="card-body">

                        <form>
                            <div class="form-group row">
                                <label for="" class="col-sm-10 col-form-label">Número de preguntas por área</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="" v-model="preference.question_area">
                                    <small  v-if="errors.question_area" class="form-text text-danger">{{ errors.question_area[0]}}</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-10 col-form-label">Número maximo de opciones de respuestas por pregunta</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="" v-model="preference.answers_question">
                                    <small  v-if="errors.answers_question" class="form-text text-danger">{{ errors.answers_question[0]}}</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-10 col-form-label">Número de temas en plan de capacitación por área 1% a 25%</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="" v-model="preference.number_capacitation_plan_1">
                                    <small  v-if="errors.number_capacitation_plan_1" class="form-text text-danger">{{ errors.number_capacitation_plan_1[0]}}</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-10 col-form-label">Número de temas en plan de capacitación por área 26% a 59%</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="" v-model="preference.number_capacitation_plan_2">
                                    <small  v-if="errors.number_capacitation_plan_2" class="form-text text-danger">{{ errors.number_capacitation_plan_2[0]}}</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-10 col-form-label">Número de temas en plan de capacitación por área 60% a 85%</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="" v-model="preference.number_capacitation_plan_3">
                                    <small  v-if="errors.number_capacitation_plan_3" class="form-text text-danger">{{ errors.number_capacitation_plan_3[0]}}</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-10 col-form-label">Número de temas en plan de capacitación por área 86% a 100%</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="" v-model="preference.number_capacitation_plan_4">
                                    <small  v-if="errors.number_capacitation_plan_4" class="form-text text-danger">{{ errors.number_capacitation_plan_4[0]}}</small>
                                </div>
                            </div>
                            <button @click="update" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Preference from '../models/Preference';
    export default{
        data(){
            return {
                preference:[],
                errors:[],
            }
        },
        created(){
            this.show();
        },
        methods:{
            show() {
                Preference.show(1, data => {
                    this.preference = data.data;
                });
            },

            update(){
                Preference.update(1, this.preference, data => {
                    this.$toastr.s("Editado exitosamente.");
                    this.show();
                    this.errors = [];
                }, errors => this.errors = errors);
            },
        }
    }
</script>

<style lang="scss">
    .tooltip {
        &[aria-hidden='true'] {
            visibility: hidden;
            opacity: 0;
            transition: opacity .15s, visibility .15s;
        }

        &[aria-hidden='false'] {
            visibility: visible;
            opacity: 1;
            transition: opacity .15s;
        }

        /*Your styles.*/

        display: block !important;
        z-index: 10000;
    }

</style>

<style lang="scss" scoped>
    .tooltip {
  // ...

  &.popover {
    $color: #f9f9f9;

    .popover-inner {
      background: $color;
      color: black;
      padding: 24px;
      border-radius: 5px;
      box-shadow: 0 5px 30px rgba(black, .1);
    }

    .popover-arrow {
      border-color: $color;
    }
  }
}
.tooltip-arrow {
  z-index: 1;
}
</style>