import { useState } from 'react'
import axios from 'axios'

function SignUp () {

    const [name, setName] = useState('')
    const [surname, setSurname] = useState('')
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')

    function handleSubmit (e) {
        e.preventDefault()
        axios.post('http://localhost:5000/register', { name: name, surname: surname, email: email, password: password })
    }

    return (
        <div className="container my-5">
            <h1>🚀 SignUp</h1>
            <form onSubmit={ handleSubmit }>
                <input type="text"     className="form-control my-1" placeholder="Nome"     onChange={ e => setName(e.target.value) } />
                <input type="text"     className="form-control my-1" placeholder="Cognome"  onChange={ e => setSurname(e.target.value) } />
                <input type="email"    className="form-control my-1" placeholder="Email"    onChange={ e => setEmail(e.target.value) } />
                <input type="password" className="form-control my-1" placeholder="Password" onChange={ e => setPassword(e.target.value) } />
                <input type="submit"   className="form-control" value="Invia" />
            </form>
            Già registrato? Clicca <a href="/sign-in">qui</a>
        </div>
    )

}

export default SignUp