import './App.css'
import 'bootstrap/dist/css/bootstrap.css'
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom'
import Login from './components/Login.js'
import SignUp from './components/SignUp.js'

function App() {
  return (
    <Router>
      <div className="App">
        <Routes>
          <Route exact path="/"  element={ <Login /> } />
          <Route path="/sign-in" element={ <Login /> } />
          <Route path="/sign-up" element={ <SignUp/> } />
        </Routes>
      </div>      
    </Router>
  );
}

export default App;
