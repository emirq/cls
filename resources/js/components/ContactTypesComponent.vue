<template>
    <div>
        <h1>
            Contact Types
            <button type="submit" class="btn btn-success pull-right" v-on:click="showModal(currentContactTypeBeingUpdated, 'create')">Add</button>
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
            <tr v-for="contactType in contactTypes.data" :key="contactType.id">
                <th scope="row">{{ contactType.id }}</th>
                <td>{{ contactType.name }}</td>
                <td>
                    <a href="#" v-on:click="deleteContactType(contactType.id)" class="link"><i class="fa fa-trash fa-xs" aria-hidden="true"></i></a>
                    <a href="#" v-on:click="showModal(contactType, 'update')" class="link"><i class="fa fa-pencil fa-xs" aria-hidden="true"></i></a>
                </td>
            </tr>
            </tbody>
        </table>

        <pagination :data="contactTypes" @pagination-change-page="getContactTypesList"></pagination>

        <div v-if="modalShown">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Contact Type</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" @click="closeModal">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form @submit.prevent="updateContactType" class="mb-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Name" v-model="currentContactTypeBeingUpdated.name">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                                    <button type="button" class="btn btn-primary" v-on:click="updateContactType(currentContactTypeBeingUpdated)">Save changes</button>
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
                contactTypes: {},
                modalShown: false,
                currentContactTypeBeingUpdated: {
                    id: '',
                    name: '',
                },
                mode: 'create'
            }
        },

        created() {
            this.getContactTypesList();
        },

        methods: {
            getContactTypesList(page = 1) {
                fetch('api/contact-types?page=' + page)
                    .then(res => res.json())
                    .then(res => {
                        this.contactTypes = res;
                    });
            },

            deleteContactType(id) {
                if (confirm('Are you sure?')) {
                    fetch('api/contact-types/' + id, {
                        method: 'DELETE'
                    }).then(res => res.json())
                        .then(data => {
                            alert('Contact Type Removed');
                            this.getContactTypesList();
                        })
                        .catch(err => console.log(err));
                }
            },

            showModal(contactType, m) {
                this.modalShown = true;
                this.mode = m;
                this.currentContactTypeBeingUpdated.id = contactType.id;
                this.currentContactTypeBeingUpdated.name = contactType.name;
            },

            updateContactType() {
                if (this.mode === 'update') {
                    fetch('api/contact-types/' + this.currentContactTypeBeingUpdated.id, {
                        method: 'put',
                        body: JSON.stringify(this.currentContactTypeBeingUpdated),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.closeModal();
                            alert('Contact Type Updated');
                            this.getContactTypesList();
                        })
                        .catch(err => console.log(err));
                } else {
                    fetch('api/contact-types', {
                        method: 'post',
                        body: JSON.stringify(this.currentContactTypeBeingUpdated),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.closeModal();
                            alert('Contact Type Created');
                            this.getContactTypesList();
                        })
                        .catch(err => console.log(err));
                }

            },

            closeModal() {
                this.modalShown = false;
                this.currentContactTypeBeingUpdated.id = '';
                this.currentContactTypeBeingUpdated.name = '';
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
