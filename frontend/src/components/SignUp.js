import { useState } from 'react'
import axios from 'axios'
import { Link, Navigate } from 'react-router-dom'

function SignUp () {

    const [name, setName] = useState('')
    const [surname, setSurname] = useState('')
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [success, setSuccess] = useState(0)

    function handleSubmit (e) {
        e.preventDefault()
        axios.post('http://localhost:8080/register', { name: name, surname: surname, email: email, password: password })
        .then(() => { setSuccess(1) })
        .catch(() => { setSuccess(2) })
    }

    return (
        <div className="container my-5">
            { window.localStorage.getItem('token') ? <Navigate to="/dashboard" /> : null }
            <h1>🚀 Registrazione</h1>
            <form onSubmit={ handleSubmit }>
                <input type="text"     className="form-control my-1" placeholder="Nome"     onChange={ e => setName(e.target.value) } />
                <input type="text"     className="form-control my-1" placeholder="Cognome"  onChange={ e => setSurname(e.target.value) } />
                <input type="email"    className="form-control my-1" placeholder="Email"    onChange={ e => setEmail(e.target.value) } />
                <input type="password" className="form-control my-1" placeholder="Password" onChange={ e => setPassword(e.target.value) } />
                <input type="submit"   className="form-control" value="Invia" />
            </form>
            { success !== 1 ? <p>Già registrato? Clicca <Link to="/sign-in">qui</Link></p> : null }
            { success === 1 ? <div className="my-2 alert alert-success text-center">Account creato correttamente, clicca <Link to="/sign-in">qui</Link> per effettuare il login</div> : success === 2 ? <div className="my-2 alert alert-danger text-center">Questa email è già in uso</div> : null }
        </div>
    )

}

export default SignUp