class Evaluation {
    static get(params, then, error) {
        axios.get('/evaluations', {
            params: params
        })
        .then(({data}) => then(data))
        .catch(({response}) => error(response.data.errors));
    }

    static store(data, then, error) {
        axios.post('/evaluations', data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static show(element, then, error) {
        axios.get('/evaluations/'+element)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static update(element, data, then, error) {
        axios.put('/evaluations/' + element, data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static destroy(element, then) {
        axios.delete('/evaluations/' + element)
            .then(({data}) => then(data));
    }

}

export default Evaluation;