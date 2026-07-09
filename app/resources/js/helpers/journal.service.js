import axios from "@/axios";

export default {

    getAll(params = {}) {
        return axios.get("/journal-entries", { params });
    },

    get(id) {
        return axios.get(`/journal-entries/${id}`);
    },

    create(data) {
        return axios.post("/journal-entries", data);
    },

    update(id, data) {
        return axios.put(`/journal-entries/${id}`, data);
    },

    delete(id) {
        return axios.delete(`/journal-entries/${id}`);
    },

    post(id) {
        return axios.post(`/journal-entries/${id}/post`);
    },

    void(id, data) {
        return axios.post(`/journal-entries/${id}/void`, data);
    }

}