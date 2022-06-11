<template>
    <div>
        <div class="container">
            <template v-if="!loading">
                <div class="row">
                    <h1>Roles</h1>
                    <!-- Form -->
                    <div class="col-md-4 d-none">
                        <input
                            class="form-control"
                            type="text"
                            v-model="role.id"
                        />
                    </div>
                    <div class="col-md-4 pt-3">
                        <label>Nombre</label>
                        <input
                            class="form-control"
                            type="text"
                            v-model="role.name_role"
                        />
                    </div>
                    <div class="col-md-12 pt-3">
                        <a href="#" class="btn btn-success" @click="save()">
                            <i class="fa fa-save"></i> {{ textButton }}</a
                        >
                    </div>

                    <!-- Table -->
                    <role-table
                        :data="roles"
                        :headers="headers"
                        @delete="deleteP($event)"
                        @edit="edit($event)"
                    />
                </div>
            </template>
            <template v-else>
                <alert />
            </template>
        </div>
    </div>
</template>

<script>
import ui from "../../libs/ui";
import Swal from "sweetalert2";

export default {
    data: () => {
        return {
            role: {
                name_role: "",
            },
            roles: [],
            grades: [],
            headers: ["#", "Nombre"],
            textButton: "Guardar",
            loading: false,
        };
    },

    mounted() {
        this.initialize();
    },

    methods: {
        async initialize() {
            this.loading = true;

            let res = await axios.get("api/role");
            this.roles = res.data.roles;

            this.loading = false;
        },

        async save() {
            let res;
            switch (this.textButton) {
                case "Guardar":
                    if (this.role.name_role == "") {
                        Swal.fire({
                            type: "error",
                            title: "Oops...",
                            text: "El nombre es requerido",
                        });
                        return;
                    } else {
                        res = await axios
                            .post("api/role", this.role)
                            .catch((e) => {
                                ui.alert(
                                    "Registro no pudo ser guardado correctamente.",
                                    "error"
                                );
                            });

                        if (res.data.message == "success") {
                            this.roles = res.data.roles;
                            ui.alert("Registro creado correctamente.");
                        }
                    }
                    break;
                case "Modificar":
                    res = await axios
                        .put(`api/role/${this.role.id}`, this.role)
                        .catch((e) => {
                            ui.alert(
                                "Registro no pudo ser actualizado correctamente.",
                                "error"
                            );
                        });

                    if (res.data.message == "success") {
                        ui.alert("Registro modificado correctamente.");
                    }
                    break;
            }
            this.initialize();
            this.cleanInputs();
        },

        edit(id) {
            this.role = this.roles.find((role) => role.id == id);
            this.textButton = "Modificar";
        },

        async deleteP(id) {
            Swal.fire({
                title: "¿Estás seguro de eliminar este registro?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Confimar",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await axios
                        .delete(`api/role/${id}`)
                        .catch((e) => {
                            ui.alert(
                                "Registro no pudo ser eliminado correctamente.",
                                "error"
                            );
                        });

                    if (res.data.message == "success") {
                        ui.alert("Registro eliminado correctamente.");
                        this.initialize();
                        this.cleanInputs();
                    }
                }
            });
        },

        cleanInputs() {
            this.role = {
                name_role: "",
                account_number: "",
                initial_amount: "0.00",
            };
            this.textButton = "Guardar";
        },
    },
};
</script>

<style></style>
