<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Areas
                            <button type="button" @click="showAddModal = true" v-tooltip="'Agregar'" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i></button>
                        </h5>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Nombre</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="area in areas" :key="area.id">
                                    <td>{{ area.id}}</td>
                                    <td>{{ area.name}}</td>
                                    <td>
                                        <button @click="edit(area)" v-tooltip="'Editar'" type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                        <button @click="del(area)" v-tooltip="'Eliminar'"  type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <paginator :pagination="pagination" @changePage="index"></paginator>
                    </div>
                </div>
            </div>
        </div>
        <modal v-show="showAddModal"  title="Formulario de creación de área"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="create_name">Nombre</label>
                    <input type="text" class="form-control" id="create_name" v-model="create.name">
                    <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
                </div>
            </form>
            <button @click="showAddModal = false" slot="btnCancel" type="button"   class="btn btn-link">Cancelar</button>
            <button @click="store" slot="btnSave" type="button"  class="btn btn-primary">Guardar</button>
        </modal>

        <modal v-show="showEditModal"  title="Formulario de edición de área"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="edit_name">Nombre</label>
                    <input type="text" class="form-control" id="edit_name" v-model="current.name">
                    <small  v-if="errors.name" class="form-text text-danger">{{ errors.name[0]}}</small>
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
    import Area from '../models/Area';
    import Paginator from '../components/Paginator.vue';
    export default{
        components: {Paginator},
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

                Area.get(params, data => {
                    this.areas = data.data;
                    this.pagination = data.meta;
                });
            },
            store(){
                Area.store(this.create, data => {
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
                Area.update(this.current.id, this.current, data => {
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
                Area.destroy(this.current.id, data => {
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