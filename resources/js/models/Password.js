class Password {
    static store(data, then, error) {
        axios.post('/api/passwords', data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

}

export default Password;