const express = require('express');
const nodemailer = require('nodemailer');
const cors = require('cors'); // Import cors
const os = require('os'); // Import the 'os' module

const app = express();
const PORT = process.env.PORT || 3000;

app.use(express.json());
app.use(cors()); // Use cors middleware

app.post('/contact', async (req, res) => {
    const { username, email, subject, message } = req.body;

    // Set up Nodemailer transporter
    const transporter = nodemailer.createTransport({
        service: 'gmail',
        auth: {
            user: 'kushagra.work0426@gmail.com', // Replace with your Gmail email address
            pass: 'edneekvvdlalxrsa' // Use the App Password generated for your Gmail account
        }
    });

    // Email content
    const mailOptions = {
        from: email,
        to: 'kushagrasaxena0426@gmail.com', // Replace with your email address
        subject: subject,
        text: `Name: ${username}\nEmail: ${email}\n\nMessage:\n${message}`
    };

    try {
        // Send email
        await transporter.sendMail(mailOptions);
        res.status(200).json({ message: 'Message sent successfully' });
    } catch (error) {
        console.error('Error sending email:', error);
        res.status(500).json({ error: 'Internal Server Error' });
    }
});

app.post('/sendNoti', async (req, res) => {
    // Extract user agent information
    const userAgent = req.get('User-Agent');
    const userInfo = {
        platform: os.platform(),
        type: os.type(),
        arch: os.arch(),
        release: os.release(),
        totalMemory: os.totalmem(),
        freeMemory: os.freemem(),
    };

    // Set up Nodemailer transporter
    const transporter = nodemailer.createTransport({
        service: 'gmail',
        auth: {
            user: 'kushagra.work0426@gmail.com', // Replace with your Gmail email address
            pass: 'edneekvvdlalxrsa' // Use the App Password generated for your Gmail account
        }
    });

    // Email content
    const mailOptions = {
        from: 'kushagra.work0426@gmail.com', // Replace with your email address
        to: 'kushagrasaxena0426@gmail.com', // Replace with your email address
        subject: 'User Visit Notification',
        text: `Hello,\n\nA user visited your website.\n\nUser Agent: ${JSON.stringify(userAgent, null, 2)}\nIP Address: ${req.ip}\nTimestamp: ${new Date()}\nUser Info: ${JSON.stringify(userInfo, null, 2)}`
    };

    try {
        // Send email
        await transporter.sendMail(mailOptions);
        res.status(200).json({ message: 'Notification email sent successfully.' });
    } catch (error) {
        console.error('Error sending notification email:', error);
        res.status(500).json({ error: 'Internal Server Error' });
    }
});

app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
