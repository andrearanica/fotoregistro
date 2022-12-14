import { User } from '../models/User.js'

export const showInfo = async (req, res) => {
    const { email } = req.params
    try {
        const user = await User.findOne({ email })
        if (user) {
            return res.status(200).json({ name: user.name, surname: user.surname, email: user.email, class: user.class, role: user.role })
        } else {
            return res.status(404).json({ message: 'User not found' })
        }
    } catch (error) {
        return res.status(404).json({ message: error.message })
    }
}

export const getRole = async (req, res) => {
    const { token } = req.body
}