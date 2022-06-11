<template>
    <div>
        <div class="container">
            <template v-if="!loading">
                <div class="row">
                    <h1>Empleados</h1>
                    <!-- Form -->
                    <div class="col-md-4 d-none">
                        <input
                            class="form-control"
                            type="text"
                            v-model="employee.id"
                        />
                    </div>
                    <div class="col-md-4 pt-3">
                        <label>Nombre</label>
                        <input
                            class="form-control"
                            type="text"
                            v-model="employee.name_employee"
                        />
                    </div>
                    <div class="col-md-4 pt-3">
                        <label>Edad</label>
                        <input
                            class="form-control"
                            type="text"
                            v-model="employee.age"
                            v-mask="'########-#'"
                        />
                    </div>
                    <div class="col-md-4 pt-3">
                        <label>Sueldo Base</label>
                        <input
                            class="form-control"
                            type="number"
                            v-model="employee.base_salary"
                        />
                    </div>
                    <div class="col-md-6 pt-3">
                        <label>Dirección</label>
                        <textarea
                            cols="6"
                            rows="2"
                            class="form-control"
                            v-model="employee.address"
                        />
                    </div>

                    <div class="col-md-12 pt-3">
                        <a href="#" class="btn btn-success" @click="save()">
                            <i class="fa fa-save"></i> {{ textButton }}</a
                        >
                    </div>

                    <!-- Table -->
                    <base-table
                        :data="employees"
                        :headers="headers"
                        @delete="deleteP($event)"
                        @edit="edit($event)"
                    />
                </div>
                <paginationLaravel
                    :data="pagination"
                    @pagination-change-page="getResults"
                    :limit="1"
                ></paginationLaravel>
            </template>
            <template v-else>
                <alert />
            </template>
        </div>
    </div>
</template>

<script>
import ui from "../libs/ui";
import PaginationLaravel from "laravel-vue-pagination";
import Swal from "sweetalert2";

export default {
    components: { PaginationLaravel },
    data: () => {
        return {
            employee: {
                age: "",
                base_salary: "",
                name_employee: "",
            },
            employees: [],
            errors: [],
            grades: [],
            headers: [
                "#",
                "Nombre",
                "Edad",
                "Sueldo Base",
                "Dirección",
                "Foto",
            ],
            textButton: "Guardar",
            loading: false,
            pagination: {},
        };
    },

    mounted() {
        this.initialize();
    },

    methods: {
        async initialize() {
            this.loading = true;

            let res = await axios.get("api/employee");
            this.employees = res.data.employees.data;
            this.pagination = res.data.employees;

            this.loading = false;
        },

        async save() {
            let res;
            switch (this.textButton) {
                case "Guardar":
                    this.loading = true;
                    this.textButton = "Guardando...";

                    if (
                        this.employee.name_employee &&
                        this.employee.age &&
                        this.employee.base_salary &&
                        this.employee.address
                    ) {
                        res = await axios
                            .post("api/employee", this.employee)
                            .catch((e) => {
                                ui.alert(
                                    "Registro no pudo ser guardado correctamente.",
                                    "error"
                                );
                            });

                        if (res.data.message == "success") {
                            this.employees = res.data.employees;
                            ui.alert("Registro creado correctamente.");
                        }
                    }
                    this.errors = [];

                    if (!this.employee.name_employee) {
                        this.errors.push("El nombre es requerido");
                    }

                    if (!this.employee.age) {
                        this.errors.push("La edad es requerida");
                    }

                    if (!this.employee.base_salary) {
                        this.errors.push("El sueldo base es requerido");
                    }

                    if (!this.employee.address) {
                        this.errors.push("La dirección es requerida");
                    }

                    e.preventDefault();
                    this.loading = false;
                    this.textButton = "Guardar";

                    break;
                case "Modificar":
                    res = await axios
                        .put(`api/employee/${this.employee.id}`, this.employee)
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
            this.employee = this.employees.find(
                (employee) => employee.id == id
            );
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
                        .delete(`api/employee/${id}`)
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
            this.employee = {};
            this.textButton = "Guardar";
        },

        async getResults(page = 1) {
            const res = await axios.get(this.pagination.path + "?page=" + page);
            this.employees = res.data.employees.data;
            this.pagination = res.data.employees;
        },
    },
};
</script>

<style></style>
