import { ref } from "vue";
import axios from "axios";
import { useCookies } from "vue3-cookies";

export default function useBrands() {
    const brandsAll = ref([]);
    const { cookies } = useCookies();
    const token = "Bearer " + cookies.get("Bearer");

    const getAllBrands = async () => {
        const config = {
            headers: { Authorization: token },
        };
        let response = await axios.get("/api/v1/company/brands", config);
        brandsAll.value = response.data.data;
    };
    return {
        brandsAll,
        getAllBrands,
    };
}
