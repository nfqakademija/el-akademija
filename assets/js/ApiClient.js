import axios from "axios"
const queryString = require('query-string');
const qs = require('qs');


class ApiClient {
    get(url) {
        return axios.get(url).then((response) => response.data);
    }
    post(url, params) {
        console.log(qs.stringify(params));
        return axios.post(url, qs.stringify(params)).then((response) => response);
    }
}

export default new ApiClient();