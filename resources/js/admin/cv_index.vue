<template>
    <b-overlay :show="fullOverlay" rounded="sm">
        <div class="container-md">
            <div class="row">
                <div class="col-12">
                    <b-button variant="info" v-b-modal.createnew class="w-100">Create new CV item</b-button>
                </div>

            </div>

            <div class="row mt-3" v-if="cv_items.length" >
                <div class="col-12 mb-3" v-for="(item,index) in cv_items" :key="index">
                    <div class="card">
                        <div class="card-header">
                            <p :style="{'color': set_color(item.color),'font-size': set_size(item.size)}">{{ item.name }} <b-icon @click="updateTitle(index)" class="cursor-pointer text-muted" :font-scale="1.2" icon="files"></b-icon>
                                <b-icon @click="deleteCvItem(item.id,1,index)" class="mx-2 cursor-pointer text-muted" :font-scale="1.2" icon="dash-circle"></b-icon></p>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div v-for="(head,head_index) in item.get_header" :key="head_index">
                                    <div class="card-header">
                                        <p :style="{'color': set_color(head.color),'font-size': set_size(head.size)}">{{ head.name }} <b-icon @click="updateHeader(index,head_index)" class="cursor-pointer text-muted" :font-scale="1.2" icon="files"></b-icon><b-icon @click="deleteCvItem(item.id,2,index,head_index)" class="mx-2 cursor-pointer text-muted" :font-scale="1.2" icon="dash-circle"></b-icon></p>
                                    </div>
                                    <div class="card-body">
                                        <div class="card">
                                            <div class="card-footer">
                                                <div v-for="(body,body_index) in head.get_body">
                                                    <p :style="{'color': set_color(body.color),'font-size': set_size(body.size)}">{{ body.name }} <b-icon @click="updateBody(index,head_index,body_index)" class="cursor-pointer text-muted" :font-scale="1.2" icon="files"></b-icon><b-icon @click="deleteCvItem(body.id,3,index,head_index,body_index)" class="mx-2 cursor-pointer text-muted" :font-scale="1.2" icon="dash-circle"></b-icon></p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!--        modal start-->
        <b-modal no-close-on-backdrop no-close-on-esc hide-header-close id="createnew" size="lg" title="New CV" hide-footer>
            <b-form class="row" @submit.prevent="addItems">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <b-form-input v-model="new_cv.cv_title" :disabled="updateHeaderIndex" :required="new_cv.id === null"
                                          placeholder="Title of your header"></b-form-input>

                        </div>
                        <div class="col-md-6 col-12 mt-md-0 mt-2">
                            <div class="row">
                                <b-col>
                                    <b-form-input v-model="new_cv.title_color" :disabled="updateHeaderIndex !== null"
                                                  placeholder="Color Hax Code"></b-form-input>
                                </b-col>
                                <b-col>
                                    <b-form-input v-model.number="new_cv.title_fontsize" :disabled="updateHeaderIndex !== null"
                                                  placeholder="Font Size"></b-form-input>
                                </b-col>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="row bg-white border rounded mx-2 py-2 mb-2"
                             v-for="(head, index) in new_cv.header" :key="index">
                            <h5 class="col-12 border-bottom py-2">Header {{ index+1 }}
                                <b-icon @click="addheader" class="cursor-pointer" :font-scale="1.2"
                                        v-if="!head.id && index === new_cv.header.length -1" icon="plus-circle"></b-icon>
                                <b-icon @click="removeheader(index)" class="mx-2 cursor-pointer" :font-scale="1.2"
                                        icon="dash-circle" v-if="!head.id && new_cv.header.length > 1"></b-icon>
                            </h5>
                            <div class="col-md-6 col-12">
                                <b-form-input :disabled="updateBodyIndex !== null" :required="new_cv.id === null" v-model="head.name" placeholder="Header name"></b-form-input>
                            </div>
                            <div class="col-md-6 col-12 mt-md-0 mt-2">
                                <div class="row">
                                    <div class="col-6">
                                        <b-form-input v-model="head.color" :disabled="updateBodyIndex !== null"
                                                      placeholder="Color hax code"></b-form-input>
                                    </div>
                                    <div class="col-6">
                                        <b-form-input :disabled="updateBodyIndex !== null" v-model="head.font" placeholder="Font size"></b-form-input>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-2 px-4">

                                <div class="row bg-white border rounded py-2 mb-2"
                                     v-for="(main_body,bodyIndex) in head.body" :key="bodyIndex">
                                    <h5 class="col-12 border-bottom py-2">Element {{ bodyIndex+1 }}
                                        <b-icon @click="addBody(index)" class="cursor-pointer"
                                                v-if="!main_body.id && bodyIndex === head.body.length -1" :font-scale="1.2"
                                                icon="plus-circle"></b-icon>
                                        <b-icon @click="removeBody(index,bodyIndex)" class="mx-2 cursor-pointer"
                                                :font-scale="1.2" v-if="!main_body.id && head.body.length > 1"
                                                icon="dash-circle"></b-icon>
                                    </h5>
                                    <div class="col-md-6 col-12">
                                        <b-form-input :required="new_cv.id === null" v-model="main_body.name" placeholder="Element name"></b-form-input>
                                    </div>
                                    <div class="col-md-6 col-12 mt-md-0 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <b-form-input v-model="main_body.color"
                                                              placeholder="Color hax code"></b-form-input>
                                            </div>
                                            <div class="col-6">
                                                <b-form-input v-model="main_body.font"
                                                              placeholder="Font size"></b-form-input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <b-btn variant="primary" class="mt-3  col-12 w-100" type="submit">Save/Update</b-btn>
                <b-btn variant="light" class="border mt-3 col-12 w-100" @click.prevent="cancelModal">Cancel <b-icon icon="x"></b-icon></b-btn>
            </b-form>
        </b-modal>
