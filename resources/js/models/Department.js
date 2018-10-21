class Department {
    static get(params, then) {
        axios.get('/api/departments', {
            params: params
        })
        .then(({data}) => then(data));
    }

    static store(data, then, error) {
        axios.post('/api/departments', data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static update(element, data, then, error) {
        axios.put('/api/departments/' + element, data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static destroy(element, then) {
        axios.delete('/api/departments/' + element)
            .then(({data}) => then(data));
    }

}

export default Department;