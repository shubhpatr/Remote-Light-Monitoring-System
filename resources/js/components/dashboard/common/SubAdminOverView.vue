<template>
    <v-content>
        <v-container class="container" fluid style="margin-top: -64px;">
            <v-overlay :value="showFullLoading" :absolute="absolute">
                <v-progress-circular
                    indeterminate
                    size="64"
                ></v-progress-circular>
            </v-overlay>
            <!-- <v-col cols="5">
                            <v-select
                                v-model="filters.admin_id"
                                :items="dataMachine"
                                item-text="name"
                                item-value="id"
                                label="Belongs To"
                                required
								clearable
                                filled
								@change="getTask"
                            ></v-select>                            
                        </v-col> -->

            <v-card flat>
                <v-card-title>ACTIVE CLIENT LIST</v-card-title>
                <v-text-field
                    style="margin-left: 24px; margin-right: 24px;"
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                ></v-text-field>

                <v-card-text outlined>
                    <v-data-table
                        :headers="headers"
                        :search="search"
                        :items="dataEngineer"
                        :items-per-page="filters.show"
                    >
                        <template v-slot:item.machine_id="{ item }">
                            <p>{{ item.machine.name }}</p>
                        </template>
                        <template v-slot:item.action="{ item }">
                            <!-- <v-tooltip bottom> -->
                            <!-- <template v-slot:activator="{ on }"> -->
                            <v-tooltip right>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon
                                        large
                                        v-bind="attrs"
                                        v-on="on"
                                        class="mr-2"
                                        @click="detailItem(item)"
                                        v-if="checkassign(item)"
                                    >
                                        mdi-eye
                                    </v-icon>
                                </template>
                                <span>View</span>
                            </v-tooltip>

                            <!-- <v-btn
                            v-bind="attrs"
                                 v-on="on"  
                                small
                                dark
                                color="#424242"
                                style="border-radius:0px;"
                                @click="detailItem(item)"
                                v-if='checkassign(item)'
                                
                                >View</v-btn
                            >

                             -->
                        </template>
                        <template v-slot:no-data>
                            <v-skeleton-loader
                                v-show="loading"
                                type="table-tbody"
                            ></v-skeleton-loader>
                        </template>
                    </v-data-table>
                    <!-- <div class="text-center">
                        <v-pagination
                            v-model="filters.page"
                            :length="pageCount"
                            @input="getTask"
                            color="#424242"
                        ></v-pagination>
                    </div> -->
                </v-card-text>
            </v-card>
            <DeleteModal
                :trigger="isDelete"
                :title="deleteTitle"
                :body="deleteBody"
                @request="remove"
            ></DeleteModal>
        </v-container>
    </v-content>
</template>

<script>
import DeleteModal from "./../common/DeleteModal";

