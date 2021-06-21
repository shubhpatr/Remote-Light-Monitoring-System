<template>
    <div style="margin-top:90px; margin-bottom:24px;">
        <v-container fluid style="margin-bottom:2rem; ">
            <!-- "isOn => (currentValue = isOn)" -->
            <v-row
                no-gutters
                style="margin-top: 20px; margin-bottom: 24px; display:flex; justify-content: space-evenly; align-items:center;"
            >
                <div style="font-size: 1rem; padding: 0 1rem">
                    <span style=" font-size:1.25rem;"> UID : </span>
                    <span style="font-weight: bold; font-size:1.5rem;">{{
                        this.pf
                    }}</span>
                </div>
                <div style="padding: 0 1rem">
                    <span style="font-size:1.25rem; ">
                        LIGHT NAME :
                    </span>
                    <span style="font-weight: bold; font-size:1.5rem;">
                        {{ this.liftname }}
                    </span>
                </div>
                <div style="padding: 0 1rem">
                    <span style="font-size:1.25rem;"> LIGHT LOCATION : </span>
                    <span style="font-weight: bold; font-size:1.5rem;">
                        {{ this.sitelocation }}</span
                    >
                </div>

                <div
                    style="font-size: 1rem; display:flex;align-items: baseline;padding: 0 1rem"
                >
                    <span style=" font-size:1.25rem;"> ON/OFF : </span>
                    <span style=" padding-left:1rem;">
                        <v-switch
                            inset
                            color="success"
                            v-model="currentValue"
                            @change="mqtt(currentValue)"
                        ></v-switch>
                    </span>
                    <!--
                         :label="`${currentValue.toString()}`"
                         <RockerSwitch
                        :size="0.9"
                        @change="
                            isOn => {
                                let dat = mqtt(isOn);
                                currentValue = isOn;
                            }
                        "
                    /> -->
                </div>

                <div>
                    <Lightbulb :isOn="currentValue" />
                </div>
            </v-row>

            <v-row no-gutters>
                <v-col
                    sm="12"
                    md="8"
                    lg="8"
                    style=" 
    border: solid;
    border-width: thin;
    border-color: #c0c0c0;
"
                >
                    <v-row
                        no-gutters
                        style=" 
    border-bottom: solid;
    border-width: thin;
    border-color: #c0c0c0;
"
                    >
                        <v-col lg="6" md="6" sm="6">
                            <v-card>
                                <v-card-title
                                    class=" justify-center"
                                    style="font-size: 1rem;"
                                >
                                    REALTIME PV VOLTAGE
                                </v-card-title>

                                <v-card-text style="">
                                    <LineChart
                                        :dataSensor="dataSensor"
                                        :newData="newData"
                                    />
                                </v-card-text>
                            </v-card>
                        </v-col>
                        <v-col lg="6" md="6" sm="6">
                            <v-card>
                                <v-card-title
                                    class=" justify-center"
                                    style="font-size: 1rem;"
                                >
                                    PV VOLTAGE
                                </v-card-title>

                                <v-card-text>
                                    <DonutChart
                                        width="400"
                                        height="300"
                                        :dataSensor="dataSensor"
                                        :newData="newData"
                                    />
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>

                    <v-row no-gutters>
                        <v-col lg="6" md="6" sm="6">
                            <v-card>
                                <v-card-title
                                    class=" justify-center"
                                    style="font-size: 1rem;"
                                >
                                    REALTIME BATTERY VOLTAGE
                                </v-card-title>

                                <v-card-text style="">
                                    <LineChart1
                                        :dataSensor="dataSensor"
                                        :newData="newData"
                                    />
                                </v-card-text>
                            </v-card>
                        </v-col>
                        <v-col lg="6" md="6" sm="6">
                            <v-card>
                                <v-card-title
                                    class=" justify-center"
                                    style="font-size: 1rem;"
                                >
                                    BATTERY VOLTAGE
                                </v-card-title>

                                <v-card-text>
                                    <DonutChart1
                                        :dataSensor="dataSensor"
                                        :newData="newData"
                                    />
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-col>

                <v-col
                    lg="4"
                    md="4"
                    sm="12"
                    style="border-top: solid; border-right: solid;   border-width: thin;   border-color: #c0c0c0;"
                >
                    <v-col sm="12">
                        <v-card>
                            <v-card-title
                                class=" justify-center"
                                style="font-size: 1rem; "
                            >
                                SYSTEM STATUS FLAGS
                            </v-card-title>

                            <Table
                                :dataSensor="dataSensor"
                                :newData="newData"
                            />
                        </v-card>
                    </v-col>

                    <v-col sm="12">
                        <v-card>
                            <v-card-title
                                class="justify-center"
                                style="font-size: 1rem; border-top: solid;  border-width: thin;   border-color: #c0c0c0;"
                            >
                                LOCATION ON MAP
                            </v-card-title>
                            <v-card-text>
                                <Map />
                            </v-card-text>

                            <!-- <img style="margin-top: 16rem;" src="/light.png" height = "500px" width = "450px"></img> -->
                        </v-card>
                    </v-col>
                </v-col>
            </v-row>

            <v-divider style="color:#c0c0c0;"></v-divider>
        </v-container>
    </div>
</template>

<script>
import LineChart from "./line/LineChart.vue";
import LineChart1 from "./line/LineChart1.vue";

import Map from "./Map.vue";

import DonutChart from "./donut/DonutChart";
import DonutChart1 from "./donut/DonutChart1";

