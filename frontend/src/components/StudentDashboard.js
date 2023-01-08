import { useEffect, useState } from 'react'
import { Navigate } from 'react-router-dom'
import axios from 'axios'

function StudentDashboard () {

    const [student, setStudent] = useState({})

    useEffect(() => {
        const token = window.localStorage.getItem('token')
        axios.post('http://localhost:8080/info', { token: token })
        .then(res => {
            setStudent(res.data)
        })
    })

    return (
        <div className="container my-5">
            { window.localStorage.getItem('token') ? null : <Navigate to="/sign-in" /> }
            { student.role ? student.role === 'student' ? null : <Navigate to="/dashboard/teacher" /> : null}
            <h1>Ciao { student.name } 🎒 </h1>
            Questa è la tua dashboard: da qui puoi caricare la tua foto o modificare quella già caricata<br /><br />
            <form>
                <input type="file" />
                <input type="submit" />
            </form>
        </div>
    )

}

export default StudentDashboard