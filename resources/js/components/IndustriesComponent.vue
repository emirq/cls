<template>
    <div>
        <h1>
            Industry Types
            <button type="submit" class="btn btn-success pull-right" v-on:click="showModal(currentIndustryTypeBeingUpdated, 'create')">Add</button>
        </h1>
        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="industryType in industryTypes.data" :key="industryType.id">
                <th scope="row">{{ industryType.id }}</th>
                <td>{{ industryType.name }}</td>
                <td>
                    <a href="#" v-on:click="deleteIndustryType(industryType.id)" class="link"><i class="fa fa-trash fa-xs" aria-hidden="true"></i></a>
                    <a href="#" v-on:click="showModal(industryType, 'update')" class="link"><i class="fa fa-pencil fa-xs" aria-hidden="true"></i></a>
                </td>
            </tr>
            </tbody>
        </table>

        <pagination :data="industryTypes" @pagination-change-page="getIndustryTypesList"></pagination>

        <div v-if="modalShown">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Industry Type</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" @click="closeModal">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form @submit.prevent="updateIndustryType" class="mb-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Name" v-model="currentIndustryTypeBeingUpdated.name">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                                    <button type="button" class="btn btn-primary" v-on:click="updateIndustryType(currentIndustryTypeBeingUpdated)">Save changes</button>
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
                industryTypes: {},
                modalShown: false,
                currentIndustryTypeBeingUpdated: {
                    id: '',
                    name: '',
                },
                mode: 'create'
            }
        },

        created() {
            this.getIndustryTypesList();
        },

        methods: {
            getIndustryTypesList(page = 1) {
                fetch('api/industry-types?page=' + page)
                    .then(res => res.json())
                    .then(res => {
                        this.industryTypes = res;
                    });
            },

            deleteIndustryType(id) {
                if (confirm('Are you sure?')) {
                    fetch('api/industry-types/' + id, {
                        method: 'DELETE'
                    }).then(res => res.json())
                        .then(data => {
                            alert('Contact Type Removed');
                            this.getIndustryTypesList();
                        })
                        .catch(err => console.log(err));
                }
            },

            showModal(industryType, m) {
                this.modalShown = true;
                this.mode = m;
                this.currentIndustryTypeBeingUpdated.id = industryType.id;
                this.currentIndustryTypeBeingUpdated.name = industryType.name;
            },

            updateIndustryType() {
                if (this.mode === 'update') {
                    fetch('api/industry-types/' + this.currentIndustryTypeBeingUpdated.id, {
                        method: 'put',
                        body: JSON.stringify(this.currentIndustryTypeBeingUpdated),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.closeModal();
                            alert('Industry Type Updated');
                            this.getIndustryTypesList();
                        })
                        .catch(err => console.log(err));
                } else {
                    fetch('api/industry-types', {
                        method: 'post',
                        body: JSON.stringify(this.currentIndustryTypeBeingUpdated),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.closeModal();
                            alert('Industry Type Created');
                            this.getIndustryTypesList();
                        })
                        .catch(err => console.log(err));
                }

            },

            closeModal() {
                this.modalShown = false;
                this.currentIndustryTypeBeingUpdated.id = '';
                this.currentIndustryTypeBeingUpdated.name = '';
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
