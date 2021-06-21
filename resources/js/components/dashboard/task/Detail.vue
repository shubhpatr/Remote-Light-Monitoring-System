<template>
    <div style="margin-top:72px ; margin-left:24px; margin-right:20px;">
        <v-card flat>
            <v-toolbar flat color="white">
                <v-toolbar-title>INSTALLED LIGHTS</v-toolbar-title>
                <v-divider class="mx-2" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <v-dialog v-model="dialog" max-width="600px">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            dark
                            color="darkorange"
                            class="mb-2"
                            v-bind="attrs"
                            v-on="on"
                        >
                            Add New Light
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text
                            style="margin-top:16px;margin-bottom:-8px;"
                        >
                            <v-row>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        v-model="editedItem.liftname"
                                        label="Light Name"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        v-model="editedItem.liftuid"
                                        label="UID"
                                        hint="Should match exactly with the device UID"
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        v-model="editedItem.liftlocation"
                                        label="Installed Location"
                                    ></v-text-field>
                                </v-col>

                                <v-col
                                    cols="12"
                                    sm="6"
                                    md="6"
                                    style="   align-content: center;   display: flex;   justify-content: center;"
                                >
                                    <GmapAutocomplete
                                        @place_changed="setPlace"
                                        style="    width: 100%;    height: 70%;"
                                    >
                                    </GmapAutocomplete>
                                </v-col>
                            </v-row>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="red darken-1" text @click="close">
                                Cancel
                            </v-btn>
                            <v-btn color="green darken-1" text @click="save">
                                Save
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
            <v-card-text style="padding:0px">
                <v-data-table
                    :headers="headers"
                    :items="dataLifts"
                    :search="search"
                    sort-by="calories"
                    class="elevation-0"
                >
                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search"
                                single-line
                                hide-details
                                style="    width: 100%;"
                            ></v-text-field>

                            <v-spacer></v-spacer>

                            <v-dialog v-model="dialogDelete" max-width="500px">
                                <v-card>
                                    <v-card-title class="headline"
                                        >Are you sure you want to delete this
                                        item?</v-card-title
                                    >
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            color="green darken-1"
                                            text
                                            @click="deleteItemConfirm"
                                            >YES</v-btn
                                        >
                                        <v-btn
                                            color="red darken-1"
                                            text
                                            @click="closeDelete"
                                            >NO</v-btn
                                        >

                                        <v-spacer></v-spacer>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    v-bind="attrs"
                                    v-on="on"
                                    class="mr-2"
                                    @click="editItem(item)"
                                >
                                    mdi-pencil
                                </v-icon>
                            </template>
                            <span>Edit</span>
                        </v-tooltip>

                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    v-bind="attrs"
                                    v-on="on"
                                    class="mr-2"
                                    @click="handleClick(item)"
                                >
                                    mdi-eye
                                </v-icon>
                            </template>
                            <span>View</span>
                        </v-tooltip>

                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    v-bind="attrs"
                                    v-on="on"
                                    color="red"
                                    @click="deleteItem(item)"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>

                    <template v-slot:item.led_status="{ item }">
                        <v-chip :color="getColor(item.led_status)" small dark>
                        </v-chip>
                    </template>

                    <template v-slot:no-data>
                        <v-btn
                            dark
                            color="#424242"
                            style="border-radius:0px;"
                            @click="initialize"
                        >
                            Reset
                        </v-btn>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
    </div>
