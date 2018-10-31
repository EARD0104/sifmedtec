class Month {
    static get(params, then) {
        axios.get('/api/months', {
            params: params
        })
        .then(({data}) => then(data));
    }

}

export default Month;