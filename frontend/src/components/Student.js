import { useEffect, useState } from 'react'
import { useParams } from "react-router-dom"
import axios from 'axios'

function Student () {
    
    const { email } = useParams()

    const [student, setStudent] = useState({})

    useEffect(() => {
        axios.post(`http://localhost:8080/student/${ email }`)
        .then(res => setStudent(res.data))
    }, [email])
    
    return (
        <div className="container my-5">
            <h1>Profilo di { student.name }</h1>
            <p>Nome:    { student.name }   </p>
            <p>Cognome: { student.surname }</p>
            <p>Email:   { student.email }  </p>
        </div>
    )

}

export default Student