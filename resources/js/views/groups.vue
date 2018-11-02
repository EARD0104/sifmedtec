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
                        <div class="form-row">
                            <div class="form-group col-xs-12 col-md-6 col-lg-3">
                                <label for="filter_name">Escuela</label>
                                <v-select  label="name" :options="schools" v-model="filter.school"></v-select>
                            </div>
                            <div class="form-group col-xs-12 col-md-6 col-lg-2">
                                <label for="filter_name">Mes</label>
                                <v-select label="name" :options="months" v-model="filter.month"></v-select>
                            </div>
                            <div class="form-group col-xs-12 col-md-6 col-lg-2">
                                <label for="filter_name">Desde fecha</label>
                                <input type="date" class="form-control form-control-lg" v-model="filter.from">
                            </div>
                            <div class="form-group col-xs-12 col-md-6 col-lg-2">
                                <label for="filter_name">Hasta</label>
                                <input type="date" class="form-control form-control-lg" v-model="filter.to">
                            </div>
                            <div class="form-group col-xs-12 col-md-6 col-lg-2">
                                <div class="form-check">
                                    <br>
                                    <br>
                                    <input class="form-check-input" type="checkbox" id="gridCheck" v-model="filter.status" value="0">
                                    <label class="form-check-label" for="gridCheck">
                                        Inactivo
                                    </label>
                                </div>
                            </div>
                            <div class="">
                                <br>
                                <button type="button" @click="index" class="btn btn-primary btn-lg"><span class="fa fa-search"></span></button>
                            </div>

                        </div>

                        <br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Fecha de creación</th>
                                    <th>Escuela</th>
                                    <th>Mes de evaluación</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="group in groups" :key="group.id">
                                    <td>{{ group.id}}</td>
                                    <td>{{ group.created_at}}</td>
                                    <td>{{ group.school.name}}</td>
                                    <td>{{ group.month.name}}</td>
                                    <td>
                                        <span v-if="group.status == 1" class="badge badge-success">Activo</span>
                                        <span v-else class="badge badge-info">Inactivo</span>
                                    </td>
                                    <td>
                                        <button :disabled="!group.status"  @click="edit(group)" v-tooltip="'Editar'" type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                        <button v-if="group.status" @click="del(group)" v-tooltip="'Desactivar'"  type="button" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i></button>
                                        <button v-if="!group.status" @click="act(group)" v-tooltip="'Activar'"  type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
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
        <modal v-show="showActiveModal"  title="¿Estas seguro de activar este grupo?"  size="modal-md">
            <button @click="showActiveModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="destroy" slot="btnSave" type="button"  class="btn btn-success">Si, Activar</button>
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
                showActiveModal:false,
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
                    school_id: this.filter.school ? this.filter.school.id:null ,
                    month_id: this.filter.month ? this.filter.month.id:null ,
                    status: this.filter.status ? this.filter.status:null,
                    from: this.filter.from ? this.filter.from:null,
                    to: this.filter.to ? this.filter.to:null,
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
            act(group){
                this.current = group;
                this.showActiveModal = true
            },
            destroy() {
                Group.destroy(this.current.id, data => {
                    this.$toastr.s("Eliminado exitosamente.");
                    this.index();
                    this.current = {};
                    this.showDestroyModal = false;
                    this.showActiveModal = false;
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