<template>
    <div class="container-md">
        <div class="row">
            <div class="col">
                <b-btn variant="light border" class="w-100" v-b-modal:banner_add>Add banner</b-btn>
                <b-modal title="Add banner" id="banner_add" hide-footer>
                    <div class="row">
                        <form @submit.prevent="addImage" class="col-12">
                            <input class="mb-2 form-control" type="text" v-model="banner.caption"
                                   placeholder="Enter your banner caption">
                            <input class="mb-2 form-control" type="text" v-model="banner.text"
                                   placeholder="Enter your banner text">
                            <b-form-file class="mb-2"
                                         ref="banner"
                                         accept="image/*"
                                         placeholder="Choose image/images or drop it here..."
                                         drop-placeholder="Drop file here..."
                            ></b-form-file>
                            <b-btn type="submit" variant="primary" class="w-100">Add now</b-btn>
                        </form>
                    </div>
                </b-modal>
            </div>
        </div>
        <b-overlay :show="imageshow" rounded="sm" class="mt-5">
            <div class="bg-white shadow-sm rounded">
                <div class="card">
                    <div class="card-header">
                        <p>Active banners</p>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-4 col-6 my-2" v-for="(banner,index) in activeBanners" :key="index">
                            <div class="card position-relative">
                                <div class="card-header">
                                    <b-img-lazy class="w-100 shadow-sm my-2 rounded" :src="`/images/${banner.image}`" fluid-grow></b-img-lazy>
                                </div>
                                <div class="card-header">
                                    <p class="h4">{{ banner.caption }}</p>
                                    <p class="h5">{{ banner.text }}</p>
                                </div>
                                <div @click="deactivebanner(banner.id,index)" :id="`act${index}`" class="position-absolute bottom-0 right-0 px-2 py-1 rounded bg-white cursor-pointer">
                                    <b-icon  icon="backspace-reverse
"></b-icon>
                                </div>
                                <b-tooltip :target="`act${index}`" title="Deactivate"></b-tooltip>

                            </div>


                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <p>Deactivate banners</p>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-4 col-6 my-2" v-for="(banner,index) in deactivateBanners" :key="index">
                            <div class="card position-relative">
                                <div class="card-header">
                                    <b-img-lazy class="w-100 shadow-sm my-2 rounded" :src="`/images/${banner.image}`" fluid-grow></b-img-lazy>
                                </div>
                                <div class="card-header">
                                    <p class="h4">{{ banner.caption }}</p>
                                    <p class="h5">{{ banner.text }}</p>
                                </div>
                                <div @click.prevent="activeBanner(banner.id,index)" :id="`act${index}`" class="position-absolute bottom-0 right-0 px-2 py-1 rounded bg-white cursor-pointer">
                                    <b-icon  icon="check2"></b-icon>
                                </div>
                                <b-tooltip :target="`act${index}`" title="Active"></b-tooltip>

                            </div>
                            <b-icon font-scale="2" @click="deleteBanner(banner.id,index)" icon="trash"
                                    class="p-1 shadow-lg bg-white position-absolute top-0 cursor-pointer"
                                    style="right: 10px"></b-icon>

                        </div>
                    </div>
                </div>
            </div>
        </b-overlay>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                activeBanners: null,
                deactivateBanners: null,
                banner: {
                    caption: '',
                    text: '',

                },
                imageshow: false
            }
        },
        created() {
            this.get_all()
        },
        methods: {
            activeBanner(id,index){
                axios.post('/admin/custom/banner/active/'+id)
                    .then(res => {
                        this.$bvToast.toast('Banner activated',{
                            title: 'Success'
                        })
                        this.deactivateBanners.splice(index,1)
                        this.activeBanners.unshift(res.data.data)
                    })
            },
            deactivebanner(id,index){
                axios.post('/admin/custom/banners/deactivate/'+id)
                    .then(res => {
                        this.$bvToast.toast('Banner deactivated',{
                            title: 'Success'
                        })
                        this.activeBanners.splice(index,1)
                        this.deactivateBanners.unshift(res.data.data)
                    })
            },
            deleteBanner(id, index) {
                if (confirm('Do you want to delete')) {
                    axios.delete('/admin/banner/' + id)
                        .then(res => {
                            this.banners.splice(index, 1)
                            this.$bvToast.toast('Banner deleted',{
                                title: 'Success'
                            })
                        })
                }
            },
            get_all() {
                this.imageshow = true
                axios.get('/admin/banner/create')
                    .then(res => {
                        this.activeBanners = res.data.active
                        this.deactivateBanners = res.data.deactive
                    })
                this.imageshow = false
            },
            addImage(event) {
                console.log(this.$refs.banner.files[0])
                this.imageshow = true
                let formdata = new FormData
                formdata.append('banner', this.$refs.banner.files[0])
                formdata.set('caption', this.banner.caption)
                formdata.set('text', this.banner.text)
                axios.post('/admin/banner', formdata)
                    .then(res => {
                        this.deactivateBanners.unshift(res.data.data)
                    })
                this.imageshow = false
            }
        }
    }
</script>
