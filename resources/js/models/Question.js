class Question {
    static get(params, then) {
        axios.get('/api/questions', {
            params: params
        })
        .then(({data}) => then(data));
    }

    static store(data, then, error) {
        axios.post('/api/questions', data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static update(element, data, then, error) {
        axios.put('/api/questions/' + element, data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static destroy(element, then) {
        axios.delete('/api/questions/' + element)
            .then(({data}) => then(data));
    }

    static show(element, then) {
        axios.get('/api/questions/' + element)
            .then(({data}) => then(data));
    }

}

export default Question;