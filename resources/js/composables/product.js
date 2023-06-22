import { ref } from "vue";
import axios from "axios";
import { useCookies } from "vue3-cookies";

export default function useProduct() {
    const product = ref([]);
    const pages_count = ref([]);
    const current_page = ref([]);
    const products = ref([]);
    const { cookies } = useCookies();
    const token = "Bearer " + cookies.get("Bearer");

    const storeProduct = async (formData) => {
        const config = {
            headers: {
                Authorization: token,
                "content-type": "multipart/form-data",
            },
        };

        let response = await axios.post(
            "/api/v1/company/products/create",
            formData,
            config
        );
        product.value = response.data.data;
    };

    const getProducts = async (page) => {
        const config = {
            headers: {
                Authorization: token,
            },
        };

        let response = await axios.get(
            "/api/v1/company/products/all?page=" + page,
            config
        );
        products.value = response.data.data;
        pages_count.value = response.data.last_page;
        current_page.value = response.data.current_page;
    };

    return {
        product,
        products,
        pages_count,
        current_page,
        storeProduct,
        getProducts,
    };
}
