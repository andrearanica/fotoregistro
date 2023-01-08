import express from 'express'
import { register, login, getInfo } from '../controllers/auth.js'

const router = express.Router()

router.post('/register', register)
router.post('/login', login)
router.post('/info', getInfo)

export default router