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
                "primary": {
                    50: '#FCE4BB',
                    100: '#FBDCA8',
                    200: '#FACD81',
                    300: '#F8BD59',
                    400: '#F7AE32',
                    500: '#F59E0B',
                    600: '#C07C08',
                    700: '#8A5906',
                    800: '#543603',
                    900: '#1E1401',
                    950: '#030200'
                }
            },
        },
    },
    plugins: ['typography'],
};
