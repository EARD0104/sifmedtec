<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Preguntas
                            <button type="button" @click="showAddModal = true" v-tooltip="'Agregar'" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i></button>
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="input-group mb-12">
                            <input type="text" v-model="filter.name" class="form-control" placeholder="buscar" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button @click="index" class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Nombre</td>
                                    <td>Respuestas</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="question in questions" :key="question.id">
                                    <td>{{ question.id}}</td>
                                    <td>{{ question.name}}</td>
                                    <td></td>
                                    <td>
                                        <button @click="show(question.id)" v-tooltip="'Detalles'" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>
                                        <button @click="edit(question)" v-tooltip="'Editar'" type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                        <button @click="del(question)" v-tooltip="'Eliminar'"  type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <paginator :pagination="pagination" @changePage="index"></paginator>
                    </div>
                </div>
            </div>
        </div>
        <modal v-show="showAddModal"  title="Formulario de creación de preguntas"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="create_name">Área</label>
                    <v-select label="name" :options="areas" v-model="create.area"></v-select>
                    <small  v-if="errors.area_id" class="form-text text-danger">{{ errors.area_id[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="create_name">Pregunta</label>
                    <input type="text" class="form-control" id="create_name" v-model="create.name">
                    <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                </div>

            </form>
            <button @click="showAddModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="store" slot="btnSave" type="button"  class="btn btn-primary">Guardar</button>
        </modal>

        <modal v-show="showEditModal"  title="Formulario de edición de preguntas"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="current_name">Área</label>
                    <v-select label="name" :options="areas" v-model="current.area"></v-select>
                    <small  v-if="errors.area_id" class="form-text text-danger">{{ errors.area_id[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="edit_name">Pregunta</label>
                    <input type="text" class="form-control" id="edit_name" v-model="current.name">
                    <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                </div>
            </form>
            <button @click="showEditModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="update" slot="btnSave" type="button"  class="btn btn-primary">Guardar Cambios</button>
        </modal>
        <modal v-show="showDestroyModal"  title="¿Estas seguro de eliminar esta preguntas?"  size="modal-md">
            <button @click="showDestroyModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="destroy" slot="btnSave" type="button"  class="btn btn-danger">Si, Eliminar</button>
        </modal>
    </div>
</template>
<script>
    import Question from '../models/Question';
    import Area from '../models/Area';
    import Paginator from '../components/Paginator.vue';
    import vSelect from 'vue-select';

    export default{
        components: {Paginator, vSelect},
        data(){
            return {
                showAddModal:false,
                showEditModal:false,
                showDestroyModal:false,
                areas:[],
                errors:[],
                create:{},
                current:{},
                filter:{},
                pagination:[],
                questions:[]
            }
        },
        created(){
            this.loadData();
            this.index();
        },
        methods:{
            show(question_id){
                this.$emit('show', question_id);
            },
            loadData(){
                Area.get({}, data => {this.areas = data.data});
            },
            index(page = 1) {
                let params = {
                    page: page,
                    name: this.filter.name,
                };

                Question.get(params, data => {
                    this.questions = data.data;
                    this.pagination = data.meta;
                });
            },
            store(){
                this.create.area_id = this.create.area ? this.create.area.id :null;

                Question.store(this.create, data => {
                    this.$toastr.s("Agregado exitosamente.");
                    this.index();
                    this.create = {};
                    this.errors = [];
                    this.showAddModal = false;
                }, errors => this.errors = errors);
            },
            edit(question){
                this.current = question;
                this.showEditModal = true
            },
            update(){
                this.current.area_id = this.current.area ? this.current.area.id :null;
                Question.update(this.current.id, this.current, data => {
                    this.$toastr.s("Editado exitosamente.");
                    this.index();
                    this.current = {};
                    this.errors = [];
                    this.showEditModal = false;
                }, errors => this.errors = errors);
            },
            del(question){
                this.current = question;
                this.showDestroyModal = true
            },
            destroy() {
                Question.destroy(this.current.id, data => {
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