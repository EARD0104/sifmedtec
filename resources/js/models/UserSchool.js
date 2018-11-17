class User {




    static update(element, data, then, error) {
        axios.put('/api/users-schools/' + element, data)
            .then(({data}) => then(data))
            .catch(({response}) => error(response.data.errors));
    }



}

export default User;