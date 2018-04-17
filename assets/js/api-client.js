import axios from "axios"
const qs = require('qs');


class ApiClient {
    get(url) {
        return axios.get(url).then((response) => response.data);
    }
    post(url, params) {
        return axios.post(url, qs.stringify(params)).then((response) => response);
    }
}

export default new ApiClient();