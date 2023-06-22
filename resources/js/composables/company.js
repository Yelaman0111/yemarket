import { ref } from "vue";
import axios from "axios";
import { useCookies } from "vue3-cookies";

export default function useAuth() {
    const company = ref([]);
    const companyProducts = ref([]);
    const products = ref([]);
    const { cookies } = useCookies();
    const token = "Bearer " + cookies.get("Bearer");
    const pages_count = ref([]);
    const current_page = ref([]);

    const getCompany = async () => {
        const config = {
            headers: { Authorization: token },
        };
        const response = await axios.get(`/api/v1/company/show`, config);

        company.value = response.data.data;
    };

    const getCompanyProducts = async (page) => {
        const config = {
            headers: { Authorization: token },
        };
        const response = await axios.get(
            "/api/v1/company/products?page=" + page,
            config
        );

        companyProducts.value = response.data.data;
        pages_count.value = response.data.last_page;
        current_page.value = response.data.current_page;
    };

    const storeProduct = async (formData) => {
        const config = {
            headers: {
                Authorization: token,
            },
        };

        await axios.post("/api/v1/company/products/connect", formData, config);
    };

    return {
        company,
        companyProducts,
        products,
        pages_count,
        current_page,
        getCompany,
        getCompanyProducts,
        storeProduct,
    };
}
