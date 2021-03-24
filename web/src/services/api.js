import axios from 'axios';

const api = axios.create({
  baseURL: `http://my-savings.test/api`,
});

export default api;