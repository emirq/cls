<template>
    <div>
        <h1>
            Cities
            <button type="submit" class="btn btn-success pull-right" v-on:click="showModal(currentCityBeingUpdated, 'create')">Add</button>
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
            <tr v-for="city in cities.data" :key="city.id">
                <th scope="row">{{ city.id }}</th>
                <td>{{ city.name }}</td>
                <td>{{ city.code }}</td>
                <td>
                    <a href="#" v-on:click="deleteCity(city.id)" class="link"><i class="fa fa-trash fa-xs" aria-hidden="true"></i></a>
                    <a href="#" v-on:click="showModal(city, 'update')" class="link"><i class="fa fa-pencil fa-xs" aria-hidden="true"></i></a>
                </td>
            </tr>
            </tbody>
        </table>

        <pagination :data="cities" @pagination-change-page="getCityList"></pagination>

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
                                    <form @submit.prevent="updateCity" class="mb-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Name" v-model="currentCityBeingUpdated.name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Code" v-model="currentCityBeingUpdated.code">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                                    <button type="button" class="btn btn-primary" v-on:click="updateCity(currentCityBeingUpdated)">Save changes</button>
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
                cities: {},
                modalShown: false,
                currentCityBeingUpdated: {
                    id: '',
                    name: '',
                    code: ''
                },
                mode: 'create'
            }
        },

        created() {
            this.getCityList();
        },

        methods: {
            getCityList(page = 1) {
                fetch('api/cities?page=' + page)
                    .then(res => res.json())
                    .then(res => {
                        this.cities = res;
                    });
            },

            deleteCity(id) {
                if (confirm('Are you sure?')) {
                    fetch('api/cities/' + id, {
                        method: 'DELETE'
                    }).then(res => res.json())
                        .then(data => {
                            alert('City Removed');
                            this.getCityList();
                        })
                        .catch(err => console.log(err));
                }
            },

            showModal(city, m) {
                this.modalShown = true;
                this.mode = m;
                this.currentCityBeingUpdated.id = city.id;
                this.currentCityBeingUpdated.name = city.name;
                this.currentCityBeingUpdated.code = city.code;
            },

            updateCity() {
                if (this.mode === 'update') {
                    fetch('api/cities/' + this.currentCityBeingUpdated.id, {
                        method: 'put',
                        body: JSON.stringify(this.currentCityBeingUpdated),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.closeModal();
                            alert('City Updated');
                            this.getCityList();
                        })
                        .catch(err => console.log(err));
                } else {
                    fetch('api/cities', {
                        method: 'post',
                        body: JSON.stringify(this.currentCityBeingUpdated),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.closeModal();
                            alert('City Created');
                            this.getCityList();
                        })
                        .catch(err => console.log(err));
                }

            },

            closeModal() {
                this.modalShown = false;
                this.currentCityBeingUpdated.id = '';
                this.currentCityBeingUpdated.name = '';
                this.currentCityBeingUpdated.code = '';
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
