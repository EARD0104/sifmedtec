class Role {
    static get(params, then) {
        axios.get('/api/roles', {
            params: params
        })
        .then(({data}) => then(data));
    }

    static store(data, then, error) {
        axios.post('/api/roles', data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static update(element, data, then, error) {
        axios.post('/api/roles/' + element, data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static destroy(element, then) {
        axios.delete('/api/roles/' + element)
            .then(({data}) => then(data));
    }

}

export default Role;