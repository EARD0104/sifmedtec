<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Escuelas
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
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Municipio</th>
                                    <th>No Maestros</th>
                                    <th>Director</th>
                                    <th>Tel Escuela</th>
                                    <th>Tel Director</th>
                                    <th>Tel Contácto</th>
                                    <th>Email Escuela</th>
                                    <th>Email Director</th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="school in schools" :key="school.id">
                                    <td>{{ school.id}}</td>
                                    <td>{{ school.name}}</td>
                                    <td>{{ school.city ? school.city.name :'' }}</td>
                                    <td>{{ school.teachers}}</td>
                                    <td>{{ school.principal_name}}</td>
                                    <td>{{ school.phone}}</td>
                                    <td>{{ school.principal_phone}}</td>
                                    <td>{{ school.other_phone}}</td>
                                    <td>{{ school.email}}</td>
                                    <td>{{ school.principal_email}}</td>

                                    <td>
                                        <button @click="edit(school)" v-tooltip="'Editar'" type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                    </td>
                                    <td>
                                        <button @click="del(school)" v-tooltip="'Eliminar'"  type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <paginator :pagination="pagination" @changePage="index"></paginator>
                    </div>
                </div>
            </div>
        </div>
        <modal v-show="showAddModal"  title="Formulario de creación de escuelas"  size="modal-lg">
            <form class="form">
                <div class="form-row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Departamento</label>
                        <v-select label="name" :options="departments" v-model="create.department"></v-select>
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Municipio</label>
                        <v-select label="name" :options="cities" v-model="create.city"></v-select>
                        <small  v-if="errors.city_id" class="form-text text-danger">{{ errors.city_id[0]}}</small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Nombre</label>
                        <input type="text" class="form-control"  v-model="create.name">
                        <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Email escuela</label>
                        <input type="email" class="form-control"  v-model="create.email">
                        <small  v-if="errors.email" class="form-text text-danger">{{ errors.email[0]}}</small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Teléfono escuela</label>
                        <input type="text" class="form-control"  v-model="create.phone">
                        <small  v-if="errors.phone" class="form-text text-danger">{{ errors.phone[0]}}</small>
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">No. Maestros</label>
                        <input type="text" class="form-control"  v-model="create.teachers">
                        <small  v-if="errors.teachers" class="form-text text-danger">{{ errors.teachers[0]}}</small>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Nombre Director</label>
                        <input type="text" class="form-control"  v-model="create.principal_name">
                        <small  v-if="errors.principal_name" class="form-text text-danger">{{ errors.principal_name[0]}}</small>
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Email Director</label>
                        <input type="email" class="form-control"  v-model="create.principal_email">
                        <small  v-if="errors.principal_email" class="form-text text-danger">{{ errors.principal_email[0]}}</small>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Teléfono Director</label>
                        <input type="text" class="form-control"  v-model="create.principal_phone">
                        <small  v-if="errors.principal_phone" class="form-text text-danger">{{ errors.principal_phone[0]}}</small>
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Teléfono contácto</label>
                        <input type="text" class="form-control"  v-model="create.other_phone">
                        <small  v-if="errors.other_phone" class="form-text text-danger">{{ errors.other_phone[0]}}</small>
                    </div>


                </div>

            </form>
            <button @click="showAddModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="store" slot="btnSave" type="button"  class="btn btn-primary">Guardar</button>
        </modal>

        <modal v-show="showEditModal"  title="Formulario de edición de escuela"  size="modal-md">
            <form class="form">
                <div class="form-row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Departamento</label>
                        <v-select label="name" :options="departments" v-model="current.department"></v-select>
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Municipio</label>
                        <v-select label="name" :options="cities" v-model="current.city"></v-select>
                        <small  v-if="errors.city_id" class="form-text text-danger">{{ errors.city_id[0]}}</small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Nombre</label>
                        <input type="text" class="form-control"  v-model="current.name">
                        <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Email escuela</label>
                        <input type="email" class="form-control"  v-model="current.email">
                        <small  v-if="errors.email" class="form-text text-danger">{{ errors.email[0]}}</small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Teléfono escuela</label>
                        <input type="text" class="form-control"  v-model="current.phone">
                        <small  v-if="errors.phone" class="form-text text-danger">{{ errors.phone[0]}}</small>
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">No. Maestros</label>
                        <input type="text" class="form-control"  v-model="current.teachers">
                        <small  v-if="errors.teachers" class="form-text text-danger">{{ errors.teachers[0]}}</small>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Nombre Director</label>
                        <input type="text" class="form-control"  v-model="current.principal_name">
                        <small  v-if="errors.principal_name" class="form-text text-danger">{{ errors.principal_name[0]}}</small>
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Email Director</label>
                        <input type="email" class="form-control"  v-model="current.principal_email">
                        <small  v-if="errors.principal_email" class="form-text text-danger">{{ errors.principal_email[0]}}</small>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Teléfono Director</label>
                        <input type="text" class="form-control"  v-model="current.principal_phone">
                        <small  v-if="errors.principal_phone" class="form-text text-danger">{{ errors.principal_phone[0]}}</small>
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="edit_name">Teléfono contácto</label>
                        <input type="text" class="form-control"  v-model="current.other_phone">
                        <small  v-if="errors.other_phone" class="form-text text-danger">{{ errors.other_phone[0]}}</small>
                    </div>


                </div>
            </form>
            <button @click="showEditModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="update" slot="btnSave" type="button"  class="btn btn-primary">Guardar Cambios</button>
        </modal>
        <modal v-show="showDestroyModal"  title="¿Estas seguro de eliminar esta área?"  size="modal-md">
            <button @click="showDestroyModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="destroy" slot="btnSave" type="button"  class="btn btn-danger">Si, Eliminar</button>
        </modal>
    </div>