</template>
<script>
export default {
    data: () => ({
        dialog: false,
        search: "",
        dataLifts: [],
        dialogDelete: false,
        headers: [
            { text: "UID", value: "liftuid" },
            {
                text: "Light Name",
                value: "liftname"
            },

            { text: "Installed Location", value: "liftlocation" },
            { text: "Status (On/Off)", value: "led_status", align: "center" },
            {
                text: "Actions",
                value: "actions",
                align: "center",
                sortable: false
            }
        ],
        place: null,
        desserts: [],
        editedIndex: -1,
        editedItem: {
            liftname: "",
            liftlocation: "",
            liftuid: "",
            lat: "",
            lng: ""
        },
        defaultItem: {
            liftname: "",
            liftlocation: "",
            liftuid: "",
            lat: "",
            lng: ""
        }
    }),
    props: {
        newData: {}
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "New Light" : "Edit Light";
        }
    },

    watch: {
        dialog(val) {
            val || this.close();
        },
        dialogDelete(val) {
            val || this.closeDelete();
        }
    },

    created() {
        this.initialize();
    },

    methods: {
        async initialize() {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/taskmachine/" + this.$route.params.id
                });
                this.dataLifts = data;
                console.log(this.dataLifts);
            } catch (e) {
                this.fail();
            }
        },
        async getLast(item) {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/sensor/" + this.$route.params.id
                });
                this.newData = data;

                //end
            } catch (e) {}
        },
        getColor(value) {
            if (value == 1) return "green";
            else return "red";
        },

        handleClick(item) {
            // window.location.replace(
            //     "/dashboard/task/liftdashboard/" + item.liftuid
            // );
            this.$router.push("/dashboard/task/liftdashboard/" + item.liftuid);
        },

        setPlace(place) {
            this.place = place;
            this.editedItem.lat = place.geometry.location.lat();
            this.editedItem.lng = place.geometry.location.lng();
            this.editedItem.liftlocation = place.name;
            console.log(place.geometry.location.lat());
            console.log(place);
            console.log(this.editedItem);
        },

        editItem(item) {
            this.editedIndex = this.dataLifts.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            this.editedIndex = this.dataLifts.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },

        deleteItemConfirm() {
            this.remove();
            this.closeDelete();
        },

        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        closeDelete() {
            this.dialogDelete = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        async remove() {
            let index = this.editedIndex;
            try {
                let { data } = await axios({
                    method: "delete",
                    url: "/app/task/" + this.dataLifts[this.editedIndex].id
                });

                if (data.status) {
                    this.snacks("Successfully Done", "green");
                    this.dataLifts.splice(index, 1);
                    this.close();
                } else {
                    this.snacks(data.data, "red");
                }
            } catch (e) {
                this.snacks("Operation Failed", "red");
            }
        },

        async save() {
            console.log(this.editedIndex);
            console.log(this.editedItem);
            if (this.editedIndex > -1) {
                try {
                    console.log(this.editedItem);
                    let { data } = await axios({
                        method: "put",
                        url: "/app/task/" + this.dataLifts[this.editedIndex].id,
                        data: this.editedItem
                    });
                    if (data.status) {
                        this.snacks("Successfully Done", "green");
                        Object.assign(
                            this.dataLifts[this.editedIndex],
                            data.data
                        );
                        this.close();
                    } else {
                        this.snacks("Failed", "red");
                    }
                } catch (e) {
                    this.snacks("Operation Failed", "red");
                }
            } else {
                try {
                    this.editedItem.machine_id = this.$route.params.id;
                    let { data } = await axios({
                        method: "post",
                        url: "/app/task",
                        data: this.editedItem
                    });
                    if (data.status) {
                        this.snacks("Successfully Done", "green");
                        this.dataLifts.push(data.data);
                        this.close();
                    } else {
                        this.snacks("Failed", "red");
                    }
                } catch (e) {
                    this.snacks("Operation Failed", "red");
                }
            }
            this.close();
        }
    }
};
</script>

<style scoped>
.theme--dark.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
    background-color: darkorange;
}
/* .table.v-table tbody td {
    font-size: 18px !important;
} */
.v-data-table > .v-data-table__wrapper > table > tbody > tr > th,
.v-data-table > .v-data-table__wrapper > table > thead > tr > th,
.v-data-table > .v-data-table__wrapper > table > tfoot > tr > th {
    font-size: 20px !important;
}
.theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr > th {
    color: rgb(255 0 0 / 60%) !important;
}
</style>
