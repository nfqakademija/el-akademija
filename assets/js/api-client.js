import axios from "axios"
const qs = require('qs');


class ApiClient {
    get(url) {
        return axios.get(url).then((response) => response.data);
    }
    post(url, params) {
        return axios.post(url, qs.stringify(params)).then((response) => response);
    }
    all(requests) {
        return axios.all(requests).then((response) => response);
    }
    spread(requests) {
        return axios.spread(requests);
    }
}

export default new ApiClient();