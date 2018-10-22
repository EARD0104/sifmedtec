class Theme {
    static get(params, then) {
        axios.get('/api/themes', {
            params: params
        })
        .then(({data}) => then(data));
    }

    static store(data, then, error) {
        axios.post('/api/themes', data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static update(element, data, then, error) {
        axios.put('/api/themes/' + element, data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static destroy(element, then) {
        axios.delete('/api/themes/' + element)
            .then(({data}) => then(data));
    }

    static show(element, then) {
        axios.get('/api/themes/' + element)
            .then(({data}) => then(data));
    }

}

export default Theme;