import axios from 'axios';

const api = axios.create({
  baseURL: `http://177.44.248.51:8181/api`,
});

export default api;
