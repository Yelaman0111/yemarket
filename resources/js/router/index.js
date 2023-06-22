import { createRouter, createWebHistory } from "vue-router";
import IndexVue from "../components/IndexVue";
import CompanyLogin from "../components/company/CompanyLogin";
import CompanyIndex from "../components/company/CompanyIndex";
import CompanyProducts from "../components/company/CompanyProducts";
import CompanyOrders from "../components/company/CompanyOrders";
import AllProducts from "../components/company/AllProducts";
import CompanyCreateProduct from "../components/company/CompanyCreateProduct";
import CompanyConnectProduct from "../components/company/CompanyConnectProduct";
import companyEditProduct from "../components/company/companyEditProduct";
import PrivacyPolicy from "../components/PrivacyPolicy";
import AdminLogin from "../components/admin/login";
import AdminIndex from "../components/admin/index";
import AdminCompanyProducts from "../components/admin/AdminCompanyProducts";
import AdminCompanyOrders from "../components/admin/AdminCompanyOrders";
import AdminCategories from "../components/admin/AdminCategories";
import AdminCategoriesEdit from "../components/admin/AdminCategoriesEdit";
import AdminCategoriesCreate from "../components/admin/AdminCategoriesCreate";
import AdminBrands from "../components/admin/AdminBrands";
import AdminBrandsCreate from "../components/admin/AdminBrandsCreate";
import AdminBrandsEdit from "../components/admin/AdminBrandsEdit";
import AdminProductsCreate from "../components/admin/AdminProductsCreate";
import AdminProducts from "../components/admin/AdminProducts";
import AdminShops from "../components/admin/AdminShops";
import AdminShopOrders from "../components/admin/AdminShopOrders";

const routes = [
    {
        path: "/",
        name: "main.index",
        component: CompanyLogin,
    },
    {
        path: "/company/login",
        name: "company.login",
        component: CompanyLogin,
    },
    {
        path: "/company/index",
        name: "company.index",
        component: CompanyIndex,
    },
    {
        path: "/company/products",
        name: "company.products",
        component: CompanyProducts,
    },
    {
        path: "/company/orders",
        name: "company.orders",
        component: CompanyOrders,
    },
    {
        path: "/company/products/all",
        name: "company.products.all",
        component: AllProducts,
        props: true,
    },
    {
        path: "/company/products/create",
        name: "company.products.create",
        component: CompanyCreateProduct,
    },
    {
        path: "/company/products/connect",
        name: "company.products.connect",
        component: CompanyConnectProduct,
        props: true,
    },
    {
        path: "/company/products/edit",
        name: "company.products.edit",
        component: companyEditProduct,
        props: true,
    },
    {
        path: "/privacy",
        name: "privacy.index",
        component: PrivacyPolicy,
    },
    {
        path: "/admin/login",
        name: "admin.login",
        component: AdminLogin,
    },
    {
        path: "/admin",
        name: "admin.index",
        component: AdminIndex,
    },
    {
        path: "/admin/company/products",
        name: "admin.company.products",
        component: AdminCompanyProducts,
        props: true,
    },
    {
        path: "/admin/company/orders",
        name: "admin.company.orders",
        component: AdminCompanyOrders,
        props: true,
    },
    {
        path: "/admin/categories",
        name: "admin.categories",
        component: AdminCategories,
    },
    {
        path: "/admin/categories/edit",
        name: "admin.categories.edit",
        component: AdminCategoriesEdit,
        props: true,
    },
    {
        path: "/admin/categories/create",
        name: "admin.categories.create",
        component: AdminCategoriesCreate,
    },
    {
        path: "/admin/brands",
        name: "admin.brands",
        component: AdminBrands,
    },
    {
        path: "/admin/brands/create",
        name: "admin.brands.create",
        component: AdminBrandsCreate,
    },
    {
        path: "/admin/brands/edit",
        name: "admin.brands.edit",
        component: AdminBrandsEdit,
        props: true,
    },

    {
        path: "/admin/products",
        name: "admin.products",
        component: AdminProducts,
    },
    {
        path: "/admin/products/create",
        name: "admin.products.create",
        component: AdminProductsCreate,
    },
    {
        path: "/admin/shops",
        name: "admin.shops",
        component: AdminShops,
    },
    {
        path: "/admin/shop/orders",
        name: "admin.shop.orders",
        component: AdminShopOrders,
        props: true,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
