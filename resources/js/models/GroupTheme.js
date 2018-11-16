class GroupTheme {

    static store(element, data, then, error) {
        axios.post('/api/groups/'+element+'/themes', data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }

}

export default GroupTheme;