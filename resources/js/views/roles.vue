<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Roles
                            <button type="button" @click="showAddModal = true" v-tooltip="'Agregar'" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i></button>
                        </h5>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Nombre</td>
                                    <td>Descripción</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="role in roles" :key="role.id">
                                    <td>{{ role.id}}</td>
                                    <td>{{ role.name}}</td>
                                    <td>{{ role.description}}</td>
                                    <td>
                                        <button @click="edit(role)" v-tooltip="'Editar'" type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                        <button @click="del(role)" v-tooltip="'Eliminar'"  type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <paginator :pagination="pagination" @changePage="index"></paginator>
                    </div>
                </div>
            </div>
        </div>
        <modal v-show="showAddModal"  title="Formulario de creación de roles"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="create_name">Nombre</label>
                    <input type="text" class="form-control" id="create_name" v-model="create.name">
                    <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="create_description">Descripción</label>
                    <input type="text" class="form-control" id="create_description" v-model="create.description">
                    <small  v-if="errors.description" class="form-text text-danger">{{ errors.description[0]}}</small>
                </div>
            </form>
            <button @click="showAddModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="store" slot="btnSave" type="button"  class="btn btn-primary">Guardar</button>
        </modal>
        <modal v-show="showEditModal"  title="Formulario de edición de roles"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="create_name">Nombre</label>
                    <input type="text" class="form-control" id="create_name" v-model="current.name">
                    <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="create_description">Descripción</label>
                    <input type="text" class="form-control" id="create_description" v-model="current.description">
                    <small  v-if="errors.description" class="form-text text-danger">{{ errors.description[0]}}</small>
                </div>
            </form>
            <button @click="showEditModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="update" slot="btnSave" type="button"  class="btn btn-primary">Guardar Cambios</button>
        </modal>
        <modal v-show="showDestroyModal"  title="¿Estas seguro de eliminar este rol?"  size="modal-md">
            <button @click="showDestroyModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="destroy" slot="btnSave" type="button"  class="btn btn-primary">Si, Eliminar</button>
        </modal>
    </div>
</template>
<script>
    import Role from '../models/Role';
    import Paginator from '../components/Paginator.vue';

    export default{
        components: {Paginator},
        data(){
            return {
                showAddModal:false,
                showEditModal:false,
                showDestroyModal:false,
                roles:[],
                errors:[],
                create:{},
                current:{},
                filter:{},
                pagination:[],
            }
        },
        created(){
            this.index();
        },
        methods:{
            index(page = 1) {
                let params = {
                    page: page,
                    name: this.filter.name,
                };

                Role.get(params, data => {
                    this.roles = data.data;
                    this.pagination = data.meta;
                });
            },
            store(){
                let params = {
                    name: this.create.name,
                    description: this.create.description
                };

                Role.store(params, data => {
                    this.$toastr.s("Agregado exitosamente.");
                    this.index();
                    this.create = {};
                    this.errors = [];
                    this.showAddModal = false;
                }, errors => this.errors = errors);
            },
            edit(role){
                this.current = role;
                this.showEditModal = true
            },
            update(){
                let params = {
                     name: this.current.name,
                     description: this.current.description,
                    _method: 'PUT'
                };

                Role.update(this.current.id, params, data => {
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
                Role.destroy(this.current.id, data => {
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