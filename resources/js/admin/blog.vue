<template>
    <div>
        <div class="container">
            <div class="col-12">
                <b-btn v-b-modal.seeBlogCategory class="w-100">See Blog Categories</b-btn>
                <b-btn v-b-modal.createBlog class="w-100 mt-2">Create new blog</b-btn>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 my-2" v-for="(blog,index) in all_blog.data">
                        <div class="card">
                            <div class="card-header d-flex">
                                <p class="h4 border-right pr-3">{{ blog.title |capFirst }}
                                    <span class="d-flex">
                                        <small v-for="(cat,ind) in blog.get_category" class="mr-2"> {{ cat.get_name.name }} </small>
                                    </span>
                                </p>
                                <div class="ml-3">
                                    <b-icon :id="`updateInfo${index}`" @click="openUpdateBlogModal(index)" class="cursor-pointer text-muted mx-2" :font-scale="1.2" icon="files"></b-icon>
                                    <b-tooltip :target="`updateInfo${index}`" title="Update"></b-tooltip>
                                    <b-icon @click="deactivateBlog(blog.id,index)" :id="`deleteInfo${index}`" class="mx-2 cursor-pointer text-danger" :font-scale="1.2" icon="dash-circle"></b-icon>
                                    <b-tooltip :target="`deleteInfo${index}`" title="Deactivate"></b-tooltip>
                                </div>

                            </div>
                            <div class="card-body" style="max-height: 250px;overflow-y: scroll">
                                <p v-html="blog.blog"></p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row flex-wrap">
                        <pagination :data="all_blog" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <p class="h4 text-center py-2 col-12 w-100 px-2 border-bottom">Deactivate Blog</p>
                    <p v-if="blog_deactivate.length < 1">No content is available</p>
                    <div class="col-12 my-2" v-for="(blog,index) in blog_deactivate">
                        <div class="card">
                            <div class="card-header d-flex">
                                <p class="h4 border-right pr-3">{{ blog.title |capFirst }}
                                    <span class="d-flex">
                                        <small v-for="(cat,ind) in blog.get_category"> {{ cat.get_name.name }} </small>
                                    </span>
                                </p>
                                <div class="ml-3">
                                    <b-icon @click="restoreBlog(blog.id,index)" :id="`active${index}`" class="mx-2 cursor-pointer text-danger" :font-scale="1.2" icon="arrow-bar-up"></b-icon><b-tooltip :target="`active${index}`" title="Activate"></b-tooltip>
                                    <b-icon @click="forceDelete(blog.id,index)" :id="`deletepost${index}`" class="mx-2 cursor-pointer text-danger" :font-scale="1.2" icon="dash-circle"></b-icon>
                                    <b-tooltip :target="`deletepost${index}`" title="Delete"></b-tooltip>
                                </div>

                            </div>
                            <div class="card-body" style="max-height: 250px;overflow-y: scroll">
                                <p v-html="blog.blog"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <b-modal size="lg" hide-footer id="seeBlogCategory" title="Blog Categories">
            <div class="">
                <div class="col-12 ">
                    <b-form @submit.prevent="saveCategory" class="card card-body">
                        <b-form-input v-model="blog_cat_name" placeholder="Blog Category Name"></b-form-input>
                        <b-btn type="submit" variant="primary" class="mt-2">Add now</b-btn>
                    </b-form>
                </div>
                <div class=" mt-3 border rounded">
                    <ul>
                        <li v-for="(cat,index) in all_cat" class="p-2 d-inline-block" :key="index">
                            <p class="h5 mx-2 my-1">
                                <b-icon :id="`delete${index}`" icon="trash-fill
" class="text-danger cursor-pointer" @click="deleteCategory(cat.id,index)"></b-icon>
                                {{ cat.name | capFirst }}
                            </p>
                            <b-tooltip :target="`delete${index}`" title="Delete"></b-tooltip>
                        </li>
                    </ul>
                </div>
                <div class="d-block card mt-2">
                    <p class="h5 border-bottom p-2">Trash Box of Categories</p>
                    <ul>
                        <li v-for="(cat,index) in all_cat_trashes" class="p-2 d-inline-block" :key="index">
                            <p class="h5 mx-2 my-1">
                                <b-icon :id="`recover${index}`" icon="arrow-bar-up
