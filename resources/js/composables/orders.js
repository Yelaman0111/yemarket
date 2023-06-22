import { ref } from "vue";
import axios from "axios";
import { useCookies } from "vue3-cookies";

export default function useOrders() {
    const orders = ref([]);
    const { cookies } = useCookies();
    const token = "Bearer " + cookies.get("Bearer");

    const getOrders = async () => {
        const config = {
            headers: { Authorization: token },
        };
        let response = await axios.get("/api/v1/company/orders", config);
        orders.value = response.data.data;
    };
    return {
        orders,
        getOrders,
    };
}
