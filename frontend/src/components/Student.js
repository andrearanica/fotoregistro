import { useParams } from "react-router-dom"

function Student () {
    const { id } = useParams()
    return (
        <div className="container my-1">
            <h1>Studente id { id }</h1>
        </div>
    )
}

export default Student