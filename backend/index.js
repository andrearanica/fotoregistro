import express from "express"
import mongoose from 'mongoose'
import cors from 'cors'

import router from './routes/auth.js'

const app = express()
const PORT = 5000
const CONNECTION_URL = 'mongodb://localhost:27017/fotoregistro'

app.use(cors())
app.use(express.json())
app.use(router)

mongoose.set('strictQuery', false)
mongoose.connect(CONNECTION_URL)
.then(() => {
    app.listen(PORT, () => {
        console.log(`Server running on port ${PORT}`)
    })
})

app.post('/register', async (req, res) => {
    
})