export default {
    components: {
        DeleteModal
    },
    props: {
        source: String
    },
    data: () => ({
        dataIndex: null,
        userType: null,
        deleteTitle: "",
        deleteBody: "",
        isDelete: false,
        absolute: true,
        edit: true,
        dialog: false,
        search: "",
        dialog: false,
        loading: false,
        itemsPerPage: 1,
        pageCount: 2,
        search: "",
        headers: [
            { text: "ID", value: "id" },
            { text: "Name", value: "admin_name" },
            { text: "User Name", value: "admin_email" },
            // { text: "Client Name", value: "name" },
            // { text: "Client ID", value: "email" },
            // { text: "Machine Name", value: "machine_id" },
            {
                text: "View Installations",
                align: "center",
                value: "action",
                sortable: false
            }
        ],
        editedIndex: -1,
        editedIndex: -1,
        editedItem: {
            id: "",
            engineer_name: "",
            engineer_id: "",
            client_name: "",
            client_id: ""
        },
        defaultItem: {
            id: "",
            engineer_name: "",
            engineer_id: "",
            client_name: "",
            client_id: ""
        },
        dataList: [],
        dataMachine: [],
        dataEngineer: [],
        filters: {
            start: new Date().toISOString().substr(0, 10),
            end: "",
            page: 1,
            show: 20
        }
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "New Item" : "Edit Item";
        }
    },
    created() {
        this.userType = this.$store.state.authUser.userType;
        this.initialize();
    },
    methods: {
        async initialize() {
            this.filters.page = 1;

            this.getTask();
            this.getMachine();
            this.getEngineer();
        },
        async getMachine() {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/getunsignmachinetask"
                });
                this.dataMachine = data;
            } catch (e) {
                this.loading = false;
            }
        },

        async getEngineer() {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/superadmindashboardoverview"
                });
                this.dataEngineer = data;
            } catch (e) {
                this.loading = false;
            }
        },
        async getTask() {
            this.loading = true;
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/task",
                    params: this.filters
                });
                this.dataList = data.data;
                this.itemsPerPage = per_page;
                this.pageCount = last_page;
                this.filters.page = current_page;
                this.loading = false;
            } catch (e) {
                this.loading = false;
            }
        },

        checkassign(item) {
            if (item.admin_name == "Unassigned") {
                return false;
            } else {
                return true;
            }
        },

        deleteItem(item) {
            const index = this.dataList.indexOf(item);
            confirm("Are you sure you want to delete this item?") &&
                this.dataList.splice(index, 1);
        },
        close() {
            this.dialog = false;
            this.loading = false;
            setTimeout(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            }, 300);
        },
        detailItem(item) {
            this.$router.push("/dashboard/task/lift/" + item.id);
        },
        deleteItem(item) {
            this.dataIndex = this.dataList.indexOf(item);
            this.deleteTitle = "Are you sure you want to delete this item?";
            this.isDelete = !this.isDelete;
        },
        close() {
            this.dialog = false;
            this.loading = false;
            setTimeout(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            }, 300);
        },
        async save() {
            this.loading = true;
            if (this.editedIndex > -1) {
                try {
                    let { data } = await axios({
                        method: "put",
                        url: "/app/task/" + this.editedItem.id,
                        data: this.editedItem
                    });
                    if (data.status) {
                        Object.assign(
                            this.dataList[this.editedIndex],
                            this.editedItem
                        );
                        this.snacks("Successfully Added", "green");
                        this.close();
                    } else {
                        this.snacks("Failed", "red");
                        this.loading = false;
                    }
                } catch (e) {
                    this.snacks("Failed", "red");
                    this.loading = false;
                }
            } else {
                try {
                    let { data } = await axios({
                        method: "post",
                        url: "/app/task",
                        data: this.editedItem
                    });
                    if (data.status) {
                        this.dataList.unshift(data.data);
                        this.snacks("Successfully Added", "green");
                        this.getMachine();
                        this.close();
                    } else {
                        this.snacks("Failed", "red");
                        this.loading = false;
                    }
                } catch (e) {
                    this.snacks("Failed", "red");
                    this.loading = false;
                }
            }
        },

        async remove() {
            try {
                let { data } = await axios({
                    method: "delete",
                    url: "/app/task/" + this.dataList[this.dataIndex].id
                });
                if (data.status) {
                    this.snacks("Successfully Done", "green");
                    this.dataList.splice(this.dataIndex, 1);
                    this.getMachine();
                    this.close();
                } else {
                    this.snacks(data.data, "red");
                    this.loading = false;
                }
            } catch (e) {
                this.snacks("Operation Failed", "red");
            }
        },
        async getDetail() {}
    }
};
</script>
<style>
.v-btn--contained {
    box-shadow: 0 0px 0px 0px rgba(255, 255, 255, 0),
        0 0px 0px 0 rgba(255, 253, 253, 0.14),
        0 0px 0px 0 rgba(255, 255, 255, 0.12);
}
.container {
    margin-top: -40px !important;
}
</style>
