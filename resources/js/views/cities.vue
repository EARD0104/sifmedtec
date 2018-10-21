<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Municipios
                            <button type="button" @click="showAddModal = true" v-tooltip="'Agregar'" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i></button>
                        </h5>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Nombre</td>
                                    <td>Departamento</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="city in cities" :key="city.id">
                                    <td>{{ city.id}}</td>
                                    <td>{{ city.name}}</td>
                                    <td>{{ city.department.name}}</td>
                                    <td>
                                        <button @click="edit(city)" v-tooltip="'Editar'" type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                        <button @click="del(city)" v-tooltip="'Eliminar'"  type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <paginator :pagination="pagination" @changePage="index"></paginator>
                    </div>
                </div>
            </div>
        </div>
        <modal v-show="showAddModal"  title="Formulario de creación de municipio"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="create_name">Nombre</label>
                    <input type="text" class="form-control" id="create_name" v-model="create.name">
                    <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="create_name">Departamento</label>
                    <v-select label="name" :options="departments" v-model="create.department"></v-select>
                    <small  v-if="errors.department_id" class="form-text text-danger">{{ errors.department_id[0]}}</small>
                </div>
            </form>
            <button @click="showAddModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="store" slot="btnSave" type="button"  class="btn btn-primary">Guardar</button>
        </modal>

        <modal v-show="showEditModal"  title="Formulario de edición de municipio"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="edit_name">Nombre</label>
                    <input type="text" class="form-control" id="edit_name" v-model="current.name">
                    <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="create_name">Departamento</label>
                    <v-select label="name" :options="departments" v-model="current.department"></v-select>
                    <small  v-if="errors.department_id" class="form-text text-danger">{{ errors.department_id[0]}}</small>
                </div>
            </form>
            <button @click="showEditModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="update" slot="btnSave" type="button"  class="btn btn-primary">Guardar Cambios</button>
        </modal>
        <modal v-show="showDestroyModal"  title="¿Estas seguro de eliminar este departamento?"  size="modal-md">
            <button @click="showDestroyModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="destroy" slot="btnSave" type="button"  class="btn btn-danger">Si, Eliminar</button>
        </modal>
    </div>
</template>
<script>
    import City from '../models/City';
    import Department from '../models/Department';
    import Paginator from '../components/Paginator.vue';
    import vSelect from 'vue-select';

    export default{
        components: {Paginator, vSelect},
        data(){
            return {
                showAddModal:false,
                showEditModal:false,
                showDestroyModal:false,
                departments:[],
                errors:[],
                create:{},
                current:{},
                filter:{},
                pagination:[],
                cities:[]
            }
        },
        created(){
            this.loadData();
            this.index();
        },
        methods:{
            loadData(){
                Department.get({}, data=> { this.departments = data.data});
            },
            index(page = 1) {
                let params = {
                    page: page,
                    name: this.filter.name,
                };

                City.get(params, data => {
                    this.cities = data.data;
                    this.pagination = data.meta;
                });
            },
            store(){
                this.create.department_id = this.create.department ? this.create.department.id :null;
                City.store(this.create, data => {
                    this.$toastr.s("Agregado exitosamente.");
                    this.index();
                    this.create = {};
                    this.errors = [];
                    this.showAddModal = false;
                }, errors => this.errors = errors);
            },
            edit(city){
                this.current = city;
                this.showEditModal = true
            },
            update(){
                this.current.department_id = this.current.department ? this.current.department.id :null;
                City.update(this.current.id, this.current, data => {
                    this.$toastr.s("Editado exitosamente.");
                    this.index();
                    this.current = {};
                    this.errors = [];
                    this.showEditModal = false;
                }, errors => this.errors = errors);
            },
            del(city){
                this.current = city;
                this.showDestroyModal = true
            },
            destroy() {
                City.destroy(this.current.id, data => {
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