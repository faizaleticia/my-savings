import axios from 'axios';

const api = axios.create({
  baseURL: `http://177.44.248.51:8080/api`,
});

export default api;
