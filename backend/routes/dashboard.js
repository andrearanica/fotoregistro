import express from 'express'
import { showInfo } from '../controllers/dashboard.js'

const router = express.Router()

router.post('/dashboard', showInfo)

export default router