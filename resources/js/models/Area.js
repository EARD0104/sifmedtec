class Area {
    static get(params, then) {
        axios.get('/api/areas', {
            params: params
        })
        .then(({data}) => then(data));
    }

    static store(data, then, error) {
        axios.post('/api/areas', data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static update(element, data, then, error) {
        axios.put('/api/areas/' + element, data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static destroy(element, then) {
        axios.delete('/api/areas/' + element)
            .then(({data}) => then(data));
    }

}

export default Area;