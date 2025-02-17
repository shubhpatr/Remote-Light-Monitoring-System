<template>
    <v-content>
        <v-container fluid>
            <v-row justify="center">
                <v-col sm="12" md="12" lg="11">
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Machine List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="500px">
                            <template v-slot:activator="{ on }">
                                <v-btn
                                    color="#424242"
                                    dark
                                    class="mb-2"
                                    v-on="on"
                                    @click="edit = true"
                                    >Assign Machine</v-btn
                                >
                            </template>
                            <v-card>
                                <v-card-title>
                                    <span class="headline">{{
                                        formTitle
                                    }}</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-layout wrap>
                                            <v-flex xs12 sm12 md12>
                                                <v-select
                                                    v-model="
                                                        editedItem.admin_id
                                                    "
                                                    :items="dataAdmin"
                                                    item-text="name"
                                                    item-value="id"
                                                    :rules="[
                                                        v =>
                                                            !!v ||
                                                            'Admin is required'
                                                    ]"
                                                    label="Admin"
                                                    required
                                                    filled
                                                ></v-select>
                                            </v-flex>
                                            <v-flex xs12 sm12 md12>
                                                <v-select
                                                    v-model="
                                                        editedItem.machine_id
                                                    "
                                                    :items="dataMachine"
                                                    item-text="name"
                                                    item-value="id"
                                                    :rules="[
                                                        v =>
                                                            !!v ||
                                                            'Machine is required'
                                                    ]"
                                                    label="Machine"
                                                    filled
                                                    chips
                                                ></v-select>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="red darken-1"
                                        text
                                        @click="close"
                                        >Cancel</v-btn
                                    >
                                    <v-btn
                                        color="#424242"
                                        :loading="loading"
                                        :disabled="loading"
                                        text
                                        @click="save"
                                        >Save</v-btn
                                    >
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>

                    <v-card flat>
                        <v-card-text>
                            <v-data-table :headers="headers" :items="dataList">
                                <template v-slot:item.admin_id="{ item }">
                                    <v-chip
                                        color="#fffff"
                                        small
                                        outlined
                                        label
                                        v-for="(data, index) in item.admin"
                                        :key="index"
                                    >
                                        <v-avatar left>
                                            <v-icon>mdi-account-circle</v-icon>
                                        </v-avatar>
                                        {{ data.admin.name }}
                                        <!-- <v-icon right
                                    >mdi-account-outline</v-icon
                                > -->
                                    </v-chip>
                                </template>
                                <template v-slot:item.action="{ item }">
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                            <v-icon
                                                color="red
                                                "
                                                @click="deleteItem(item)"
                                                v-on="on"
                                                >delete</v-icon
                                            >
                                        </template>
                                        <span>Delete</span>
                                    </v-tooltip>
                                </template>
                                <template v-slot:no-data>
                                    <v-skeleton-loader
                                        type="table-tbody"
                                    ></v-skeleton-loader>
                                    <v-btn
                                        color="#424242"
                                        dark
                                        @click="initialize"
                                        >Reset</v-btn
                                    >
                                </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <DeleteModal
                :trigger="isDelete"
                :title="deleteTitle"
                :body="deleteBody"
                @request="remove"
            ></DeleteModal>
        </v-container>
        <v-snackbar
            v-model="snackbar"
            :vertical="snackvertical"
            :timeout="snacktimeout"
            :top="snacktop"
            :color="snackcolor"
        >
            {{ snacktext }}
            <v-btn color="white" text @click="snackbar = false">
                Close
            </v-btn>
        </v-snackbar>
    </v-content>
</template>

<script>
import DeleteModal from "./../common/DeleteModal";
export default {
    components: {
        DeleteModal
    },
    data: () => ({
        loading: false,
        snackbar: false,
        dataIndex: null,
        deleteTitle: "",
        deleteBody: "",
        isDelete: false,
        edit: true,
        dialog: false,
        mode: "",
        timeout: 6000,
        text: "Hello, I'm a snackbar",
        dialog: false,
        dataAdmin: [],
        dataMachine: [],
        dataList: [],
        headers: [
            { text: "ID", align: "left", value: "id" },
            { text: "Machine", value: "name" },
            { text: "Admin", value: "admin_id" },
            { text: "Action", value: "action" }
        ],
        editedIndex: -1,
        editedItem: {
            admin_id: "",
            machine_id: ""
        },

        defaultItem: {
            admin_id: "",
            machine_id: ""
        }
    }),
    props: {
        source: String
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "Assign Machine" : "Edit Machine";
        }
    },
    watch: {},
    created() {
        this.initialize();
    },
    methods: {
        async initialize() {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/getunsigadmin"
                });
                this.dataAdmin = data;
            } catch (e) {}
            this.getUnsignMachine();
            this.getAdminMachine();
        },

        async getUnsignMachine() {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/getunsignmachine"
                });
                this.dataMachine = data;
            } catch (e) {}
        },
        async getAdminMachine() {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/machine"
                });
                this.dataList = data;
            } catch (e) {}
        },

        deleteItem(item) {
            this.dataIndex = this.dataList.indexOf(item);
            this.deleteTitle = "Are you sure you want to delete this item?";
            this.isDelete = !this.isDelete;
        },
        close() {
            this.dialog = false;
            setTimeout(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            }, 300);
        },
        async save() {
            if (this.editedIndex > -1) {
                try {
                    this.loading = true;

                    let { data } = await axios({
                        method: "put",
                        url:
                            "/app/machine/" +
                            this.dataAdmin[this.editedIndex].id,
                        data: this.editedItem
                    });
                    if (data.status) {
                        this.snacks("Successfully Done", "green");
                        Object.assign(
                            this.dataAdmin[this.editedIndex],
                            this.editedItem
                        );
                        this.loading = false;
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
                    this.loading = true;
                    let { data } = await axios({
                        method: "post",
                        url: "/app/machine",
                        data: this.editedItem
                    });
                    if (data.status) {
                        this.snacks("Successfully Done", "green");
                        this.getAdminMachine();
                        this.getUnsignMachine();
                        this.loading = false;
                        this.close();
                    } else {
                        this.snacks("Failed", "red");
                        this.loading = false;
                    }
                } catch (e) {}
            }
        },
        async remove() {
            try {
                let { data } = await axios({
                    method: "delete",
                    url: "/app/machine/" + this.dataList[this.dataIndex].id
                });
                if (data.status) {
                    this.snacks("Successfully Done", "green");
                    this.dataList.splice(this.dataIndex, 1);
                    this.getUnsignMachine();
                    this.close();
                } else {
                    this.snacks(data.data, "red");
                    this.loading = false;
                }
            } catch (e) {
                this.snacks("Operation Failed", "red");
                this.loading = false;
            }
        }
    }
};
</script>
<style scoped>
.v-btn {
    border-radius: 0px;
}
.v-btn--contained {
    box-shadow: 0 0px 0px 0px rgba(255, 255, 255, 0),
        0 0px 0px 0 rgba(255, 253, 253, 0.14),
        0 0px 0px 0 rgba(255, 255, 255, 0.12);
}
.v-sheet.v-card {
    border-radius: 0px;
    box-shadow: 0 3px 1px -2px rgba(255, 255, 255, 0.2),
        0 2px 2px 0 rgba(255, 255, 255, 0.14),
        0 1px 5px 0 rgba(255, 255, 255, 0.12);
}
</style>
