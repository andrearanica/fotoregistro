import { useEffect, useState } from 'react'
import { Navigate } from 'react-router-dom'
import axios from 'axios'

function Dashboard () {

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
            { student.role ? student.role === 'teacher' ? null : <Navigate to="/dashboard/student" /> : null}
            <h1>🎉 Benvenuto</h1>
        </div>
    )

}

export default Dashboard