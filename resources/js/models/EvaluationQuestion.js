class Evaluation {
    static get(params, then) {
        axios.get('/evaluation-questions', {
            params: params
        })
        .then(({data}) => then(data));
    }


}

export default Evaluation;