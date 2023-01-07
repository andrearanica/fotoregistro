import axios from 'axios'
import { useState } from 'react'
import { Link, Navigate } from 'react-router-dom'

function Login () {

    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [success, setSuccess] = useState(0)
    const [loading, setLoading] = useState(false)

    function handleSubmit (e) {
        e.preventDefault()
        setLoading(true)
        axios.post('http://localhost:8080/login', { email: email, password: password })
        .then((res) => {
            console.log(res)
            setSuccess(1)
            window.localStorage.setItem('token', res.data.token)
            setLoading(false)
        })
        .catch(() => {
            setSuccess(2)
            setLoading(false)
        })
    }

    return (
        <div className="container my-5">
            { window.localStorage.getItem('token') ? <Navigate to="/dashboard" /> : null }
            <h1>🎉 Login</h1>
            <form onSubmit={ handleSubmit }>
                <input type="email"    className="form-control my-1" placeholder="Email"    onChange={ e => setEmail(e.target.value) }    />
                <input type="password" className="form-control my-1" placeholder="Password" onChange={ e => setPassword(e.target.value) } />
                <input type="submit"   className="form-control my-1" value="Invia" />
            </form>
            { loading ? <div className="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div> : null }
            <p>Non sei registrato? Clicca <Link to="/sign-up">qui</Link></p>
            { success === 1 ? <Navigate to="/dashboard" /> : success === 2 ? <div className="my-2 alert alert-danger text-center">Email o password non corrette</div> : null }
        </div>
    )

}

export default Login