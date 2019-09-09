<template>
    <div>
        <h1>
            Clients
            <router-link :to="{ name: 'clients-create' }">Add</router-link>
        </h1>
        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">City</th>
                <th scope="col">Country</th>
                <th scope="col">Contacts</th>
                <th scope="col">Industry</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="client in clients.data" :key="client.id">
                <th scope="row">{{ client.id }}</th>
                <td>{{ client.name }}</td>
                <td>{{ client.address }}</td>
                <td>{{ client.city.name }}</td>
                <td>{{ client.country.name }}</td>
                <td>{{ client.country.name }}</td>
                <td>{{ client.industry_type.name }}</td>
                <td>
                    <a href="#" v-on:click="deleteClient(client.id)" class="link"><i class="fa fa-trash fa-xs" aria-hidden="true"></i></a>
                    <router-link :to="{ name: 'client-edit', params: {id: client.id } }"><i class="fa fa-pencil fa-xs" aria-hidden="true"></i></router-link>
                </td>
            </tr>
            </tbody>
        </table>

        <pagination :data="clients" @pagination-change-page="getClientsList"></pagination>

<!--        <div v-if="modalShown">-->
<!--            <transition name="modal">-->
<!--                <div class="modal-mask">-->
<!--                    <div class="modal-wrapper">-->

<!--                        <div class="modal-dialog" role="document">-->
<!--                            <div class="modal-content">-->
<!--                                <div class="modal-header">-->
<!--                                    <h5 class="modal-title">Contact Type</h5>-->
<!--                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                                        <span aria-hidden="true" @click="closeModal">&times;</span>-->
<!--                                    </button>-->
<!--                                </div>-->
<!--                                <div class="modal-body">-->
<!--                                    <form @submit.prevent="updateContactType" class="mb-3">-->
<!--                                        <div class="form-group">-->
<!--                                            <input type="text" class="form-control" placeholder="Name" v-model="currentContactTypeBeingUpdated.name">-->
<!--                                        </div>-->
<!--                                    </form>-->
<!--                                </div>-->
<!--                                <div class="modal-footer">-->
<!--                                    <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>-->
<!--                                    <button type="button" class="btn btn-primary" v-on:click="updateContactType(currentContactTypeBeingUpdated)">Save changes</button>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                    </div>-->
<!--                </div>-->
<!--            </transition>-->
<!--        </div>-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                clients: {},
                modalShown: false
            }
        },

        created() {
            this.getClientsList();

        },

        methods: {
            getClientsList(page = 1) {
                fetch('api/clients?page=' + page)
                    .then(res => res.json())
                    .then(res => {
                        this.clients = res;
                    });
            },

            deleteClient(id) {
                if (confirm('Are you sure?')) {
                    fetch('api/clients/' + id, {
                        method: 'DELETE'
                    }).then(res => res.json())
                        .then(data => {
                            alert('Client Removed');
                            this.getClientsList();
                        })
                        .catch(err => console.log(err));
                }
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
