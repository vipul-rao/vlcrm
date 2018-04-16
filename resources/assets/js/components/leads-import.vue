<template>
    <div>
        <form class="form-horizontal" @submit.prevent="uploadFile">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                <input type="file" name="..." ref="fileInput">
                </span>
                <span class="fileinput-filename"></span>
                <a href="#" class="close fileinput-exists import-cat" data-dismiss="fileinput">&times;</a>
            </div>
            <br>
            <button class="btn btn-primary">Upload and Review</button>
            <a :href="downloadurl" class="btn btn-primary">Download Template</a>
        </form>
        <h5 v-if="total">Imported : {{ completed.length }} / {{ total }}</h5>
        <div class="table-responsive">
            <table class="table sales-team import-wrapper" v-if="total">
                <thead>
                    <tr>
                        <th>
                            <label class="md-check">
                                <input type="checkbox" v-model="selectedAll">
                                <i class="primary"></i>
                            </label>
                        </th>
                        <th>Opportunity</th>
                        <th>Names</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Mobile</th>
                        <th>Fax</th>
                        <th>Function</th>
                        <th>Company</th>
                        <th>Country</th>
                        <th>Sales Team</th>
                        <th>Notes</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data" :class="{'alert-info':item.created}">
                        <td>
                            <label class="md-check" v-if="!item.created">
                                <input type="checkbox" v-model="item.selected">
                                <i class="primary"></i>
                            </label>
                        </td>
                        <td>
                            {{ item.opportunity }}
                            <div class="errors alert alert-danger" v-if="item.errors">
                                <ul>
                                    <!-- <li>{{item.errors}}</li> -->
                                    <li v-for="key in item.errors">
                                        {{ key }}
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            {{ item.contact_name }}
                        </td>
                        <td>
                            {{ item.address }}
                        </td>
                        <td>
                            {{ item.email }}
                        </td>
                        <td>
                            {{ item.phone }}
                        </td>
                        <td>
                            {{ item.mobile }}
                        </td>
                        <td>
                            {{ item.fax }}
                        </td>
                        <td>
                            {{ item.function }}
                        </td>
                        <td>
                            {{ item.company_name }}
                        </td>
                        <td>
                            <select class="form-control import-width" name="country_id" v-model="item.country_id">
                                <option v-for="country in countries" :value="country.id">{{country.text}}</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control import-width" name="sales_team_id" v-model="item.sales_team_id">
                                <option v-for="salesteam in salesteams" :value="salesteam.id">{{salesteam.text}}</option>
                            </select>
                        </td>
                        <td>
                            {{ item.internal_notes }}
                        </td>
                        <td>
                            <button v-if="!item.created" class="btn btn-primary btn-xs" @click="createRecord(item)">Create</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a v-show="remaining.length > 0" :class="{ 'disabled': !selected.length }" href="" @click.prevent="createAll" class="btn btn-primary pull-right">Create Selected</a>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['url'],

    data: function() {
        return {
            data: [],
            staff: null,
            companies: [],
            countries: [],
            salesteam: [],
            selectedAll: false
        }
    },

    filters: {
        success: function(items) {
            return items.filter(function(item) {
                return item.created;
            });
        },

        rejected: function(items) {
            return items.filter(function(item) {
                return item.errors
            });
        }
    },

    computed: {
        actuallyUseableCountryList: function() {
            return this.countries.map(function(country) {
                var code = Object.keys(country)[0];
                return {
                    code: code,
                    name: country[code]
                }
            })
        },
        completed: function() {
            return this.data.filter(function(item) {
                return item.created;
            });
        },

        remaining: function() {
            return this.data.filter(function(item) {
                return !item.created;
            });
        },

        total: function() {
            return this.data.length;
        },

        selected: function() {
            return this.data.filter(function(item) {
                return item.selected;
            });
        },
        downloadurl: function() {
            return this.url + "download-template";
        }
    },

    methods: {
        init(res) {
            //Excel ROWS
            this.data = res.customers.map((item)=> {
                item.created = false;
                item.errors = false;
                item.selected = false;
                return item;
            });

            //Staff to be used for Dropdown
            this.companies = res.companies;

            //county data to be used
            this.countries = res.countries;

            //Sales team data to be used
            this.salesteams = res.salesteams;

            //Look for select all checkbox
            this.$watch('selectedAll', function(selected) {
                this.updateRowsSelection(selected);
            });

            this.selectedAll = false;
        },

        updateRowsSelection: function(status) {
            this.data.forEach((item)=> {
                item.selected = status;
            });
        },

        uploadFile: function() {

            var formData = new FormData();
            formData.append('file', this.$refs.fileInput.files[0]);

            axios.post(this.url + 'import', formData)
                .then(res => {
                    this.init(res.data);
                }).catch(err => {
                    alert(err.response.data);
                });
        },

        createRecord: function(item) {
            if (!item.created) {
                var vm = this;
                axios.post(this.url + 'ajax-store', item)
                    .then(function(response) {
                        item.created = true;
                        item.selected = false;
                        item.errors = null;
                        console.log(response);
                    })
                    .catch(function(error) {
                        console.log(error);
                        item.errors = error.response.data;
                    });
            }
        },

        createAll: function() {
            this.selected.forEach(function(item) {
                this.createRecord(item);
            }.bind(this));
        }
    }
}
</script>
