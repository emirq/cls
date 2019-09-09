<template>
    <div>
        <h1>Client Edit</h1>

        <form @submit.prevent="editClient" class="mb-3">

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Name" v-model="client.name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Address" v-model="client.address">
            </div>
            <div class="form-group">
                <label for="country_id">Country</label>
                <select v-model="client.country_id" id="country_id" class="form-control">
                    <option v-bind:value="country.name" v-for="country in countries" :value="country.id" :selected="client.country_id == country.id">{{ country.name }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="country_id">City</label>
                <select v-model="client.city_id" id="city_id" class="form-control">
                    <option v-bind:value="city.id" v-for="city in cities" :value="city.id" :selected="client.city_id == city.id">{{ city.name }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="industry_type_id">Industry Type</label>
                <select v-model="client.industry_type_id" id="industry_type_id" class="form-control">
                    <option v-bind:value="industry.id" v-for="industry in industryTypes" :selected="client.industry_type_id == industry.id">{{ industry.name }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="contacts">Contacts</label>
                <div v-for="(contact, index) in client.contacts" v-bind:key="index" class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input
                                        v-model="contact.content"
                                        float-label="Content"
                                        placeholder="Enter your contact content"
                                        type="text"
                                        class="form-control"
                                        value=""
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <select v-model="contact.contact_type_id" id="contact_type_id" class="form-control">
                            <option v-bind:value="contactType.id" v-for="contactType in contactTypes" :selected="contact.contact_type_id == contactType.id">{{ contactType.name }}</option>
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <div class="block float-right">
                            <button type="button" @click="removeLine(index)" v-if="client.contacts.length > 1"><i class="fa fa-trash"></i></button>
                            <button type="button" v-if="index + 1 === client.contacts.length" @click="addLine"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
    import Contact from "./ContactComponent";
    export default {
        components: {Contact},
        data() {
            return {
                client: {
                    name: '',
                    address: '',
                    city_id: '',
                    country_id: '',
                    contacts: [],
                    industry_type_id: ''
                },
                countries: {},
                cities: {},
                industryTypes: {},
                contactTypes: []
            }
        },

        created() {
            this.getCountryList();
            this.getCityList();
            this.getIndustryTypesList();
            this.getContactTypes();
            this.getClient(this.$route.params.id);
        },

        methods: {
            editClient() {
                console.log(this.client);
                fetch('/api/clients/' + this.client.id, {
                    method: 'PUT',
                    body: JSON.stringify(this.client),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        alert('Client Created');
                        // redirect to clients page
                    })
                    .catch(err => console.log(err));
            },

            getCountryList() {
                fetch('/api/countries?getAll=true')
                    .then(res => res.json())
                    .then(res => {
                        this.countries = res;
                    });
            },

            getCityList() {
                fetch('/api/cities?getAll=true')
                    .then(res => res.json())
                    .then(res => {
                        this.cities = res;
                    });
            },

            getIndustryTypesList() {
                fetch('/api/industry-types?getAll=true')
                    .then(res => res.json())
                    .then(res => {
                        this.industryTypes = res;
                    });
            },

            getContactTypes() {
                fetch('/api/contact-types?getAll=true')
                    .then(res => res.json())
                    .then(res => {
                        this.contactTypes = res;
                    });
            },

            getClient(id) {
                fetch('/api/clients/' + id)
                    .then(res => res.json())
                    .then(res => {
                        this.client = res;
                    });
            },

            addLine () {
                let checkEmptyLines = this.client.contacts.filter(line => line.content === null);
                if (checkEmptyLines.length >= 1 && this.client.contacts.length > 0) return;
                this.client.contacts.push({
                    content: '',
                    contact_type_id: ''
                })
            },
            removeLine (lineId) {
                console.log(lineId);
                if (!this.blockRemoval) this.client.contacts.splice(lineId, 1)
            },
        },

        mounted () {
            this.addLine()
        }
    }
</script>
