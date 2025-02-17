<template>
    <v-content>
        <v-container fluid>
            <v-overlay :value="showFullLoading" :absolute="absolute">
                <v-progress-circular
                    indeterminate
                    size="64"
                ></v-progress-circular>
            </v-overlay>
            <v-row justify="center">
                <v-col sm="12" md="12" lg="11">
                    <v-toolbar flat color="white">
                        <v-toolbar-title>CLIENT LIST</v-toolbar-title>
                        <v-divider class="mx-2" inset vertical></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="500px">
                            <v-card>
                                <v-card-title>
                                    <span class="headline">{{
                                        formTitle
                                    }}</span>
                                </v-card-title>

                                <v-card-text style="margin-top:4rem;">
                                    <v-container grid-list-md>
                                        <v-layout wrap>
                                            <v-flex xs12 sm12s md12>
                                                <v-text-field
                                                    v-model="
                                                        editedItem.password
                                                    "
                                                    :rules="passwordRules"
                                                    label="Password"
                                                    type="text"
                                                    filled
                                                ></v-text-field>
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
                                        text
                                        @click="save"
                                        :loading="loading"
                                        :disabled="loading"
                                        >Save</v-btn
                                    >
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-toolbar>
                    <v-card flat>
                        <v-card-text>
                            <v-data-table :headers="headers" :items="dataUser">
                                <template v-slot:item.userType="{ item }">
                                    <p v-if="item.userType == 2">Client</p>
                                    <!-- <p v-if="item.userType == 3">Machine</p> -->
                                </template>
                                <template v-slot:item.action="{ item }">
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                            <v-icon
                                                @click="editItem(item)"
                                                v-on="on"
                                                >edit</v-icon
                                            >
                                        </template>
                                        <span>Edit Password</span>
                                    </v-tooltip>
                                </template>
                                <template v-slot:no-data>
                                    <v-skeleton-loader
                                        type="table-tbody"
                                    ></v-skeleton-loader>
                                    <v-btn color="primary" @click="initialize"
                                        >Reset</v-btn
                                    >
                                </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-snackbar
            v-model="snackbar"
            :bottom="y === 'bottom'"
            :left="x === 'left'"
            :multi-line="mode === 'multi-line'"
            :right="x === 'right'"
            :timeout="timeout"
            :top="y === 'top'"
            :vertical="mode === 'vertical'"
        >
            {{ text }}
            <v-btn color="pink" flat @click="snackbar = false">Close</v-btn>
        </v-snackbar>
    </v-content>
</template>

<script>
export default {
    data: () => ({
        absolute: true,
        loading: false,
        snackbar: false,
        y: "top",
        x: null,
        mode: "",
        timeout: 6000,
        text: "Hello, I'm a snackbar",
        edit: true,
        dialog: false,
        dataUser: [],
        userType: [],
        headers: [
            { text: "ID", align: "left", value: "id" },
            {
                text: "Name",
                value: "name"
            },
            { text: "User Name", value: "email" },
            { text: "Type", value: "userType" },
            { text: "Action", value: "action" }
        ],
        emailRules: [
            v => !!v || "E-mail is required",
            v => /.+@.+/.test(v) || "E-mail must be valid"
        ],
        usernameRules: [
            v => !!v || "Name is required",
            v => (v || "").indexOf(" ") < 0 || "No spaces are allowed"
        ],
        passwordRules: [
            v => (v || "").length >= 8 || `A minimum of 8 characters is allowed`
        ],
        editedIndex: -1,
        editedItem: {
            name: "",
            email: "",
            username: "",
            userType: "",
            role: "",
            contact: ""
        },
        defaultItem: {
            name: "",
            email: "",
            username: "",
            user_type_id: "",
            role: "",
            contact: ""
        },
        userTypeList: [
            { text: "Client", value: 2 }
            // { text: "Machine", value: 3 }
        ]
    }),
    props: {
        source: String
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "New Item" : "Edit Password";
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
                    url: "/app/user"
                });
                this.dataUser = data;
            } catch (e) {}
        },
        editItem(item) {
            this.edit = false;
            this.editedIndex = this.dataUser.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.editedItem.password = Math.random()
                .toString(36)
                .slice(-10);
            this.dialog = true;
        },
        deleteItem(item) {
            const index = this.dataUser.indexOf(item);
            confirm("Are you sure you want to delete this item?") &&
                this.dataUser.splice(index, 1);
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
                        method: "post",
                        url: "/app/updatepassword",
                        data: this.editedItem
                    });
                    this.dataUser[this.editedIndex].status = 3;
                    this.close();
                } catch (e) {
                    this.loading = false;
                }
            } else {
                try {
                    let { data } = await axios({
                        method: "post",
                        url: "/app/user",
                        data: this.editedItem
                    });
                    this.dataUser.unshift(this.editedItem);
                    this.close();
                } catch (e) {
                    this.loading = false;
                }
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
