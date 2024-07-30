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
            colors: {
                'peor': '#ffb991',
                'vividtangerine':'#ff9a81',
                'peor2':'#ffd49b',
                'pantone':'#f13c6f'
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],

            },
        },
    },

    plugins: [forms],
};
