

<script>
import { Line } from 'vue-chartjs'

export default {
    extends: Line,
    props:['data','options'],
    mounted() {
        this.renderLineChart();
    },
    computed: {
        chartData: function() {
            return this.data;
        }
    },
    methods: {
        renderLineChart: function() {
            this.renderChart(this.chartData, this.options)
        }
    },
    watch: {
        data: function() {
             if (this.$data._chart) {
                this.$data._chart.destroy();
            }
            //this._chart.destroy();
            //console.log(this.data);
            //console.log(this.options);
            //this.renderChart(this.data, this.options);
            this.renderLineChart();
        }
    }
}

</script>
