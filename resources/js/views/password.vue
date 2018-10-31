<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Cambio de contraseña
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        <modal   title="Formulario de cambio de contraseña"  size="modal-md">
            <form class="form">
                <div class="form-group">
                    <label for="create_name">Contraseña Actual</label>
                    <input type="password" class="form-control"  v-model="create.current_password">
                    <small  v-if="errors.current_password" class="form-text text-danger">{{ errors.current_password[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="create_name">Nueva contraseña</label>
                    <input type="password" class="form-control"  v-model="create.password">
                    <small  v-if="errors.password" class="form-text text-danger">{{ errors.password[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="create_name">Confirmar contraseña</label>
                    <input type="password" class="form-control"  v-model="create.password_confirmation">
                    <small  v-if="errors.password_confirmation" class="form-text text-danger">{{ errors.password_confirmation[0]}}</small>
                </div>

            </form>
            <a  slot="btnCancel"   class="btn btn-link" href="/home">Cancelar</a>
            <button @click="store" slot="btnSave" type="button"  class="btn btn-primary">Guardar</button>
        </modal>

    </div>
</template>
<script>
    import Password from '../models/Password';
    export default{
        data(){
            return {
                errors:[],
                create:{},
            }
        },
        methods:{
            store(){
                Password.store(this.create, data => {
                    this.$toastr.s("Agregado exitosamente.");
                    this.index();
                    this.create = {};
                    this.errors = [];
                    this.showAddModal = false;
                }, errors => this.errors = errors);
            },
        }
    }
</script>
