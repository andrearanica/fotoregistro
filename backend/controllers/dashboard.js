import { User } from '../models/User.js'

export const showInfo = async (req, res) => {
    const { email } = req.body
    try {
        const user = await User.findOne({ email })
        console.log(user)
        if (user) {
            return res.status(200).json({ name: user.name, surname: user.surname, email: user.email })
        } else {
            return res.status(404).json({ message: 'User not found' })
        }
    } catch (error) {
        return res.status(404).json({ message: error.message })
    }
}