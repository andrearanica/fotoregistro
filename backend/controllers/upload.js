export const uploadFile = (req, res) => {
    try {
        if (req.files) {
            const file = req.files.photo
            const fileName = file.name
            file.mv(`./files/${ fileName }`, (err) => {
                if (err) {
                    return res.status(500).json({ message: err.message })
                } else {
                    return res.status(200).json({ message: 'File uploaded' })
                }
            })
        }
    } catch (error) {
        return res.status(400).json({ message: error.message })
    }
}