<!--        <b-modal v-if="cv_items[updateTitleIndex]"  :title="`Update ${cv_items[updateTitleIndex].name}`" id="updateTitleOrAdd" hide-footer size="lg">-->
<!--            <b-form class="row" v-if="cv_items[updateTitleIndex]">-->
<!--                <div class="col-12">-->
<!--                    <b-form-group-->
<!--                        id="input-group-1"-->
<!--                        label="Update title of your header:"-->
<!--                        label-for="titleUpdate"-->
<!--                    >-->
<!--                        <b-form-input-->
<!--                            id="titleUpdate"-->
<!--                            v-model="cv_items[updateTitleIndex].name"-->
<!--                            type="text"-->
<!--                            required-->
<!--                            placeholder="Title of your header"-->
<!--                        ></b-form-input>-->
<!--                    </b-form-group>-->
<!--                </div>-->
<!--                <div class="col-12">-->
<!--                    <div class="row">-->
<!--                        <div class="col-6">-->
<!--                            <b-form-group-->
<!--                                id="input-group-1"-->
<!--                                label="Color:"-->
<!--                                label-for="colorUpdate"-->
<!--                            >-->
<!--                                <b-form-input-->
<!--                                    id="colorUpdate"-->
<!--                                    v-model="cv_items[updateTitleIndex].color"-->
<!--                                    type="text"-->
<!--                                    required-->
<!--                                    placeholder="Color of your title"-->
<!--                                ></b-form-input>-->
<!--                            </b-form-group>-->
<!--                        </div>-->
<!--                        <div class="col-6">-->
<!--                            <b-form-group-->
<!--                                id="input-group-1"-->
<!--                                label="Font size:"-->
<!--                                label-for="sizeUpdate"-->
<!--                            >-->
<!--                                <b-form-input-->
<!--                                    id="sizeUpdate"-->
<!--                                    v-model.number="cv_items[updateTitleIndex].size"-->
<!--                                    type="text"-->
<!--                                    required-->
<!--                                    placeholder="Size of your title"-->
<!--                                ></b-form-input>-->
<!--                            </b-form-group>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <b-button type="submit" variant="primary">Submit</b-button>-->
<!--            </b-form>-->
<!--        </b-modal>-->
    </b-overlay>
</template>

