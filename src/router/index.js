import {createRouter, createWebHistory} from 'vue-router';
import HomeView from '@/views/HomeView.vue';
import RetailerSignUpView from '@/views/RetailerSignUpView.vue';
import DistributorSignUpView from '@/views/DistributorSignUpView.vue';
import SignInView from '@/views/SignInView.vue';
import CartView from '@/views/CartView.vue';
import RetailerProfileView from '@/views/RetailerProfileView.vue';
import distributorProfileView from '@/views/distributorProfileView.vue';
import RetailerMyOrderView from '@/views/RetailerMyOrderView.vue';
import distributorHomeView from '@/views/distributorHomeView.vue';
import ProductView from '@/views/ProductView.vue';
import RetailerHomeView from '@/views/retailerHomeView.vue';
import RetailerProductView from '@/views/retailerProductView.vue';
import distributorProductView from '@/views/distributorProductView.vue';
import RetailerSearchView from '@/views/RetailerSearchView.vue';
import RetailerCategoryProducts from '@/components/retailerCategoryProducts.vue';
import RetailerCategoryProductsView from '@/views/retailerCategoryProductsView.vue';
import DistributorSearchView from '@/views/distributorSearchView.vue';
import distributorCategoryProductsView from '@/views/distributorCategoryProductsView.vue';
import distributorMyOrderView from '@/views/distributorMyOrderView.vue';
import searchedProductView from '@/views/searchedProductView.vue';
import categoryProductsView from '@/views/categoryProductsView.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/cart',
            name: 'cart',
            component: CartView
        },
        {
            path:'/signin',
            name: 'signin',
            component: SignInView
        },
        {
            path: '/signup/Distributor',
            name: 'signupDistributor',
            component: DistributorSignUpView
        },
        {
            path: '/signup/Retailer',
            name: 'signupRetailer',
            component: RetailerSignUpView
        },
        {
            path: '/retailer/cart',
            name: 'retailercart',
            component: CartView
        },
        {
            path: '/retailer/profile',
            name: 'retailerprofile',
            component: RetailerProfileView
        },
        {
            path: '/distributor/profile',
            name: 'distributorprofile',
            component: distributorProfileView
        },
        {
            path: '/retailer/myorder',
            name: 'retailermyorder',
            component:RetailerMyOrderView

        },
        {
            path: '/distributor/homepage',
            name: 'distributorhomepage',
            component: distributorHomeView
        },
        {
            path: '/product/page',
            name: 'productpage',
            component: ProductView
        },
        {
            path: '/retailer/homepage',
            name: 'retailerhomepage',
            component: RetailerHomeView
        },
        {
            path: '/retailer/product/page',
            name: 'retailerproductpage',
            component: RetailerProductView
        },
        {
            path: '/distributor/product/page',
            name: 'distributorproductpage',
            component: distributorProductView
        },
        {
            path: '/retailer/search/product/page',
            name: 'retailersearchproductpage',
            component: RetailerSearchView
        },
        {
            path: '/retailer/category/products/page',
            name: 'retailercategoryproductspage',
            component: RetailerCategoryProductsView

        },
        {
            path: '/distributor/search/product/page',
            name: 'distributorsearchproductpage',
            component: DistributorSearchView
        },
        {
            path: '/distributor/category/products/page',
            name: 'distributorcategoryproductspage',
            component:  distributorCategoryProductsView
        },
        {
            path: '/distributor/myorder',
            name: 'distributormyorder',
            component:distributorMyOrderView
        },
        {
            path: '/search/product/page',
            name: 'searchproductpage',
            component: searchedProductView
        },
        {
            path: '/category/products/page',
            name: 'categoryproductspage',
            component: categoryProductsView
        },


    ]
});
export default router;
