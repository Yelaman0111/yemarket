import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useCookies } from "vue3-cookies";

export default function useCategories() {
    const categories = ref([]);
    const categoriesAll = ref([]);
    const { cookies } = useCookies();
    const token = "Bearer " + cookies.get("Bearer");

    const getCategories = async () => {
        let response = await axios.get("/api/v1/categories");
        categories.value = response.data.data;
    };

    const getAllCategories = async () => {
        const config = {
            headers: { Authorization: token },
        };
        let response = await axios.get("/api/v1/company/categories", config);
        categoriesAll.value = response.data.data;
    };
    return {
        categories,
        categoriesAll,
        getCategories,
        getAllCategories,
    };
}
