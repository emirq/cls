<template>
    <div>
        <h1>
            Countries
            <button type="submit" class="btn btn-success pull-right" v-on:click="showModal(currentCountryBeingUpdated, 'create')">Add</button>
        </h1>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="country in countries.data" :key="country.id">
                <th scope="row">{{ country.id }}</th>
                <td>{{ country.name }}</td>
                <td>{{ country.code }}</td>
                <td>
                    <a href="#" v-on:click="deleteCountry(country.id)" class="link"><i class="fa fa-trash fa-xs" aria-hidden="true"></i></a>
                    <a href="#" v-on:click="showModal(country, 'update')" class="link"><i class="fa fa-pencil fa-xs" aria-hidden="true"></i></a>
                </td>
            </tr>
            </tbody>
        </table>

        <pagination :data="countries" @pagination-change-page="getCountryList"></pagination>

        <div v-if="modalShown">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" @click="closeModal">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form @submit.prevent="updateCountry" class="mb-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Name" v-model="currentCountryBeingUpdated.name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Code" v-model="currentCountryBeingUpdated.code">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                                    <button type="button" class="btn btn-primary" v-on:click="updateCountry(currentCountryBeingUpdated)">Save changes</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                countries: {},
                modalShown: false,
                currentCountryBeingUpdated: {
                    id: '',
                    name: '',
                    code: ''
                },
                mode: 'create'
            }
        },

        created() {
            this.getCountryList();
        },

        methods: {
            getCountryList(page = 1) {
                fetch('api/countries?page=' + page)
                    .then(res => res.json())
                    .then(res => {
                        this.countries = res;
                    });
            },

            deleteCountry(id) {
                if (confirm('Are you sure?')) {
                    fetch('api/countries/' + id, {
                        method: 'DELETE'
                    }).then(res => res.json())
                        .then(data => {
                            alert('Country Removed');
                            this.getCountryList();
                        })
                        .catch(err => console.log(err));
                }
            },

            showModal(country, m) {
                this.modalShown = true;
                this.mode = m;
                this.currentCountryBeingUpdated.id = country.id;
                this.currentCountryBeingUpdated.name = country.name;
                this.currentCountryBeingUpdated.code = country.code;
            },

            updateCountry() {
                if (this.mode === 'update') {
                    fetch('api/countries/' + this.currentCountryBeingUpdated.id, {
                        method: 'put',
                        body: JSON.stringify(this.currentCountryBeingUpdated),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.closeModal();
                            alert('Country Updated');
                            this.getCountryList();
                        })
                        .catch(err => console.log(err));
                } else {
                    fetch('api/countries', {
                        method: 'post',
                        body: JSON.stringify(this.currentCountryBeingUpdated),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.closeModal();
                            alert('Country Created');
                            this.getCountryList();
                        })
                        .catch(err => console.log(err));
                }

            },

            closeModal() {
                this.modalShown = false;
                this.currentCountryBeingUpdated.id = '';
                this.currentCountryBeingUpdated.name = '';
                this.currentCountryBeingUpdated.code = '';
            }
        }
    }
</script>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .link {
        margin-right: 5px;
    }
</style>
