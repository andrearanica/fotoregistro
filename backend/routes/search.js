import express from 'express'
import { showInfo, getRole } from '../controllers/search.js'

const router = express.Router()

router.post('/student/:email', showInfo)
router.post('/student/role', getRole)

export default router