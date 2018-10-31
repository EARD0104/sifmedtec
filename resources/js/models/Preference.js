class Preference {
    static update(element, data, then, error) {
        axios.put('/api/preferences/' + element, data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

    static show(element, then) {
        axios.get('/api/preferences/' + element)
            .then(({data}) => then(data));
    }

}

export default Preference;