<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Usuarios
                            <button type="button" @click="showAddModal = true" v-tooltip="'Agregar'" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i></button>
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="input-group mb-12">
                            <input type="text" v-model="filter.name" class="form-control" placeholder="buscar por nombre" aria-describedby="button-addon2">
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
                                    <td>Correo</td>
                                    <td>Rol</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.id}}</td>
                                    <td>{{ user.name}}</td>
                                    <td>{{ user.email}}</td>
                                    <td>{{ user.role.name}}</td>
                                    <td>
                                        <button @click="edit(user)" v-tooltip="'Editar'" type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                        <button @click="del(user)" v-tooltip="'Eliminar'"  type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <paginator :pagination="pagination" @changePage="index"></paginator>
                    </div>
                </div>
            </div>
        </div>
        <modal v-show="showAddModal"  title="Formulario de creación de usuarios"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="create_name">Nombre</label>
                    <input type="text" class="form-control" id="create_name" v-model="create.name">
                    <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="create_email">Email</label>
                    <input type="email" class="form-control" id="create_email" v-model="create.email">
                    <small  v-if="errors.email" class="form-text text-danger">{{ errors.email[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="create_role">Rol</label>
                    <v-select label="name" :options="roles" v-model="create.role"></v-select>
                    <small  v-if="errors.role_id" class="form-text text-danger">{{ errors.role_id[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="create_password">Contraseña</label>
                    <input type="password" class="form-control" id="create_password" v-model="create.password">
                    <small  v-if="errors.password" class="form-text text-danger">{{ errors.password[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" v-model="create.password_confirmation">
                    <small  v-if="errors.password_confirmation" class="form-text text-danger">{{ errors.password_confirmation[0]}}</small>
                </div>
            </form>
            <button @click="showAddModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="store" slot="btnSave" type="button"  class="btn btn-primary">Guardar</button>
        </modal>
        <modal v-show="showEditModal"  title="Formulario de edición de roles"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="edit_name">Nombre</label>
                    <input type="text" class="form-control" id="edit_name" v-model="current.name">
                    <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="edit_email">Email</label>
                    <input type="email" class="form-control" id="edit_email" v-model="current.email">
                    <small  v-if="errors.email" class="form-text text-danger">{{ errors.email[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="edit_role">Rol</label>
                    <v-select label="name" :options="roles" v-model="current.role"></v-select>
                    <small  v-if="errors.role_id" class="form-text text-danger">{{ errors.role_id[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="edit_password">Contraseña</label>
                    <input type="password" class="form-control" id="edit_password" v-model="current.password">
                    <small  v-if="errors.password" class="form-text text-danger">{{ errors.password[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="edit_password_confirmation">Contraseña</label>
                    <input type="password" class="form-control" id="edit_password_confirmation" v-model="current.password_confirmation">
                    <small  v-if="errors.password_confirmation" class="form-text text-danger">{{ errors.password_confirmation[0]}}</small>
                </div>
            </form>
            <button @click="showEditModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="update" slot="btnSave" type="button"  class="btn btn-primary">Guardar Cambios</button>
        </modal>
        <modal v-show="showDestroyModal"  title="¿Estas seguro de eliminar este usuario?"  size="modal-md">
            <button @click="showDestroyModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="destroy" slot="btnSave" type="button"  class="btn btn-danger">Si, Eliminar</button>
        </modal>
    </div>
</template>
<script>
    import Role from '../models/Role';
    import User from '../models/User';
    import Paginator from '../components/Paginator.vue';
    import vSelect from 'vue-select';


    export default{
        components: {Paginator, vSelect},
        data(){
            return {
                showAddModal:false,
                showEditModal:false,
                showDestroyModal:false,
                users:[],
                errors:[],
                create:{},
                current:{role:{}},
                filter:{},
                pagination:[],
                roles:[],
            }
        },
        created(){
            this.loadData();
            this.index();
        },
        methods:{
            loadData(){
                Role.get({}, data => {this.roles = data.data;});
            },
            index(page = 1) {
                let params = {
                    page: page,
                    name: this.filter.name,
                };

                User.get(params, data => {
                    this.users = data.data;
                    this.pagination = data.meta;
                });
            },
            store(){
                let params = {
                    name: this.create.name ? this.create.name:'',
                    email: this.create.email ? this.create.email:'',
                    password: this.create.password ? this.create.password:'',
                    password_confirmation: this.create.password_confirmation ? this.create.password_confirmation:'',
                    role_id: this.create.role? this.create.role.id :''
                };

                User.store(params, data => {
                    this.$toastr.s("Agregado exitosamente.");
                    this.index();
                    this.create = {};
                    this.errors = [];
                    this.showAddModal = false;
                }, errors => this.errors = errors);
            },
            edit(user){
                this.current = user;
                this.showEditModal = true
            },
            update(){
                let params = {
                    name: this.current.name ? this.current.name:'',
                    email: this.current.email ? this.current.email:'',
                    password: this.current.password ? this.current.password:'',
                    password_confirmation: this.current.password_confirmation ? this.current.password_confirmation:'',
                    role_id: this.current.role? this.current.role.id :'',
                    _method: 'PUT'
                };

                User.update(this.current.id, params, data => {
                    this.$toastr.s("Editado exitosamente.");
                    this.index();
                    this.current = {};
                    this.errors = [];
                    this.showEditModal = false;
                }, errors => this.errors = errors);
            },
            del(role){
                this.current = role;
                this.showDestroyModal = true
            },
            destroy() {
                User.destroy(this.current.id, data => {
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