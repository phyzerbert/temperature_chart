<template>
    <div class="card">
        <div class="card-header">
            Overall Temperature Statistics
        </div>
        <div class="card-body">
            <div class="row filter mb-3">
                <div class="col-md-3 mt-2">
                    <date-range-picker
                        ref="daterangepicker"
                        :opens="'right'"
                        :showWeekNumbers="false"
                        :showDropdowns="false"
                        :autoApply="false"
                        v-model="dateRange"
                        :linkedCalendars = "true"
                    >
                    </date-range-picker>
                </div>
                <div class="col-md-5 mt-2">
                    <div>
                        <multiselect 
                            v-model="selected_employee" 
                            :options="employees"  
                            placeholder="Select Employee"
                            selectLabel=""
                            selectedLabel=""
                            deselectLabel=""
                            label="name" 
                            track-by="name"
                        ></multiselect>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <chart-temperature :dateRange="dateRange" :employee="selected_employee"></chart-temperature>
            </div>
        </div>
    </div>
</template>

<script>
    import DateRangePicker from 'vue2-daterange-picker';
    import 'vue2-daterange-picker/dist/vue2-daterange-picker.css';
    import Multiselect from 'vue-multiselect'
    export default {
        name: 'Homepage',
        components: { DateRangePicker, Multiselect },
        props: ['start_date', 'end_date', 'employee'],
        data(){
            return {
                selected_employee: this.employee,
                employees: [],
                dateRange: {
                    startDate: this.start_date,
                    endDate: this.end_date
                },
            };
        },
        mounted(){
            this.getEmployees();
        },
        methods: {
            getEmployees() {
                axios.get('/employee/get_all').then((response) => {
                    if(response.data.status == 200) {
                        this.employees = response.data.data;
                        this.selected_employee = response.data.data[0];
                    }
                });
            },
        },
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>