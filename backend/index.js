import express from "express"
import mongoose from 'mongoose'
import cors from 'cors'

import authRouter from './routes/auth.js'
import searchRouter from './routes/search.js'

const app = express()
const PORT = 8080
const CONNECTION_URL = 'mongodb://localhost:27017/fotoregistro'

app.use(cors())
app.use(express.json())
app.use(authRouter)
app.use(searchRouter)

mongoose.set('strictQuery', false)
mongoose.connect(CONNECTION_URL)
.then(() => {
    app.listen(PORT, () => {
        console.log(`Server running on port ${PORT}`)
    })
})