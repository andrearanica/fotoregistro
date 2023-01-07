import { Navigate } from 'react-router-dom'

function Dashboard () {
    return (
        <div className="container my-5">
            { window.localStorage.getItem('token') ? null : <Navigate to="/" /> }
            <h1>🎉 Benvenuto</h1>
        </div>
    )
}

export default Dashboard