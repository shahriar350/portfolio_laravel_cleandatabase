<template>
    <div class="container-md">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 ">
                <div class="row justify-content-center">
                    <div class="mb-md-5 mb-2 col-sm-12 col-9">
                        <b-img-lazy v-if="user_info.avatar" :src="`/images/${user_info.avatar}`" alt=""
                                    fluid></b-img-lazy>
                        <b-icon class="d-flex justify-content-center mb-2 w-100" :font-scale="6" icon="person-circle"
                                title="Demo profile pic" v-else></b-icon>
                        <label for="avatar" class="w-100 btn btn-sm btn-light border">Select a photo</label>
                        <input @change="changeProfilePic" id="avatar" type="file" class="d-none">
                    </div>
                </div>

                <div class="">

                    <b-modal no-close-on-esc no-close-on-backdrop hide-header-close title="add/update contact"
                             hide-footer id="more_contact">
                        <div class="row">
                            <form @submit.prevent="saveContact" class="col-12">
                                <div class="form-group">
                                    <label class="h5" for="medium">Icon</label>
                                    <p class="text-muted">Go to <a target="_blank"
                                                                   href="https://bootstrap-vue.org/docs/icons">this
                                        link</a> and select icon name only</p>
                                    <input type="text" id="icon" class="form-control" placeholder="ex: image, alarm"
                                           v-model="contact.icon">
                                </div>
                                <div class="form-group">
                                    <label class="h5" for="medium">Contact Medium</label>
                                    <input type="text" id="medium" class="form-control" v-model="contact.text"
                                           placeholder="ex: gmail or facebook or linkedin">
                                </div>
                                <div class="form-group">
                                    <label class="h5" for="info">Contact information</label>
                                    <input type="text" id="info" class="form-control" v-model="contact.contact"
                                           placeholder="ex: abc@abc.com or 01xxxxx">
                                </div>
                                <b-btn type="submit" variant="primary" class="w-100">Save now</b-btn>
                                <b-btn type="submit" variant="light" class="w-100 mt-2" @click="closeContactModal">Close
                                    X
                                </b-btn>
                            </form>
                        </div>

                    </b-modal>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-6 col-12">
                <div class="col-12 card mb-3 px-0">
                    <div class="card-header">
                        <p class="card-title">Personal Information</p>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="personalUpdate" method="post">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" class="form-control" type="text" v-model="user_info.name">
                            </div>
                            <div class="form-group">
                                <label for="name">New Password</label>
                                <input id="name" class="form-control" type="text" v-model="newPassword">
                            </div>
                            <b-btn type="submit" variant="primary w-100">Update now</b-btn>
                        </form>

                    </div>

                </div>
                <div class="col-12 card">
                    <div class="card-header">
                        <b-btn variant="info" class="w-100" v-b-modal:more_contact>Add more contact</b-btn>
                    </div>
                    <div class="card-body px-md-3 px-0">
                        <div class="d-flex flex-column flex-wrap">
                            <div v-for="(contact,index) in all_contact" class="p-1 border ">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="d-flex align-items-center">
                                        <b-icon class="mx-1 h5" v-if="contact.icon" :icon="contact.icon"></b-icon>
                                        <p class="mx-1 h5" v-if="contact.text">{{ contact.text }}</p>
                                        <p class="mx-1 h5">{{ contact.contact }}</p>
                                    </div>
                                    <div class="h4">
                                        <b-icon class="text-muted" icon="files"
                                                @click="updateInfoSet(contact,index)"></b-icon>
                                        <b-icon class="text-danger" icon="trash"
                                                @click="deleteInfoSet(contact.id,index)"></b-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3 w-100">
                    <p class="card-header h5">Profession Address:
                        <b-icon class="text-muted" icon="files" v-b-modal:user_address></b-icon>
                    </p>
                    <p class="card-body" v-html="user_info.address"></p>
                </div>
                <div class="card mt-3 w-100">
                    <p class="card-header h5">Your Information of profession:
                        <b-icon class="text-muted" icon="files" v-b-modal:user_info></b-icon>
                    </p>

                    <p class="card-body" v-html="user_info.info"></p>
                </div>
                <div class="card mt-3 w-100">
                    <p class="card-header h5">Your Biography
                        <b-icon class="text-muted" icon="files" v-b-modal:user_bio></b-icon>
                    </p>

                    <p class="card-body" v-html="user_info.bio"></p>
                </div>
            </div>
        </div>
        <b-modal title="Update Address" hide-footer id="user_address" class="row">
            <div class="col-12">
                <form @keydown.enter="" @submit.prevent="addAddress" class="w-100 d-flex flex-column">
                    <label class="h5" for="add_mod">{{ user_info.name | first_cap }} Professional Address</label>
                    <vue-editor id="add_mod" v-model="user_info.address" :editor-toolbar="customToolbar"/>
                    <b-btn type="submit" class="w-100 mt-2">Save now</b-btn>
                </form>
            </div>

        </b-modal>
        <b-modal size="xl" title="Update your Biography" hide-footer id="user_bio" class="row">
            <div class="col-12">
                <form @keydown.enter="" @submit.prevent="addBio" class="w-100 d-flex flex-column">
                    <label class="h5" for="add_bio">{{ user_info.name | first_cap }}'s Biography</label>
                    <vue-editor id="add_bio" v-model="user_info.bio"/>
                    <b-btn type="submit" class="w-100 mt-2">Save now</b-btn>
                </form>
            </div>

        </b-modal>
        <b-modal title="Update information" hide-footer id="user_info" class="row">
            <div class="col-12">
                <form @submit.prevent="addInfo" class="w-100 d-flex flex-column">
                    <label class="h5" for="info_mod">{{ user_info.name | first_cap }} Professional Info</label>
                    <vue-editor id="info_mod" v-model="user_info.info" :editor-toolbar="customToolbar"/>

                    <b-btn type="submit" class="w-100 mt-2">Save now</b-btn>
                </form>
            </div>

        </b-modal>
    </div>
