import { ref } from "vue";
import axios from "axios";
import { useCookies } from "vue3-cookies";

export default function useAdmin() {
    const companies = ref([]);
    const shops = ref([]);
    const categories = ref([]);
    const allProducts = ref([]);
    const brands = ref([]);
    const shopOrders = ref([]);
    const parentCategories = ref([]);
    const companiesProducts = ref([]);
    const companiesOrders = ref([]);
    const orders_pages_count = ref([]);
    const orders_current_page = ref([]);
    const shop_orders_pages_count = ref([]);
    const shop_orders_current_page = ref([]);
    const products_pages_count = ref([]);
    const products_current_page = ref([]);
    const all_products_current_page = ref([]);
    const all_products_pages_count = ref([]);
    const { cookies } = useCookies();
    const token = "Bearer " + cookies.get("Bearer");

    const getAllCompanies = async () => {
        const config = {
            headers: { Authorization: token },
        };
        let response = await axios.get("/api/v1/admin/companies", config);
        companies.value = response.data.data;
    };
    const getAllShops = async () => {
        const config = {
            headers: { Authorization: token },
        };
        let response = await axios.get("/api/v1/admin/shops", config);
        shops.value = response.data.data;
    };
    const getAllCategories = async () => {
        const config = {
            headers: { Authorization: token },
        };
        let response = await axios.get("/api/v1/admin/categories", config);
        categories.value = response.data.data;
    };
    const getAllBrands = async () => {
        const config = {
            headers: { Authorization: token },
        };
        let response = await axios.get("/api/v1/admin/brands", config);
        brands.value = response.data.data;
    };
    const getAllProducts = async (page) => {
        const config = {
            headers: { Authorization: token },
        };
        let response = await axios.get(
            "/api/v1/admin/products?page=" + page,
            config
        );
        allProducts.value = response.data.data;
        all_products_pages_count.value = response.data.meta.last_page;
        all_products_current_page.value = response.data.meta.current_page;
    };
    const getParentCategories = async () => {
        const config = {
            headers: { Authorization: token },
        };
        let response = await axios.get(
            "/api/v1/admin/parentcategories",
            config
        );
        parentCategories.value = response.data.data;
    };
    const getCompaniesProducts = async (company_id, page) => {
        const config = {
            headers: { Authorization: token },
        };
        let response = await axios.get(
            `/api/v1/admin/companies/${company_id}/products?page=${page}`,
            config
        );
        companiesProducts.value = response.data.data;
        products_pages_count.value = response.data.meta.last_page;
        products_current_page.value = response.data.meta.current_page;
    };

    const getCompaniesOrders = async (company_id, page) => {
        const config = {
            headers: { Authorization: token },
        };
        let response = await axios.get(
            `/api/v1/admin/companies/${company_id}/orders?page=${page}`,
            config
        );
        companiesOrders.value = response.data.data;
        orders_pages_count.value = response.data.meta.last_page;
        orders_current_page.value = response.data.meta.current_page;
    };

    const getShopOrders = async (shop_id, page) => {
        const config = {
            headers: { Authorization: token },
        };
        let response = await axios.get(
            `/api/v1/admin/shops/${shop_id}/orders?page=${page}`,
            config
        );
        shopOrders.value = response.data.data;
        shop_orders_pages_count.value = response.data.meta.last_page;
        shop_orders_current_page.value = response.data.meta.current_page;
    };

    return {
        companies,
        shopOrders,
        shops,
        categories,
        brands,
        companiesProducts,
        companiesOrders,
        orders_current_page,
        products_current_page,
        orders_pages_count,
        products_pages_count,
        parentCategories,
        allProducts,
        all_products_pages_count,
        all_products_current_page,
        shop_orders_pages_count,
        shop_orders_current_page,
        getAllCompanies,
        getCompaniesProducts,
        getCompaniesOrders,
        getAllCategories,
        getParentCategories,
        getAllBrands,
        getAllProducts,
        getAllShops,
        getShopOrders,
    };
}
