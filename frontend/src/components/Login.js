import axios from 'axios'
import { useState } from 'react'
import { Link } from 'react-router-dom'

function Login () {

    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')

    function handleSubmit (e) {
        e.preventDefault()
        axios.post('http://localhost:8080/login', { email: email, password: password })
        .then(res => console.log(res))
    }

    return (
        <div className="container my-5">
            <h1>🎉 Login</h1>
            <form onSubmit={ handleSubmit }>
                <input type="email"    className="form-control my-1" placeholder="Email"    onChange={ e => setEmail(e.target.value) }    />
                <input type="password" className="form-control my-1" placeholder="Password" onChange={ e => setPassword(e.target.value) } />
                <input type="submit"   className="form-control my-1" value="Invia" />
            </form>
            Non sei registrato? Clicca <Link to="/sign-up">qui</Link>
        </div>
    )

}

export default Login