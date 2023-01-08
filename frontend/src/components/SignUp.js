import { useState } from 'react'
import axios from 'axios'
import { Link } from 'react-router-dom'

function SignUp () {

    const [name, setName] = useState('')
    const [surname, setSurname] = useState('')
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [role, setRole] = useState('student')
    const [classroom, setClassroom] = useState('')
    const [success, setSuccess] = useState(0)
    const [loading, setLoading] = useState(false)

    function handleSubmit (e) {
        e.preventDefault()
        setLoading(true)
        axios.post('http://localhost:8080/register', { name: name, surname: surname, email: email, password: password, role: role, classroom: classroom })
        .then(() => { setSuccess(1); setLoading(false); })
        .catch(() => { setSuccess(2) })
    }

    return (
        <div className="container my-5">
            <h1>🚀 Registrazione</h1>
            <form onSubmit={ handleSubmit }>
                <input type="text"     className="form-control my-1" placeholder="Nome"     onChange={ e => setName(e.target.value) } />
                <input type="text"     className="form-control my-1" placeholder="Cognome"  onChange={ e => setSurname(e.target.value) } />
                <input type="email"    className="form-control my-1" placeholder="Email"    onChange={ e => setEmail(e.target.value) } />
                <input type="password" className="form-control my-1" placeholder="Password" onChange={ e => setPassword(e.target.value) } />
                <select name="Ruolo" className="form-control" onChange={ e => setRole(e.target.value) }>
                    <option value="student">Studente</option>
                    <option value="teacher">Insegnante</option>
                </select>
                { role === 'student' ? <input type="text"     className="form-control my-1" placeholder="Classe"   onChange={ e => setClassroom(e.target.value) } /> : null  }
                <input type="submit"   className="form-control my-1" value="Invia" />
            </form>
            { loading ? <div className="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div> : null }
            { success !== 1 ? <p>Già registrato? Clicca <Link to="/sign-in">qui</Link></p> : null }
            { success === 1 ? <div className="my-2 alert alert-success text-center">Account creato correttamente, clicca <Link to="/sign-in">qui</Link> per effettuare il login</div> : success === 2 ? <div className="my-2 alert alert-danger text-center">Questa email è già in uso</div> : null }
        </div>
    )

}

export default SignUp