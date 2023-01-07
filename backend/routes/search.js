import express from 'express'
import { showInfo } from '../controllers/search.js'

const router = express.Router()

router.post('/student/:email', showInfo)

export default router