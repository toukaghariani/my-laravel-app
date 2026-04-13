import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    DEFAULT: '#E50914',
                    hover: '#F40612',
                    dark: '#B20710',
                },
                surface: {
                    950: '#060606',
                    900: '#0a0a0a',
                    800: '#111111',
                    700: '#181818',
                    600: '#222222',
                    500: '#2a2a2a',
                    400: '#333333',
                    300: '#444444',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
