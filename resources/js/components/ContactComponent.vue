<template>
    <div>
        <div v-for="(line, index) in lines" v-bind:key="index" class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input
                                v-model="lines.content"
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
                <select v-model="lines.contact_type_id" id="contact_type_id" class="form-control">
                    <option v-bind:value="contactType.id" v-for="contactType in contactTypes">{{ contactType.name }}</option>
                </select>
            </div>

            <div class="col-lg-2">
                <div class="block float-right">
                    <button type="button" @click="removeLine(index)"><i class="fa fa-trash"></i></button>
                    <button type="button" v-if="index + 1 === lines.length" @click="addLine"><i class="fa fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'contact',
        props: ['contacts'],
        data() {
            return {
                lines: [],
                blockRemoval: true,
                contactTypes: [],
                contactType: {
                    id: '',
                    name: ''
                }
            }
        },
        watch: {
            lines () {
                this.blockRemoval = this.lines.length <= 1
            }
        },

        created() {
            this.getContactTypes();
        },

        methods: {
            addLine () {
                let checkEmptyLines = this.lines.filter(line => line.content === null);
                if (checkEmptyLines.length >= 1 && this.lines.length > 0) return;
                this.lines.push({
                    content: '',
                    contact_type_id: ''
                })
            },
            removeLine (lineId) {
                console.log(lineId);
                if (!this.blockRemoval) this.lines.splice(lineId, 1)
            },

            getContactTypes() {
                fetch('api/contact-types?getAll=true')
                    .then(res => res.json())
                    .then(res => {
                        this.contactTypes = res;
                    });
            }
        },
        mounted () {
            this.addLine()
        }
    }
</script>
