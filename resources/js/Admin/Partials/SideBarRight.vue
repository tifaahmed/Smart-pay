<template>

    <div>
        <!-- main-sidebar -->
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <aside class="app-sidebar sidebar-scroll">
            <div class="main-sidebar-header active" style="padding: 0;">
                <a class="desktop-logo logo-light active" href="#">
                    <img :src="PropLogo" class="main-logo" alt="logo" style="height: 60px;"></a>
                <a class="desktop-logo logo-dark active" href="#">
                    <img :src="PropLogo" class="main-logo dark-theme" alt="logo" style="height: 60px;"></a>
                <a class="logo-icon mobile-logo icon-light active" href="#">
                    <img :src="PropLogo" class="logo-icon" alt="logo" style="height: 60px;"></a>
                <a class="logo-icon mobile-logo icon-dark active" href="#">
                    <img :src="PropLogo" class="logo-icon dark-theme" alt="logo" style="height: 60px;" ></a>
            </div>

            <div class="main-sidemenu" style="overflow: scroll;">
                <div class="app-sidebar__user clearfix">
                    <div class="dropdown user-pro-body">
                        <div class="">
                            <img :src="PropAvatar" alt="user-img" class="avatar avatar-xl brround">
                        </div>
                        <div class="user-info">
                            <h4 class="font-weight-semibold mt-3 mb-0">{{PropName}}</h4>
                            <span class="mb-0 text-muted">  </span>
                        </div>
                    </div>
                </div>
                <ul class="side-menu">
                    <li class="slide">
                        <router-link class="side-menu__item" data-toggle="slide" :to = "{ name : 'SiteSetting.All' }">
                            <svg   class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/>
                                <path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                            </svg>
                            <span class="side-menu__label">SiteSetting</span>
                        </router-link>
                    </li>
                    <li class="slide">
                        <router-link class="side-menu__item" data-toggle="slide" :to = "{ name : 'Role.All' }">
                            <svg   class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/>
                                <path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                            </svg>
                            <span class="side-menu__label">Role</span>
                        </router-link>
                    </li>
                    <li class="slide">
                        <router-link class="side-menu__item" data-toggle="slide" :to = "{ name : 'User.All' }">
                            <svg   class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/>
                                <path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                            </svg>
                            <span class="side-menu__label">User</span>
                        </router-link>
                    </li>
                    <li class="slide">
                        <router-link class="side-menu__item" data-toggle="slide" :to = "{ name : 'FoodSection.All' }">
                            <svg   class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/>
                                <path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                            </svg>
                            <span class="side-menu__label">FoodSection</span>
                        </router-link>
                    </li>
                    <li class="slide">
                        <router-link class="side-menu__item" data-toggle="slide" :to = "{ name : 'Store.All' }">
                            <svg   class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/>
                                <path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                            </svg>
                            <span class="side-menu__label">Store</span>
                        </router-link>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M6.26 9L12 13.47 17.74 9 12 4.53z" opacity=".3"></path><path d="M19.37 12.8l-7.38 5.74-7.37-5.73L3 14.07l9 7 9-7zM12 2L3 9l1.63 1.27L12 16l7.36-5.73L21 9l-9-7zm0 11.47L6.26 9 12 4.53 17.74 9 12 13.47z"></path></svg><span class="side-menu__label">Elements</span><i class="angle fe fe-chevron-down"></i></a>


                        <ul class="slide-menu">
                            <li>
                                <router-link  :to = "{ name : 'ProductCategory.All' }">
                                    <a class="slide-item" >ProductCategory</a>
                                </router-link>
                            </li>
                            <li>
                                <router-link  :to = "{ name : 'ProductItem.All' }">
                                    <a class="slide-item" >ProductItem</a>
                                </router-link>
                            </li>
                            <li>
                                <router-link  :to = "{ name : 'ExtraCategory.All' }">
                                    <a class="slide-item" >ExtraCategory</a>
                                </router-link>
                            </li>
                            <li>
                                <router-link  :to = "{ name : 'Extra.All' }">
                                    <a class="slide-item" >Extra</a>
                                </router-link>
                            </li>
                        </ul>
                    </li>


 
                    <li class="slide">
                        <router-link class="side-menu__item" data-toggle="slide" :to = "{ name : 'Coupon.All' }">
                            <svg   class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/>
                                <path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                            </svg>
                            <span class="side-menu__label">Coupon</span>
                        </router-link>
                    </li>
                    <li class="slide">
                        <router-link class="side-menu__item" data-toggle="slide" :to = "{ name : 'Order.All' }">
                            <svg   class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/>
                                <path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                            </svg>
                            <span class="side-menu__label">Order</span>
                        </router-link>
                    </li>
                    <li class="slide">
                        <router-link class="side-menu__item" data-toggle="slide" :to = "{ name : 'Subscription.All' }">
                            <svg   class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/>
                                <path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                            </svg>
                            <span class="side-menu__label">Subscription</span>
                        </router-link>
                    </li>
                    <li class="slide">
                        <router-link class="side-menu__item" data-toggle="slide" :to = "{ name : 'Address.All' }">
                            <svg   class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/>
                                <path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                            </svg>
                            <span class="side-menu__label">address</span>
                        </router-link>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="#">
							<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/>
                            <path d="M12 4C9.24 4 7 6.24 7 9c0 2.85 2.92 7.21 5 9.88 2.11-2.69 5-7 5-9.88 0-2.76-2.24-5-5-5zm0 7.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" opacity=".3"/>
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"/><circle cx="12" cy="9" r="2.5"/></svg>
                            <span class="side-menu__label">Maps</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            <li>
                                <router-link  :to = "{ name : 'Country.All' }">
                                    <a class="slide-item" >Country</a>
                                </router-link>
                            </li>
                            <li>
                                <router-link  :to = "{ name : 'Government.All' }">
                                    <a class="slide-item" >Government</a>
                                </router-link>
                            </li>
                            <li>
                                <router-link  :to = "{ name : 'City.All' }">
                                    <a class="slide-item" >City</a>
                                </router-link>
                            </li>
                        </ul>
                    </li>


                </ul>
            </div>
        </aside>
    </div>
</template>
<!-- main-sidebar -->

<script>
// import jwt   from './../../Services/jwt' ;
// jwt.User
    export default {

        mounted() {
            console.log( 'side_bar_right ' )
            // console.log( jwt.User )
        },
        data( ) { return {
            // User :jwt.User ,
            logo: ''

        } } ,
		props : {
			PropLogo : null,
            PropAvatar : null,
			PropName : null,
		},  
        
    }
</script>