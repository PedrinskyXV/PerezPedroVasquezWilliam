<template>
    <div>
        <div class="container">
            <template v-if="!loading">
                <div class="row">
                    <h1>Sucursales</h1>
                    <!-- Form -->
                    <div class="col-md-4 d-none">
                        <input
                            class="form-control"
                            type="text"
                            v-model="branch.id"
                        />
                    </div>
                    <div class="col-md-6 pt-3">
                        <label>Nombre</label>
                        <input
                            class="form-control"
                            type="text"
                            v-model="branch.name"
                        />
                    </div>
                    <div class="col-md-6 pt-3">
                        <label>Dirección</label>
                        <textarea
                            cols="6"
                            rows="2"
                            class="form-control"
                            v-model="branch.address"
                        />
                    </div>
                    <div class="col-md-12 pt-3">
                        <a href="#" class="btn btn-success" @click="save()">
                            <i class="fa fa-save"></i> {{ textButton }}</a
                        >
                    </div>

                    <!-- Table -->
                    <branch-table
                        :data="branchs"
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
            branch: {
                name: "",
                address: "",
            },
            branchs: [],
            grades: [],
            headers: ["#", "Nombre", "Dirección", "Acciones"],
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

            let res = await axios.get("api/branch");            
            this.branchs = res.data.branches;
            this.loading = false;
        },

        async save() {
            let res;
            switch (this.textButton) {
                case "Guardar":
                    if (this.branch.name == "") {
                        Swal.fire({
                            type: "error",
                            title: "Oops...",
                            text: "El nombre es requerido",
                        });
                        return;
                    } else {
                        res = await axios
                            .post("api/branch", this.branch)
                            .catch((e) => {
                                ui.alert(
                                    "Registro no pudo ser guardado correctamente.",
                                    "error"
                                );
                            });

                        if (res.data.message == "success") {
                            this.branchs = res.data.branchs;
                            ui.alert("Registro creado correctamente.");
                        }
                    }
                    break;
                case "Modificar":
                    res = await axios
                        .put(`api/branch/${this.branch.id}`, this.branch)
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
            this.branch = this.branchs.find((branch) => branch.id == id);
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
                        .delete(`api/branch/${id}`)
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
            this.branch = {
                name_branch: "",
                account_number: "",
                initial_amount: "0.00",
            };
            this.textButton = "Guardar";
        },
    },
};
</script>

<style></style>
