<template>
    <div class="card">
        <div class="card-header">
            Overall Temperature Statistics
        </div>
        <div class="card-body">
            <div class="row filter mb-3">
                <div class="col-lg-3 mt-2">
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
                <div class="col-lg-5 mt-2" v-show="auth_user.role != 'user'">
                    <div>
                        <multiselect 
                            v-model="selected_user" 
                            :options="users"  
                            placeholder="Select Employee"
                            selectLabel=""
                            selectedLabel=""
                            deselectLabel=""
                            label="employee_id" 
                            track-by="employee_id"
                        ></multiselect>
                            <!-- :custom-label="nameWithId" -->
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <chart-temperature :dateRange="dateRange" :user="selected_user"></chart-temperature>
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
        props: ['start_date', 'end_date', 'user'],
        data(){
            return {
                selected_user: this.user,
                users: [],
                dateRange: {
                    startDate: this.start_date,
                    endDate: this.end_date
                },
                auth_user: window.auth_user,
            };
        },
        mounted(){
            this.getEmployees();
        },
        methods: {
            getEmployees() {
                axios.get('/user/get_all').then((response) => {
                    if(response.data.status == 200) {
                        this.users = response.data.data;
                        this.selected_user = response.data.data[0];
                    }
                });
            },
            nameWithId ({ name, employee_id }) {
                return `${name} [${employee_id}]`;
            }
        },
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>