</template>
<script>
    import School from '../models/School';
    import Paginator from '../components/Paginator.vue';
    import vSelect from 'vue-select';
    import Department from '../models/Department';
    import City from '../models/City';

    export default{
        components: {Paginator, vSelect},
        data(){
            return {
                showAddModal:false,
                showEditModal:false,
                showDestroyModal:false,
                schools:[],
                errors:[],
                create:{},
                current:{},
                filter:{},
                pagination:[],
                departments:[],
                cities:[]
            }
        },
        created(){
            this.loadData();
            this.index();
        },
        methods:{
            loadData(){
                Department.get({}, data => { this.departments = data.data});
            },
            loadCities(){
                if (this.create.department  ) {
                    City.get({department_id : this.create.department.id}, data => { this.cities = data.data});
                }
            },
            index(page = 1) {
                let params = {
                    page: page,
                    name: this.filter.name,
                };

                School.get(params, data => {
                    this.schools = data.data;
                    this.pagination = data.meta;
                });
            },
            store(){

                this.create.city_id = this.create.city ? this.create.city.id:null;
                School.store(this.create, data => {
                    this.$toastr.s("Agregado exitosamente.");
                    this.index();
                    this.create = {};
                    this.errors = [];
                    this.showAddModal = false;
                }, errors => this.errors = errors);
            },
            edit(area){
                this.current = area;
                this.showEditModal = true
            },
            update(){
                this.current.city_id = this.current.city ? this.current.city.id:null;
                School.update(this.current.id, this.current, data => {
                    this.$toastr.s("Editado exitosamente.");
                    this.index();
                    this.current = {};
                    this.errors = [];
                    this.showEditModal = false;
                }, errors => this.errors = errors);
            },
            del(area){
                this.current = area;
                this.showDestroyModal = true
            },
            destroy() {
                School.destroy(this.current.id, data => {
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
        },
        watch:{
            'create.department':function(){
                this.loadCities();
            },
            'current.department':function(){
                this.loadCities();
            },
            'current':function(){
                if (this.current) {
                    this.loadData();
                    this.current.department = this.current.city.department;
                }
            }
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