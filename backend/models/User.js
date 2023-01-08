import mongoose from "mongoose"

const userSchema = new mongoose.Schema({
    name: {
        type: String,
        require: true    
    },
    surname: {
        type: String,
        require: true    
    },
    email: {
        type: String,
        require: true,
        unique: true
    },
    password: {
        type: String,
        require: true    
    },
    classroom: {
        type: String,
        require: true
    },
    role: {
        type: String,
        require: true
    }
}, { timestamps: true })

export const User = mongoose.model('User', userSchema)