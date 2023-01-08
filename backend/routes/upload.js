import express from 'express'
import { uploadFile } from '../controllers/upload.js'

const router = express.Router()

router.post('/upload', uploadFile)

export default router