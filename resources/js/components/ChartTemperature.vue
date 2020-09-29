<script>
    import { Line } from 'vue-chartjs'
    export default {
        extends: Line,
        props: ['dateRange', 'user'],
        data(){
            return {
                start_date: '2020-09-01',
                end_date: '2020-12-31',
                labels: [],
                temperature_data: [],
                chart_options: {
                    legend: {
                        display: false
                    },
                    responsive: true, 
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 35,
                                max: 38,
                                stepSize: 0.1,
                                reverse: false,
                                beginAtZero: true
                            }
                        }]
                    }
                },
            };
        },
        watch: {
            user(newUser, oldUser) {
                this.showChart();
            },
            dateRange : {
                handler : function(params) {
                    this.showChart();
                },
                deep : true,
            }
        },
        mounted () {
            this.showChart();
        },
        methods: {
            showChart(){
                let uri = '/get_chart_data';
                let start_date = new Date(this.dateRange.startDate).toISOString().slice(0,10);
                let end_date = new Date(this.dateRange.endDate).toISOString().slice(0,10);
                let params = {
                    start_date: start_date,
                    end_date: end_date,
                    user_id: this.user.id,
                }
                axios.post(uri, params).then((response) => {
                    this.labels = response.data.labels;
                    this.temperature_data = response.data.temperature_data;
                    this.renderChart(
                        {
                            labels: this.labels,
                            datasets: [
                                {
                                    borderColor: '#1b9e77',
                                    data: this.temperature_data
                                }
                            ]
                        }, 
                        this.chart_options
                    );
                });
            },
        }
    }
</script>
