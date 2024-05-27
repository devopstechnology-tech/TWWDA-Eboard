const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    daisyui: {
        themes: ["dark"],
    },
    content: [
        './resources/**/*.vue',
        // 'node_modules/preline/dist/*.js',
    ],
    theme: {
        extend: {
            backgroundImage: {
                'hero-pattern': "url('@assets/images/bg1.jpg')",
            },
            colors: {
                primary: '#0d5062',
                secondary: '#ca8a04',
                accent: '#0891b2',
                neutral: "#2a323c",
                base_100: "#1d232a",
                info: "#06b6d4",
                success: "#16a34a",
                warning: "#fef08a",
                error: "#dc2626",
                black: '#000000',
                alt: colors.zinc['500'],
                white: colors.white,
                dark: colors.zinc['900'],
                green: {
                    600: colors.green['600'],
                },
                blue: {
                    primary: '#1e78d2',
                    light: '#1B376F',
                    dark: '#0685da',
                    veryDark: '#082c50',
                },
                yellow: {
                    primary: '#EFBC2D',
                    dark: '#C07C2C',
                },
                light: colors.zinc['100'],
                red: {
                    600: colors.red['600'],
                },
                transparent: colors.transparent,
            },
            textColor: {
                alt: colors.zinc['500'],
                dark: colors.zinc['900'],
                white: colors.white,
                black: '#000000',
                primary: '#78350f',
                secondary: '#ca8a04',
                accent: '#0891b2',
                neutral: "#2a323c",
                base_100: "#1d232a",
                info: "#06b6d4",
                success: "#16a34a",
                warning: "#fef08a",
                error: "#dc2626",
                green: {
                    600: colors.green['600'],
                },
                blue: {
                    light: '#a5a5f8',
                    veryDark: '#0f0f1a',
                },
                light: colors.zinc['100'],
                red: {
                    600: colors.red['600'],
                },
                transparent: colors.transparent,
            },
        },

    },
    plugins: [
        require('@headlessui/tailwindcss'),
        require('@tailwindcss/forms'),
        require('preline/plugin'),
        // require('daisyui'),
    ],
};
