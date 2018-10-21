<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ question.name}}
                            <button type="button" @click="showAddModal = true" v-tooltip="'Agregar respuesta'" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i></button>
                        </h5>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Respuesta</td>
                                    <td class="text-center">¿Verdadera?</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="answer in answers" :key="answer.id">
                                    <td>{{ answer.id}}</td>
                                    <td>{{ answer.name}}</td>
                                    <td class="text-center">
                                        <i v-if="answer.is_the_answer == 1" class="fa fa-check text-success"></i>
                                    </td>
                                    <td>
                                        <button @click="edit(answer)" v-tooltip="'Editar'" type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                        <button @click="del(answer)" v-tooltip="'Eliminar'"  type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <paginator :pagination="pagination" @changePage="index"></paginator>
                    </div>
                </div>
            </div>
        </div>
        <modal v-show="showAddModal"  title="Formulario de creación de respuestas"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="create_name">Respuesta</label>
                    <input type="text" class="form-control" id="create_name" v-model="create.name">
                    <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" v-model="create.is_the_answer" class="form-check-input" id="is_the_answer">
                    <label class="form-check-label" for="is_the_answer">Marcar como verdadera</label>
                </div>

            </form>
            <button @click="showAddModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="store" slot="btnSave" type="button"  class="btn btn-primary">Guardar</button>
        </modal>

        <modal v-show="showEditModal"  title="Formulario de edición de respuestas"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="edit_name">Respuesta</label>
                    <input type="text" class="form-control" id="edit_name" v-model="current.name">
                    <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" v-model="current.is_the_answer" class="form-check-input" id="is_the_answer">
                    <label class="form-check-label" for="is_the_answer">Marcar como verdadera</label>
                </div>

            </form>
            <button @click="showEditModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="update" slot="btnSave" type="button"  class="btn btn-primary">Guardar Cambios</button>
        </modal>
        <modal v-show="showDestroyModal"  title="¿Estas seguro de eliminar esta respuestas?"  size="modal-md">
            <button @click="showDestroyModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="destroy" slot="btnSave" type="button"  class="btn btn-danger">Si, Eliminar</button>
        </modal>
    </div>
</template>
<script>
    import Question from '../models/Question';
    import Answer from '../models/Answer';
    import Area from '../models/Area';
    import Paginator from '../components/Paginator.vue';
    import vSelect from 'vue-select';

    export default{
        components: {Paginator, vSelect},
        props:['question_id'],
        data(){
            return {
                showAddModal:false,
                showEditModal:false,
                showDestroyModal:false,
                errors:[],
                create:{},
                current:{},
                filter:{},
                pagination:[],
                question:{},
                answers:[],
            }
        },
        created(){
            this.loadData();
            this.index();
        },
        methods:{
            loadData(){
                Area.get({}, data => {this.areas = data.data});
            },
            index(page = 1) {
                let params = {
                    page: page,
                    name: this.filter.name,
                    question_id: this.question_id
                };

                Question.show(this.question_id, data => {
                    this.question = data.data;
                });

                Answer.get(params , data => {
                    this.answers = data.data;
                    this.pagination = data.meta;
                });
            },
            store(){
                this.create.question_id = this.question_id;

                Answer.store(this.create, data => {
                    this.$toastr.s("Agregado exitosamente.");
                    this.index();
                    this.create = {};
                    this.errors = [];
                    this.showAddModal = false;
                }, errors => this.errors = errors);
            },
            edit(answer){
                this.current = answer;
                this.showEditModal = true
            },
            update(){
                this.current.question_id = this.question_id;
                Answer.update(this.current.id, this.current, data => {
                    this.$toastr.s("Editado exitosamente.");
                    this.index();
                    this.current = {};
                    this.errors = [];
                    this.showEditModal = false;
                }, errors => this.errors = errors);
            },
            del(answer){
                this.current = answer;
                this.showDestroyModal = true
            },
            destroy() {
                Answer.destroy(this.current.id, data => {
                    this.$toastr.s("Eliminado exitosamente.");
                    this.index();
                    this.current = {};
                    this.showDestroyModal = false;
                });
            },
            clear(){
                this.filter = {};
                this.index();
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