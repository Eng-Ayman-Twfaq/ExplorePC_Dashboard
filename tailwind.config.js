import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
module.exports = {
    //  darkMode: 'class',
    darkMode: 'class',
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
      "./node_modules/@fortawesome/fontawesome-free/**/*.js",
    ],
    theme: {
      extend: {
        fontFamily: {
          sans: ['Tajawal', 'sans-serif'],
        },
      },
    },
    plugins: [],
  }
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],

};
