import axios from 'axios'
import { useState } from 'react'

function Login () {

    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')

    function handleSubmit (e) {
        e.preventDefault()
        axios.post('http://localhost:5000/login', { email: email, password: password })
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
            Non sei registrato? Clicca <a href="/sign-up">qui</a>
        </div>
    )

}

export default Login