</template>

<script>
    import {VueEditor} from "vue2-editor";


    export default {
        components: {VueEditor},
        props: ['user'],
        data() {
            return {
                newPassword: '',
                customToolbar: [
                    ["bold", "italic", "underline"],
                ],
                user_info: this.user,
                select_contact_index: null,
                all_contact: [],
                contact: {
                    id: null,
                    icon: '',
                    text: '',
                    contact: '',
                },
            }
        },
        created() {
            this.get_all_contact();
        },
        methods: {
            personalUpdate(){
                axios.post('/admin/user/personal/info',{
                    name : this.user_info.name,
                    password: this.newPassword
                }) .then(res => {
                    this.$bvToast.toast('Information updated', {
                        title: 'Success'
                    })
                })
            },
            addAddress() {
                axios.post('/admin/user/address', {
                    address: this.user_info.address
                }).then(res => {
                    this.$bvToast.toast('Information updated', {
                        title: 'Success'
                    })
                })
            },
            addBio() {
                axios.post('/admin/user/bio', {
                    bio: this.user_info.bio
                }).then(res => {
                    this.$bvToast.toast('Information updated', {
                        title: 'Success'
                    })
                })
            },
            addInfo() {
                axios.post('/admin/user/info', {
                    info: this.user_info.info
                }).then(res => {
                    this.$bvToast.toast('Information updated', {
                        title: 'Success'
                    })
                })
            },
            deleteInfoSet(id, index) {
                if (confirm("This will deleted and you don't undo this action")) {
                    axios.delete('/admin/user/contact/' + id)
                        .then(res => {
                            this.$bvToast.toast('A Contact deleted', {
                                title: 'Success'
                            })
                            this.all_contact.splice(index, 1)
                        })
                }

            },
            updateInfoSet(contact, index) {
                this.contact.id = contact.id
                this.contact.icon = contact.icon
                this.contact.text = contact.text
                this.contact.contact = contact.contact
                this.select_contact_index = index
                this.$bvModal.show('more_contact')
            },
            saveContact() {
                axios.post('/admin/user/contact', {
                    contact: this.contact
                }).then(res => {
                    if (this.select_contact_index === null) {
                        this.all_contact.push(res.data.data)
                    } else {
                        this.all_contact.splice(this.select_contact_index, 1, res.data.data)
                    }
                    this.$bvToast.toast('A Contact have saved', {
                        title: 'Success'
                    })
                })
            },
            get_all_contact() {
                axios.get('/admin/user/contact')
                    .then(res => {
                        this.all_contact = res.data.data
                    })
            },
            closeContactModal() {
                this.$bvModal.hide('more_contact')
                this.select_contact_index = null
                this.contact = {
                    id: null,
                    icon: '',
                    text: '',
                    contact: '',
                }
            },
            changeProfilePic(event) {
                let formdata = new FormData
                formdata.append('image', event.target.files[0])
                axios.post('/admin/user/change/avatar', formdata)
                    .then(res => {
                        this.user_info = res.data.data
                    })
            }
        },
    }
</script>

<style scoped>
    /*@import '~quill/dist/quill.core.css';*/

</style>
