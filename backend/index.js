import express from "express"
import mongoose from 'mongoose'
import cors from 'cors'
import fileUpload from 'express-fileupload'

import authRouter from './routes/auth.js'
import searchRouter from './routes/search.js'
import uploadRouter from './routes/upload.js'

const app = express()
const PORT = 8080
const CONNECTION_URL = 'mongodb://localhost:27017/fotoregistro'

app.use(cors())
app.use(express.json())
app.use(fileUpload())
app.use(authRouter)
app.use(searchRouter)
app.use(uploadRouter)

mongoose.set('strictQuery', false)
mongoose.connect(CONNECTION_URL)
.then(() => {
    app.listen(PORT, () => {
        console.log(`Server running on port ${PORT}`)
    })
})