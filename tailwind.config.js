import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', 'sans-serif'],
                display: ['Fredoka', 'sans-serif'], // Font Fun untuk Headings
            },
            colors: {
                electricBlue: '#2952FF',
                electricOrange: '#FF6600',
            },
            boxShadow: {
                'fun': '0 8px 0px 0px #e5e7eb', // Efek 3D kartun
                'fun-blue': '0 6px 0px 0px #1e3a8a',
                'fun-orange': '0 6px 0px 0px #c2410c',
            }
        },
    },
    plugins: [],
}
