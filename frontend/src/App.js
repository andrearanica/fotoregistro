import './App.css'
import 'bootstrap/dist/css/bootstrap.css'
import { Routes, Route } from 'react-router-dom'
import Login from './components/Login.js'
import SignUp from './components/SignUp.js'
import TeacherDashboard from './components/TeacherDashboard.js'
import StudentDashboard from './components/StudentDashboard.js'
import Student from './components/Student.js'

function App() {
  return (
      <div>
        <nav className="navbar navbar-dark bg-dark">
          <div className="container-fluid">
            <a className="navbar-brand" href="/">
              Fotoregistro
            </a>
          </div>
        </nav>

        <div className="App">
          <Routes>
            <Route exact path="/"    element={ <Login /> } />
            <Route path="/sign-in"   element={ <Login /> } />
            <Route path="/sign-up"   element={ <SignUp/> } />
            <Route path="/dashboard/teacher" element={ <TeacherDashboard /> } />
            <Route path="/dashboard/student" element={ <StudentDashboard /> } />
            <Route path="/student/:email" element={ <Student /> } />
            <Route path="*" element={ <div className="container my-5"><h1>404 | Pagina non trovata</h1></div> }/>
          </Routes>
        </div>
      </div>      
  );
}

export default App
