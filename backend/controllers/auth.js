import { User } from '../models/User.js'
import bcrypt from 'bcrypt'
import jwt from 'jsonwebtoken'

const JWT_SECRET = 'bfbnfapbnfpbnfaiibfap'

export const register = async (req, res) => {    
    try {
        const { name, surname, email, password, role, classroom } = req.body
        try {
            const hashedPassword = await bcrypt.hash(password, 15)
            await User.create({ name: name, surname: surname, email: email, password: hashedPassword, role: role, classroom: classroom })
            return res.status(201).json({ message: 'ok' })
        } catch (error) {
            return res.status(400).json({ message: error.message })
        }
    } catch (error) {
        return res.status(400).json({ message: error.message })
    }
}

export const login = async (req, res) => {
    try {
        const { email, password } = req.body
        const user = await User.findOne({ email })

        if (!user) {
            return res.status(404).json({ message: 'User not found' })
        } else {
            if (await bcrypt.compare(password, user.password)) {
                const token = jwt.sign({
                    id: user._id,
                    name: user.name,
                    surname: user.surname,
                    email: user.email,
                    role: user.role,
                    classroom: user.classroom
                }, JWT_SECRET)
                return res.status(200).json({ token: token })
            }
        }
        return res.status(400).json({ message: 'User not found' })
    } catch (error) {
        return res.status(400).json({ message: error.message })
    }
}

export const getInfo = async (req, res) => {
    try {
        const { token } = req.body
        jwt.verify(token, JWT_SECRET, (error, user) => {
            res.status(201).json({ name: user.name, surname: user.surname, role: user.role })
        })
    } catch (error) {
        return res.status(400).json({ message: error.message })
    }
}