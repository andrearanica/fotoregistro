import { useEffect, useState } from 'react'
import { Navigate } from 'react-router-dom'
import axios from 'axios'

function StudentDashboard () {

    const [role, setRole] = useState('')

    useEffect(() => {
        const token = window.localStorage.getItem('token')
        axios.post('http://localhost:8080/role', { token: token })
        .then(res => {
            setRole(res.data.role)
        })
    })

    return (
        <div className="container my-5">
            { window.localStorage.getItem('token') ? null : <Navigate to="/sign-in" /> }
            { role ? role === 'student' ? null : <Navigate to="/dashboard/teacher" /> : null}
            <h1>Studente</h1>
        </div>
    )

}

export default StudentDashboard