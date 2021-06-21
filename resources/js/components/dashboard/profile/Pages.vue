<template>
    <v-content>
        <v-container fluid>
            <v-row justify="center">
                <v-col sm="12" md="12" lg="11">
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Pages List</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-simple-table>
                        <template v-slot:default>
                            <thead>
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Check</th>
                                    <th class="text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Production</td>
                                    <td>
                                        <v-switch
                                        color="red"
                                            inset
                                            dense
                                            light
                                            v-model="
                                                editedItem.production_overview
                                            "
                                        ></v-switch>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Manage Users</td>
                                    <td>
                                        <v-switch
                                         color="red"
                                            inset
                                            dense
                                            v-model="editedItem.manage_user"
                                            v-if="
                                                dataType.userType != 3 &&
                                                    dataType.userType != 2
                                            "
                                        ></v-switch>
                                    </td>
                                </tr>
                                <tr>
                                    <td>View or Add Jobs</td>
                                    <td>
                                        <v-switch
                                         color="red"
                                            inset
                                            dense
                                            v-model="
                                                editedItem.checklist_or_create
                                            "
                                        ></v-switch>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Document Database</td>
                                    <td>
                                        <v-switch
                                            inset
                                             color="red"
                                            dense
                                            v-model="
                                                editedItem.scan_or_document
                                            "
                                        ></v-switch>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Settings</td>
                                    <td>
                                        <v-switch
                                         color="red"
                                            inset
                                            dense
                                            v-model="editedItem.setting"
                                        ></v-switch>
                                    </td>
                                    <td>
                                        <v-btn
                                            color="#424242"
                                            dark
                                            @click="save()"
                                            >save</v-btn
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </v-col>
            </v-row>
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
export default {
    components: {},
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
        dataUser: {},
        dataType: {},
        editedItem: {
            production_overview: 0,
            manage_user: 0,
            checklist_or_create: 0,
            scan_or_document: 0,
            setting: 0,
            user_role: 0
        }
    }),
    props: {
        source: String
    },
    computed: {},
    watch: {},
    created() {
        this.initialize();
    },
    methods: {
        async initialize() {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/pages/" + this.$route.params.id
                });
                this.dataUser = data;
                this.editedItem.production_overview = this.dataUser.production_overview;
                this.editedItem.manage_user = this.dataUser.manage_user;
                this.editedItem.checklist_or_create = this.dataUser.checklist_or_create;
                this.editedItem.scan_or_document = this.dataUser.scan_or_document;
                this.editedItem.setting = this.dataUser.setting;
                this.editedItem.user_role = this.dataUser.user_role;
            } catch (e) {}

            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/getusertype/" + this.$route.params.id
                });
                this.dataType = data;
            } catch (e) {}
        },

        close() {
            this.dialog = false;
            setTimeout(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            }, 300);
        },
        async save() {
            try {
                this.editedItem.user_role = this.$route.params.id;
                this.loading = true;
                let { data } = await axios({
                    method: "post",
                    url: "/app/pages",
                    data: this.editedItem
                });
                if (data.status) {
                    this.snacks("Successfully Done", "green");
                    this.loading = false;
                } else {
                    this.snacks("Failed", "red");
                    this.loading = false;
                }
            } catch (e) {}
        }
    }
};
</script>
<style scoped>
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
