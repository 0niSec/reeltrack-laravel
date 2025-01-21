import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        container: {
            center: true,
        },
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: "#fdf3f3",
                    100: "#fce4e4",
                    200: "#facece",
                    300: "#f6abab",
                    400: "#ef7a7a",
                    500: "#e35050",
                    600: "#d03232",
                    700: "#a22424",
                    800: "#902424",
                    900: "#782424",
                    950: "#410e0e",
                },
            },
        },
    },
    plugins: [],
};
