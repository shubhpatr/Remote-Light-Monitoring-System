<template>
    <div>
        <canvas ref="myChart" width="250" height="200"></canvas>
    </div>
</template>

<script>
import { Bar, Line } from "vue-chartjs";
import Chart from "chart.js";

export default {
    props: {
        dataSensor: {},
        newData: {}
    },
    data() {
        return {
            myData: [],
            myData1: [],
            machine_id: [],
            batv1: [],
            time: []
        };
    },
    watch: {
        dataSensor() {
            this.myData = [];
            this.getData = [];
            this.machine_id = [];
            this.batv1 = [];
            this.time = [];

            this.myData = this.dataSensor.data;

            if (this.myData) {
                for (let p of this.myData) {
                    this.machine_id.push(p.machine_id);
                    this.batv1.push(p.batv1);
                    this.time.push(p.updated_at.slice(11, 19));
                }

                // for (let p of this.myData) {
                //     this.machine_id.push(p.machine_id);
                //     this.RIV.push(p.RIV);
                //     this.batv1.push(p.batv1);
                // }
            }

            // if (this.getData) {
            //      for (let p of this.getData) {

            //          this.RIV1.push(p.RIV);
            //      }
            //  }

            if (window.Linechart1 != undefined) window.Linechart1.destroy();
            window.Linechart1 = new Chart(this.$refs.myChart, {
                type: "line",
                data: {
                    labels: this.time.slice(15),
                    datasets: [
                        {
                            label: "voltage",
                            data: this.batv1.slice(15),
                            fill: false,
                            lineTension: 0.3,
                            backgroundColor: "#ffcc00",
                            borderColor: "#ffcc00",
                            borderCapStyle: "butt",
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: "miter",
                            pointBorderColor: "#000000",
                            pointBackgroundColor: "#000000",
                            pointBorderWidth: 0.3,
                            pointHoverRadius: 5,
                            pointHitRadius: 5,
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    legend: { display: false },
                    responsive: true,
                    lineTension: 1,
                    title: {
                        display: false,
                        fontColor: "#000000",
                        fontSize: 18,
                        fontStyle: "normal",
                        text: "REAL TIME MACHINE OEE"
                    },

                    scales: {
                        yAxes: [
                            {
                                gridLines: {},
                                minorTickInterval: null,
                                ticks: {
                                    beginAtZero: true,
                                    max: 500
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: "Voltage (V)"
                                }
                            }
                        ],
                        xAxes: [
                            {
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    beginAtZero: true
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: "Time"
                                }
                            }
                        ]
                    }
                }
            });

            var interval = setInterval(() => {
                if (
                    this.dataSensor.data.slice(-1)[0].batv1 !=
                    this.newData.data.slice(-1)[0].batv1
                ) {
                    Linechart1.data.labels.push(
                        this.newData.data.slice(-1)[0].updated_at.slice(11, 19)
                    );
                    Linechart1.data.datasets[0].data.push(
                        this.newData.data.slice(-1)[0].batv1
                    );
                    Linechart1.data.datasets[0].data.shift();
                    Linechart1.data.labels.shift();
                    Linechart1.update();
                    this.dataSensor.data.slice(
                        -1
                    )[0].batv1 = this.newData.data.slice(-1)[0].batv1;
                }
            }, 2000);
            // var interval = setInterval(() => {
            //     if(this.dataSensor.data[0].RIV != this.newData.data[0].RIV)
            //     {
            //     Linechart.data.datasets[0].data.push(this.newData.data[0].RIV);
            //     Linechart.update();
            //     this.dataSensor.data[0].RIV = this.newData.data[0].RIV;
            //      }}
            // , 1000);
        }
    },
    mounted() {},

    created() {},

    method: {}
};
</script>
