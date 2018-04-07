import axios from "axios"

class ApiClient {
    get(url) {
        return axios.get(url).then((response) => Promise.resolve(response.data));
    }
}

export default new ApiClient();