<script>

    export default {
        components: {},
        data() {
            return {
                fullOverlay: false,
                cv_items: [],
                updateTitleIndex: null,
                updateHeaderIndex: null,
                updateBodyIndex: null,


                new_cv: {
                    id: null,
                    title_color: '',
                    title_fontsize: '',
                    cv_title: '',
                    header: [
                        {
                            id: null,
                            name: '',
                            color: '',
                            font: '',
                            body: [
                                {
                                    id: null,
                                    name: '',
                                    color: '',
                                    font: '',
                                }
                            ]
                        }
                    ]
                },

            }
        },
        created() {
            this.get_all_items()
        },
        methods: {
            deleteCvItem(id,type,index,secondIndex,thirdIndex){
                if (confirm('Do you want to delete this item')){
                    axios.delete(`/admin/cvmaker/delete/${id}/${type}`)
                        .then(res => {
                            if (type === 1){
                                this.cv_items.splice(index,1)
                            } else {
                                if (type === 2) {
                                    this.cv_items[index].get_header.splice(secondIndex,1)
                                } else {
                                    this.cv_items[index].get_header[secondIndex].get_body.splice(thirdIndex,1)
                                }
                            }
                            this.$bvToast.toast('Delete item successfully',{
                                title: 'Success'
                            })
                        })
                }


            },
            cancelModal(){
                this.updateTitleIndex = null
                this.updateHeaderIndex = null
                this.updateBodyIndex = null
                this.$bvModal.hide('createnew');
                this.new_cv = {
                    id: null,
                        title_color: '',
                        title_fontsize: '',
                        cv_title: '',
                        header: [
                        {
                            id: null,
                            name: '',
                            color: '',
                            font: '',
                            body: [
                                {
                                    id: null,
                                    name: '',
                                    color: '',
                                    font: '',
                                }
                            ]
                        }
                    ]
                }
            },
            updateHeader(index,secIndex){
                this.updateTitleIndex = index
                this.updateHeaderIndex = secIndex
                this.new_cv.title_color = this.cv_items[index].color
                this.new_cv.title_fontsize = this.cv_items[index].size
                this.new_cv.cv_title = this.cv_items[index].name
                this.new_cv.id = this.cv_items[index].id
                this.new_cv.header[0].id = this.cv_items[index].get_header[secIndex].id
                this.new_cv.header[0].name = this.cv_items[index].get_header[secIndex].name
                this.new_cv.header[0].color = this.cv_items[index].get_header[secIndex].color
                this.new_cv.header[0].font = this.cv_items[index].get_header[secIndex].size
                this.$bvModal.show('createnew');
            },
            updateBody(index,secIndex,thirdIndex){
                this.updateTitleIndex = index
                this.updateHeaderIndex = secIndex
                this.updateBodyIndex = thirdIndex
                this.new_cv.title_color = this.cv_items[index].color
                this.new_cv.title_fontsize = this.cv_items[index].size
                this.new_cv.cv_title = this.cv_items[index].name
                this.new_cv.id = this.cv_items[index].id
                this.new_cv.header[0].id = this.cv_items[index].get_header[secIndex].id
                this.new_cv.header[0].name = this.cv_items[index].get_header[secIndex].name
                this.new_cv.header[0].color = this.cv_items[index].get_header[secIndex].color
                this.new_cv.header[0].font = this.cv_items[index].get_header[secIndex].size
                this.new_cv.header[0].body[0].id = this.cv_items[index].get_header[secIndex].get_body[thirdIndex].id
                this.new_cv.header[0].body[0].name = this.cv_items[index].get_header[secIndex].get_body[thirdIndex].name
                this.new_cv.header[0].body[0].color = this.cv_items[index].get_header[secIndex].get_body[thirdIndex].color
                this.new_cv.header[0].body[0].font = this.cv_items[index].get_header[secIndex].get_body[thirdIndex].size
                this.$bvModal.show('createnew');
            },
            updateTitle(index){
                this.updateTitleIndex = index
                this.new_cv.title_color = this.cv_items[index].color
                this.new_cv.title_fontsize = this.cv_items[index].size
                this.new_cv.cv_title = this.cv_items[index].name
                this.new_cv.id = this.cv_items[index].id
                this.$bvModal.show('createnew');
            },
            set_color(color){
                if (color){
                    return color
                } else {
                    return '#262626'
                }
            },
            set_size(size){
                if (size){
                    return size+'px'
                } else {
                    return '17px'
                }
            },
            get_all_items(){
                axios.get('/admin/cvmaker/create')
                    .then(res => {
                        this.cv_items = res.data.data
                    })
            },
            addItems() {
                this.fullOverlay = true
                axios.post('/admin/cvmaker', {
                    cv: this.new_cv
                }).then(res => {
                    if (this.updateTitleIndex === null){
                        this.$bvToast.toast('New CV items added',{
                            title: 'Success'
                        })
                        this.cv_items.unshift(res.data.data)
                    } else {
                        this.$bvToast.toast('CV updated',{
                            title: 'Success'
                        })
                        this.cv_items.splice(this.updateTitleIndex,1,res.data.data)
                    }

                })
                this.fullOverlay = false
            },
            removeheader(index) {
                if (this.new_cv.header.length > 1) {
                    if (confirm('Do you want to remove??')) {
                        this.new_cv.header.splice(index, 1)
                    }
                }

            },
            removeBody(index, child) {
                if (this.new_cv.header[index].body.length > 1) {
                    if (confirm('Do you want to remove??')) {
                        this.new_cv.header[index].body.splice(child, 1)
                    }
                }

            },
            addheader() {
                this.new_cv.header.push({
                    name: '',
                    color: '',
                    font: '',
                    body: [
                        {
                            name: '',
                            color: '',
                            font: '',
                        }
                    ]
                })
            },
            addBody(index) {
                this.new_cv.header[index].body.push({
                    name: '',
                    color: '',
                    font: '',
                })
            }
        },
        // validations: {
        //     new_cv: {
        //         cv_title: {
        //             required,
        //         },
        //         header : {
        //             $each : {
        //                 name: {
        //                     required
        //                 },
        //                 body: {
        //                     $each: {
        //                         name: {
        //                             required
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }
    }
</script>
