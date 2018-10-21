class Answer {
    static get(params, then) {
        axios.get('/api/answers', {
            params: params
        })
        .then(({data}) => then(data));
    }

    static store(data, then, error) {
        axios.post('/api/answers', data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static update(element, data, then, error) {
        axios.put('/api/answers/' + element, data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static destroy(element, then) {
        axios.delete('/api/answers/' + element)
            .then(({data}) => then(data));
    }

    static show(element, then) {
        axios.get('/api/answers/' + element)
            .then(({data}) => then(data));
    }

}

export default Answer;