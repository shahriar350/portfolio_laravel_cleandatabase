<template>
    <div class="row">
        <b-carousel class="my-3 col-12"
                    id="carousel-1"
                    :interval="4000"
                    controls
                    background="#ababab"
                    img-width="1024"
                    img-height="480"
                    style="text-shadow: 1px 1px 2px #333;"
        >
            <!-- Text slides with image -->
            <b-carousel-slide v-for="(banner,index) in banners" :key="index" :img-src="`/images/${banner.image}`">
                <div class="car_ban" v-if="banner.caption || banner.text">
                    <p class="h4 text-white" >{{ banner.caption }}</p>
                    <p class="teal text-white">{{ banner.text }}</p>
                </div>
            </b-carousel-slide>
        </b-carousel>

        <div class="col-12 card mb-3"  v-for="(cv,index) in total_cv" :key="index">
            <p class="py-2 card-title text-center"
               :style="{'color': set_color(cv.color),'font-size': set_size(cv.size)}">{{ cv.name }}</p>
            <div class="row">
                <div class="col-12 card-body border" v-for="(head,headdex) in cv.get_header" :key="headdex">
                    <div class="row border px-md-0 px-2">
                        <div class="col-md-3 col-12">
                            <p class="border-bottom py-2 card-title" :style="{'color': set_color(head.color),'font-size': set_size(head.size)}">{{ head.name }}</p>
                        </div>
                        <div class="col-md-9 col-12 shadow-sm">
                            <div class="row">
                                <div class="col-12" v-for="(body,bodindex) in head.get_body">
                                    <p class="py-2" :style="{'color': set_color(body.color),'font-size': set_size(body.size)}">{{ body.name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!--        <div class="col-12 card mb-3" v-for="(cv,index) in total_cv" :key="index">-->
<!--            <p class="py-2 text-center border-bottom h3"-->
<!--               :style="{'color': set_color(cv.color),'font-size': set_size(cv.size)}">{{ cv.name }}</p>-->
<!--            <div v-for="(head,headdex) in cv.get_header" :key="headdex" class="d-flex flex-row my-2">-->

<!--                <div class="w-75 d-flex flex-column">-->
<!--                    <div v-for="(body,bodindex) in head.get_body" class="mb-3" :key="bodindex" >-->
<!--                        <p class="h4" :style="{'color': set_color(body.color),'font-size': set_size(body.size)}">{{ body.name }}</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                banners: [],
                total_cv: [],
            }
        },
        created() {
            this.get_all_banner()
            this.get_all_cv()
        },
        methods: {
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
            get_all_banner() {
                axios.get('/website/banner')
                    .then(res => {
                        this.banners = res.data.data
                    })
            },
            get_all_cv() {
                axios.get('/website/cv/info')
                    .then(res => {
                        this.total_cv = res.data.data
                    })
            }
        },
    }
</script>

<style scoped>

    .car_ban:before {
        position: absolute;
        content: '';
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #262626;
        opacity: 0.5;
        z-index: -9;
        border-radius: 5px;
    }
</style>
