<template>
<div>
    <canvas  ref="myChart">
    
    </canvas>
</div>
    
</template>

<script>
import { Doughnut } from "vue-chartjs";
import Chart from "chart.js";

export default {
    props: {
        dataSensor: {},
        newData: {}
    },
    data() {
        return {
            myData: [],
            quant1: [],
            voltage: [],
            volt: [],
            machine_id: []
        };
    },
    watch: {
        dataSensor() {
            this.myData = [];
            this.machine_id = ["Voltage", "Voltage"];
            this.quant1 = [81, 19];

            this.myData = this.dataSensor.data;
            if (this.myData) {
                for (let p of this.myData) {
                    this.machine_id.push(p.machine_id);
                    this.voltage.push(p.batv);
                }
            }
            
            this.volt = [this.voltage[19], 450 - this.voltage[19]]  
            if (window.DonutChart1 != undefined) window.DonutChart1.destroy();
            window.DonutChart1 = new Chart(this.$refs.myChart, {
                type: "doughnut",
                data: {
                    labels: this.machine_id,
                    datasets: [
                        {
                            // label: "Population (millions)",
                            backgroundColor: this.color(this.volt), //Green
                            hoverBackgroundColor: this.hovercolor(this.volt),
                            data: this.volt
                        }
                    ]
                },
                options: {
                    elements: {
                        center: {
                            text: this.voltage[19] + "V",
                            // color: "#D91F0B", // Default is #000000
                            fontStyle: "Arial", // Default is Arial
                            sidePadding: 5, // Default is 20 (as a percentage)
                            minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
                            lineHeight: 25 // Default is 25 (in px), used for when text wraps
                        }
                    },
                    legend: { display: false },
                    cutoutPercentage: 80,
                    title: {
                        display: false,
                        fontColor: "#000000",
                        fontSize: 36,
                        fontStyle: "normal",
                        text: "Voltage"
                    }
                }
            }),
                Chart.pluginService.register({
                    beforeDraw: function(chart) {
                        if (chart.config.options.elements.center) {
                            //Get ctx from string
                            var ctx = chart.chart.ctx;

                            //Get options from the center object in options
                            var centerConfig =
                                chart.config.options.elements.center;
                            var fontStyle = centerConfig.fontStyle || "Arial";
                            var txt = centerConfig.text;
                            var color = centerConfig.color || "#000";
                            var sidePadding = centerConfig.sidePadding || 20;
                            var sidePaddingCalculated =
                                (sidePadding / 100) * (chart.innerRadius * 2);
                            //Start with a base font of 30px
                            ctx.font = "45px " + fontStyle;

                            //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
                            var stringWidth = ctx.measureText(txt).width;
                            var elementWidth =
                                chart.innerRadius * 2 - sidePaddingCalculated;

                            // Find out how much the font can grow in width.
                            var widthRatio = elementWidth / stringWidth;
                            var newFontSize = Math.floor(30 * widthRatio);
                            var elementHeight = chart.innerRadius * 2;

                            // Pick a new font size so it will not be larger than the height of label.
                            var fontSizeToUse = Math.min(
                                newFontSize,
                                elementHeight
                            );

                            //Set font settings to draw it correctly.
                            ctx.textAlign = "center";
                            ctx.textBaseline = "middle";
                            var centerX =
                                (chart.chartArea.left + chart.chartArea.right) /
                                2;
                            var centerY =
                                (chart.chartArea.top + chart.chartArea.bottom) /
                                2;
                            ctx.font = fontSizeToUse + "px " + fontStyle;
                            ctx.fillStyle = color;

                            //Draw text in center
                            ctx.fillText(txt, centerX, centerY);
                        }
                    }
                });

        var interval = setInterval(() => {
                if(this.dataSensor.data.slice(-1)[0].batv != this.newData.data.slice(-1)[0].batv)
                {
                this.volt = [ this.newData.data.slice(-1)[0].batv , 450 - this.newData.data.slice(-1)[0].batv]
                DonutChart1.data.datasets[0].data = this.volt;
                DonutChart1.options.elements.center.text = this.volt[0]+"V";
                DonutChart1.data.datasets[0].backgroundColor=this.color(this.volt) ;
                DonutChart1.data.datasets[0].hoverBackgroundColor=this.hovercolor(this.volt);
                DonutChart1.update();
                this.dataSensor.data[19].batv = this.newData.data[19].batv;
                 }}
            , 1000); 
        }

        
    },
    mounted() {},

    created() {},

    methods: {
       color(volt) {
            if (volt[0] <= 165) {
                return ["#ffcc00", "#f5f5f5"];
                
            } else if (volt[0] > 165 && volt[0] < 280) {
                return ["#45DF71", "#f5f5f5"];
            } else {
                return ["#cc0000", "#f5f5f5"];
            }
        },
        hovercolor(volt) {
            if (volt[0] <= 165) {
                return ["#FFDD57", "#f5f5f5"];
                
            } else if (volt[0] > 165 && volt[0] < 280) {
                return ["#6EFF97", "#f5f5f5"];
            } else {
                return ["#FF3535", "#f5f5f5"];
            }
        }
    }
};
</script>
