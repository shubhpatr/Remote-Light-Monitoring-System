<template>
    <div>
        <v-data-table
            mobile-breakpoint="3000px"
            :headers="headers"
            :items="datas"
            :search="search"
            :options="{ itemsPerPage: 1 }"
            hide-default-footer
            hide-default-header
            disable-sort
        >
            <template v-slot:item.a="{ item }">
                <v-chip :color="getColor(item.a)" small dark> </v-chip>
            </template>
            <template v-slot:item.b="{ item }">
                <v-chip :color="getColor(item.b)" dark small> </v-chip>
            </template>
            <template v-slot:item.c="{ item }">
                <v-chip :color="getColor1(item.c)" dark small> </v-chip>
            </template>
        </v-data-table>
        <!-- <datatable
            title="Basic table"
            :columns="tableColumns"
            :rows="tableRows1"
        /> -->
    </div>
</template>

<script>
import Vue from "vue";
import DataTable from "vue-materialize-datatable";



export default {
    props: {
        dataSensor: {},
        newData: {}
    },
    components: {
        datatable: DataTable
    },

    data: function() {
        return {
            myData: [],
            datas: [],

            temp: "Output current high fault/warning due to R phase",
            stat: { a: 0, b: 0, c: 0, lift_name: "" },
            search: "",
            status: [],
            status2: [],
            headers: [
                { text: "LED ON/OFF", value: "a" },
                { text: "CHARGING", value: "b" }
            ]
        };
    },

    watch: {
        newData() {
            this.myData = [];
            this.datas = [];
            this.stat = {};

            this.myData = this.newData.data;
            // this.status = this.myData.slice(-1)[0].led_status;
            // this.status1 = this.myData.slice(-1)[0].charging_status;
            // this.status = this.status.split(",");
            this.stat["lift_name"] = this.myData.slice(-1)[0].lift_name;

            if (this.myData.slice(-1)[0].led_status == 1) this.stat["a"] = 0;
            else this.stat["a"] = 1;

            if (this.myData.slice(-1)[0].charging_status == 1)
                this.stat["b"] = 0;
            else this.stat["b"] = 1;

            this.datas.push(this.stat);
            // for (var i = 0; i < this.status.length; i++) {
            //     if (this.status[i] == 1) {
            //         this.stat["a"] = 1;
            //     } else if (this.status[i] == "Mains OFF") {
            //         this.stat["b"] = 1;
            //     } else if (this.status[i] == "Mains ON") {
            //         this.stat["c"] = 1;
            //     }

            //     this.datas.push(this.stat);
            // }
        }
    },

    methods: {
        getColor(calories) {
            if (calories == 1) return "red";
            else return "green";
        },

        getColor1(calories) {
            if (calories == 1) return "green";
            else return "red";
        }
    }
};
</script>
<style scoped>
.v-card__text {
    width: 100%;
    display: flex;
}
.v-btn--contained {
    margin-left: 4pt;
    padding-left: 2px;
    margin-top: 1pt;
    border-radius: 4px;
    box-shadow: 0 0px 0px 0px rgba(255, 255, 255, 0),
        0 0px 0px 0 rgba(255, 253, 253, 0.14),
        0 0px 0px 0 rgba(255, 255, 255, 0.12);
}
</style>
