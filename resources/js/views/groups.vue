<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Grupos
                            <button type="button" @click="showAddModal = true" v-tooltip="'Agregar'" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i></button>
                        </h5>
                    </div>

                    <div class="card-body">
                        <!-- <div class="input-group mb-12">
                            <input type="text" v-model="filter.name" class="form-control" placeholder="buscar" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button @click="index" class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fa fa-search"></i></button>
                            </div>
                        </div> -->
                        <br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Código</td>
                                    <td>Fecha de creación</td>
                                    <td>Escuela</td>
                                    <td>Mes de evaluación</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="group in groups" :key="group.id">
                                    <td>{{ group.id}}</td>
                                    <td>{{ group.created_at}}</td>
                                    <td>{{ group.school.name}}</td>
                                    <td>{{ group.month.name}}</td>
                                    <td>
                                        <button @click="edit(group)" v-tooltip="'Editar'" type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                        <button @click="del(group)" v-tooltip="'Eliminar'"  type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <paginator :pagination="pagination" @changePage="index"></paginator>
                    </div>
                </div>
            </div>
        </div>
        <modal v-show="showAddModal"  title="Formulario de creación de grupo a evaluar"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="create_name">Escuela</label>
                    <v-select label="name" :options="schools" v-model="create.school"></v-select>
                    <small  v-if="errors.school_id" class="form-text text-danger">{{ errors.school_id[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="create_name">Mes</label>
                    <v-select label="name" :options="months" v-model="create.month"></v-select>
                    <small  v-if="errors.month_id" class="form-text text-danger">{{ errors.month_id[0]}}</small>
                </div>
            </form>
            <button @click="showAddModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="store" slot="btnSave" type="button"  class="btn btn-primary">Guardar</button>
        </modal>

        <modal v-show="showEditModal"  title="Formulario de edición de grupo a evaluar"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="create_name">Escuela</label>
                    <v-select label="name" :options="schools" v-model="current.school"></v-select>
                    <small  v-if="errors.school_id" class="form-text text-danger">{{ errors.school_id[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="create_name">Mes</label>
                    <v-select label="name" :options="months" v-model="current.month"></v-select>
                    <small  v-if="errors.month_id" class="form-text text-danger">{{ errors.month_id[0]}}</small>
                </div>
            </form>
            <button @click="showEditModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="update" slot="btnSave" type="button"  class="btn btn-primary">Guardar Cambios</button>
        </modal>
        <modal v-show="showDestroyModal"  title="¿Estas seguro de eliminar este grupo?"  size="modal-md">
            <button @click="showDestroyModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="destroy" slot="btnSave" type="button"  class="btn btn-danger">Si, Eliminar</button>
        </modal>
    </div>
</template>
<script>
    import Group from '../models/Group';
    import Month from '../models/Month';
    import School from '../models/School';
    import vSelect from 'vue-select';
    import Paginator from '../components/Paginator.vue';


    export default{
        components: {Paginator, vSelect},
        data(){
            return {
                showAddModal:false,
                showEditModal:false,
                showDestroyModal:false,
                schools:[],
                months:[],
                errors:[],
                create:{},
                current:{},
                filter:{},
                pagination:[],
                groups:[]
            }
        },
        created(){
            this.loadData();
            this.index();
        },
        methods:{
            loadData(){
                School.get({}, data=> { this.schools = data.data});
                Month.get({}, data=> { this.months = data.data});
            },
            index(page = 1) {
                let params = {
                    page: page,
                    name: this.filter.name,
                };

                Group.get(params, data => {
                    this.groups = data.data;
                    this.pagination = data.meta;
                });
            },
            store(){
                this.create.school_id = this.create.school ? this.create.school.id :null;
                this.create.month_id = this.create.month ? this.create.month.id :null;
                Group.store(this.create, data => {
                    this.$toastr.s("Agregado exitosamente.");
                    this.index();
                    this.create = {};
                    this.errors = [];
                    this.showAddModal = false;
                }, errors => this.errors = errors);
            },
            edit(group){
                this.current = group;
                this.showEditModal = true
            },
            update(){
                this.current.school_id = this.current.school ? this.current.school.id :null;
                this.current.month_id = this.current.month ? this.current.month.id :null;

                Group.update(this.current.id, this.current, data => {
                    this.$toastr.s("Editado exitosamente.");
                    this.index();
                    this.current = {};
                    this.errors = [];
                    this.showEditModal = false;
                }, errors => this.errors = errors);
            },
            del(group){
                this.current = group;
                this.showDestroyModal = true
            },
            destroy() {
                Group.destroy(this.current.id, data => {
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