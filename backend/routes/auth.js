import express from 'express'
import { register, login, getRole } from '../controllers/auth.js'

const router = express.Router()

router.post('/register', register)
router.post('/login', login)
router.post('/role', getRole)

export default router