" class="text-info cursor-pointer mx-2" @click="recoverCategory(cat.id,index)"></b-icon>
                                <b-tooltip :target="`recover${index}`" title="Recover"></b-tooltip>
                                <b-icon icon="trash-fill" :id="`pardelete${index}`" class="text-danger cursor-pointer"
                                        @click="deleteParCategory(cat.id,index)" v-b-tooltip.pardelete></b-icon>
                                <b-tooltip :target="`pardelete${index}`" title="Permanent Delete"></b-tooltip>
                                {{ cat.name | capFirst }}
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </b-modal>
        <b-modal no-close-on-backdrop no-close-on-esc hide-header-close size="xl" hide-footer id="createBlog"
                 title="Create Blog">
            <div class="row">
                <div class="col-12">
                    <b-form @submit.prevent="addBlog()">
                        <b-form-input class="my-2" placeholder="Blog title" v-model="blog.title"></b-form-input>
                        <multiselect class="my-2" track-by="name" label="name" placeholder="Select blog categories"
                                     v-model="blog.categories" :multiple="true" :options="all_cat"></multiselect>

                        <vue-editor class="my-2" v-model="blog.blog"></vue-editor>
                        <b-btn variant="light border" @click="closeBlogModal" class="mr-2">Close X</b-btn>
                        <b-btn type="submit">Save Blog</b-btn>

                    </b-form>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import {VueEditor} from "vue2-editor";
    import Multiselect from 'vue-multiselect'

    Vue.component('pagination', require('laravel-vue-pagination'));

    export default {
        components: {
            VueEditor, Multiselect
        },
        data() {
            return {
                select_blog_index: null,
                blog_cat_name: '',
                all_cat: [],
                all_cat_trashes: [],
                blog_deactivate: [],
                all_blog: {},
                blog: {
                    id: null,
                    title: '',
                    blog: '',
                    categories: [],
                }
            }
        },
        created() {
            this.get_all_blogs();
            this.get_all_cat();
            this.all_deactivate_blog();
        },
        methods: {
            forceDelete(id,index){
                if (confirm('You cannot undo this action. Do you want to delete??')){
                    axios.delete('/admin/blog/'+id)
                        .then(res => {
                            this.$bvToast.toast('Blog deleted',{
                                title: 'Success'
                            })
                            this.blog_deactivate.splice(index,1)
                        })
                }

            },
            restoreBlog(id,index){
                axios.post('/admin/blogs/activate/'+id)
                    .then(res => {
                        this.$bvToast.toast('Blog restored',{
                            title: 'Success'
                        })
                        this.blog_deactivate.splice(index,1)
                        this.all_blog.data.unshift(res.data.data)
                    })
            },
            all_deactivate_blog(){
                axios.get('/admin/blogs/delete/items')
                    .then(res => {
                        this.blog_deactivate = res.data.data
                    })
            },
            deactivateBlog(id,index){
                if (confirm('Do you want to deactivate??')){
                    axios.delete('/admin/blogs/deactivate/'+id)
                        .then(res => {
                            this.$bvToast.toast('Blog deactivated',{
                                title: 'Success'
                            })
                            this.all_blog.data.splice(index,1)
                            this.blog_deactivate.unshift(res.data.data)
                        })
                }
            },
            openUpdateBlogModal(index){
                this.select_blog_index = index
                this.blog.id = this.all_blog.data[index].id
                this.blog.title = this.all_blog.data[index].title
                this.blog.blog = this.all_blog.data[index].blog
                this.all_blog.data[index].get_category.map( (e) => {
                    this.blog.categories.push(e.get_name)
                })
                this.$bvModal.show('createBlog')
            },
            closeBlogModal() {
                this.$bvModal.hide('createBlog')
                this.blog = {
                    id: null,
                    title: '',
                    blog: '',
                    categories: [],
                }
                this.select_blog_index= null
            },
            getResults(page) {
                axios.get('/admin/blog/create?page=' + page)
                    .then(response => {
                        this.all_blog = response.data.data;
                    });
            },
            get_all_blogs() {
                axios.get('/admin/blog/create')
                    .then(res => {
                        this.all_blog = res.data.data
                    })
            },
            addBlog() {
                axios.post('/admin/blog', {
                    blog: this.blog
                }) .then(res => {
                    if (this.select_blog_index === null){
                        this.all_blog.data.unshift(res.data.data)
                    } else {
                        this.all_blog.data.splice(this.select_blog_index,1,res.data.data)
                    }
                    this.$bvToast.toast('Blog Saved',{
                        title: 'Success'
                    })
                })
            },
            get_all_cat() {
                axios.get('/admin/blogs/category')
                    .then(res => {
                        this.all_cat = res.data.data
                        this.all_cat_trashes = res.data.trashes
                    })
            },
            saveCategory() {
                if (this.blog_cat_name !== '') {
                    axios.post('/admin/blogs/category', {
                        blog_cat_name: this.blog_cat_name
                    }).then(res => {
                        this.$bvToast.toast('Blog category saved',{
                            title: 'Success'
                        })
                        this.all_cat.unshift(res.data.data)
                        this.blog_cat_name = ''
                    })
                }
            },
            deleteCategory(id, index) {
                if (confirm('Related post category will remove. Do you confirm??')) {
                    axios.delete(`/admin/blogs/category/delete/${id}`)
                        .then(res => {
                            this.$bvToast.toast('Blog category deleted',{
                                title: 'Success'
                            })
                            this.all_cat.splice(index, 1)
                            this.all_cat_trashes.unshift(res.data.data)
                        })
                }
            },
            deleteParCategory(id, index) {
                if (confirm('Post related this category will also deleted. Do you confirm??')) {
                    axios.delete(`/admin/blogs/category/force/delete/${id}`)
                        .then(res => {
                            this.$bvToast.toast('Blog category parmanent deleted',{
                                title: 'Success'
                            })
                            this.all_cat_trashes.splice(index, 1)
                        })
                }
            },
            recoverCategory(id, index) {
                axios.post(`/admin/blogs/category/recover/${id}`)
                    .then(res => {
                        this.$bvToast.toast('Blog category recovered',{
                            title: 'Success'
                        })
                        this.all_cat_trashes.splice(index, 1)
                        this.all_cat.unshift(res.data.data)
                    })
            }
        },
        filters: {
            capFirst(value) {
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
    ul li {
        list-style: decimal;
    }

    .create_blog .modal-dialog {
        max-width: 100%;
        margin: 0;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100vh;
        display: flex;
        position: fixed;
        z-index: 100000;
    }
</style>