import Vue from "vue";
import { DropDownButtonPlugin } from "@syncfusion/ej2-vue-splitbuttons";
import Table from "./table/Table.vue";

import ProgressBar from "vuejs-progress-bar";
Vue.use(ProgressBar);

import Lightbulb from "./Lightbulb";
import RockerSwitch from "vue-rocker-switch";
import "vue-rocker-switch/dist/vue-rocker-switch.css";

export default {
    components: {
        LineChart,
        LineChart1,

        DonutChart,
        DonutChart1,
        Map,
        RockerSwitch,
        Lightbulb,
        Table
    },
    data: () => ({
        dataMachine: [],
        dataMachineWeekly: [],
        dataMachineMonthly: [],
        myData: [],
        pf: [],
        color: [],
        sc: [],
        sdl: [],
        sitename: [],
        liftname: [],
        batv: [],
        dataUser: {}, //
        arrayOfObjects: [],
        currentValue: false,
        options: {
            text: {
                color: "#FFFFFF",
                shadowEnable: true,
                shadowColor: "#000000",
                fontSize: 16,
                fontFamily: "Helvetica",
                dynamicPosition: false,
                hideText: false
            },
            progress: {
                color: "green",
                backgroundColor: "#333333"
            },
            layout: {
                height: 40,
                width: 90,
                verticalTextAlign: 61,
                horizontalTextAlign: 30,
                zeroOffset: 0,
                strokeWidth: 30,
                progressPadding: 0,
                type: "battery"
            }
        },

        items: [],
        weeks: [
            { title: "Week 1" },
            { title: "Week 2" },
            { title: "Week 3" },
            { title: "Week 4" }
        ],
        views: [{ title: "Daily" }, { title: "Weekly" }, { title: "Monthly" }],
        closeOnClick: true,

        object: {
            name: "Machine"
        }
    }),
    props: {
        dataList: {},
        dataSensor: {},
        newData: {},
        newStatus: {},
        dataDay: Array
    },
    computed: {},
    watch: {
        dataDay() {
            if (this.dataDay) {
                this.getDaily(this.dataDay); //
            }
            this.Machinelist();
            var interval = setInterval(() => {
                if (this.dataDay) {
                    this.getLast(this.dataDay); //
                }
                this.Machinelist();
            }, 1000);
        },

        newData() {
            this.myData = [];
            // this.currentValue = false;
            this.myData = this.newData.data;
            this.pf = this.myData.slice(-1)[0].imei;
            this.sc = this.myData.slice(-1)[0].temp;
            // this.sdl = this.myData.slice(-1)[0].SDL;
            this.batv = this.myData.slice(-1)[0].batvp;

            if (this.myData.slice(-1)[0].led_status == 1)
                this.currentValue = true;
            else this.currentValue = false;

            this.batv = parseInt(((this.batv - 330) / 70) * 100);
            if (this.batv > 100) this.batv = 100;
            this.sitelocation = this.myData.slice(-1)[0].site_location;
            this.liftname = this.myData.slice(-1)[0].lift_name;
            this.color = this.getColor(this.batv);
            this.options.progress.color = this.color;
        }
    },
    mounted() {},
    created() {
        this.user_type_id = this.$store.state.authUser.userType;
        this.dataUser = this.$store.state.authUser;
        this.initialize();
    },
    methods: {
        async mqtt(val) {
            console.log("HI");
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/mqtt/" + this.$route.params.id + "/" + val
                });
                console.log(data);
                return data;
            } catch (e) {}
        },

        filter(data) {
            var arr = [];
            console.log(data.data.length);
            for (var i = 0; i < data.data.length; i++) {
                if (data.data[i].machine_id == this.$route.params.id) {
                    arr.push(data.data[i]);
                    console.log(data.data[i].machine_id);
                }
            }

            data.data = arr;
            return data;
        },

        getColor(color) {
            if (color <= 20) return "red";
            else return "red";
        },
        updateCountry(data, machine_id) {
            data.machine_id = machine_id;
        },
        Machinelist() {
            for (let i = 0; i < this.dataDay.length; i++) {
                this.items.push(this.dataDay[i].name);
            }
        },
        async initialize() {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/superadmindashboardoverview"
                });
                this.dataDay = data;
            } catch (e) {
                this.loading = false;
            }
        },

        methodToRunOnSelect(payload) {
            this.object = payload;
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

            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/status/" + item.is
                });
                this.newStatus = data;
                //end
            } catch (e) {}
        },

        async getDaily(item) {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/superadmingetmachinedaily/" + item.id
                });
                this.dataMachine = data;
            } catch (e) {}
            // start
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/sensor/" + this.$route.params.id
                });

                this.dataSensor = data;

                //end
            } catch (e) {}

            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/superadmingetmachineweekly/" + item.id
                });
                this.dataMachineWeekly = data;
            } catch (e) {}

            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/superadmingetmachinemonthly/" + item.id
                });
                this.dataMachineMonthly = data;
            } catch (e) {}
        }
    }
};
</script>

<style scoped>
.v-btn {
    justify-content: space-between;
    border-radius: 0px;
}
.theme--dark.v-card {
    background-color: #fbfbfb;
    color: #fbfbfb;
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

.v-card__title {
    word-break: break-word;
    justify-content: space-between;
    font-family: "Lato";
}
.admin {
    margin-bottom: 20px;
}
@media (max-width: 960px) {
    .totadmin {
        margin: 10px;
        display: flex;
    }
    .admin {
        margin-right: 20px;
        margin-bottom: 0px;
    }
}
</style>
