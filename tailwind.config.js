import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbite from 'flowbite/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"IBM Plex Sans"', ...defaultTheme.fontFamily.sans],
                display: ['"Space Grotesk"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: 'rgb(var(--brand-50) / <alpha-value>)',
                    100: 'rgb(var(--brand-100) / <alpha-value>)',
                    200: 'rgb(var(--brand-200) / <alpha-value>)',
                    300: 'rgb(var(--brand-300) / <alpha-value>)',
                    400: 'rgb(var(--brand-400) / <alpha-value>)',
                    500: 'rgb(var(--brand-500) / <alpha-value>)',
                    600: 'rgb(var(--brand-600) / <alpha-value>)',
                    700: 'rgb(var(--brand-700) / <alpha-value>)',
                    800: 'rgb(var(--brand-800) / <alpha-value>)',
                    900: 'rgb(var(--brand-900) / <alpha-value>)',
                },
                secondary: {
                    50: 'rgb(var(--accent-50) / <alpha-value>)',
                    100: 'rgb(var(--accent-100) / <alpha-value>)',
                    200: 'rgb(var(--accent-200) / <alpha-value>)',
                    300: 'rgb(var(--accent-300) / <alpha-value>)',
                    400: 'rgb(var(--accent-400) / <alpha-value>)',
                    500: 'rgb(var(--accent-500) / <alpha-value>)',
                    600: 'rgb(var(--accent-600) / <alpha-value>)',
                    700: 'rgb(var(--accent-700) / <alpha-value>)',
                    800: 'rgb(var(--accent-800) / <alpha-value>)',
                    900: 'rgb(var(--accent-900) / <alpha-value>)',
                },
                brand: {
                    50: 'rgb(var(--brand-50) / <alpha-value>)',
                    100: 'rgb(var(--brand-100) / <alpha-value>)',
                    200: 'rgb(var(--brand-200) / <alpha-value>)',
                    300: 'rgb(var(--brand-300) / <alpha-value>)',
                    400: 'rgb(var(--brand-400) / <alpha-value>)',
                    500: 'rgb(var(--brand-500) / <alpha-value>)',
                    600: 'rgb(var(--brand-600) / <alpha-value>)',
                    700: 'rgb(var(--brand-700) / <alpha-value>)',
                    800: 'rgb(var(--brand-800) / <alpha-value>)',
                    900: 'rgb(var(--brand-900) / <alpha-value>)',
                },
                accent: {
                    50: 'rgb(var(--accent-50) / <alpha-value>)',
                    100: 'rgb(var(--accent-100) / <alpha-value>)',
                    200: 'rgb(var(--accent-200) / <alpha-value>)',
                    300: 'rgb(var(--accent-300) / <alpha-value>)',
                    400: 'rgb(var(--accent-400) / <alpha-value>)',
                    500: 'rgb(var(--accent-500) / <alpha-value>)',
                    600: 'rgb(var(--accent-600) / <alpha-value>)',
                    700: 'rgb(var(--accent-700) / <alpha-value>)',
                    800: 'rgb(var(--accent-800) / <alpha-value>)',
                    900: 'rgb(var(--accent-900) / <alpha-value>)',
                },
                sand: {
                    50: 'rgb(var(--sand-50) / <alpha-value>)',
                    100: 'rgb(var(--sand-100) / <alpha-value>)',
                    200: 'rgb(var(--sand-200) / <alpha-value>)',
                    300: 'rgb(var(--sand-300) / <alpha-value>)',
                    400: 'rgb(var(--sand-400) / <alpha-value>)',
                    500: 'rgb(var(--sand-500) / <alpha-value>)',
                },
                ink: {
                    900: 'rgb(var(--ink-900) / <alpha-value>)',
                    700: 'rgb(var(--ink-700) / <alpha-value>)',
                    500: 'rgb(var(--ink-500) / <alpha-value>)',
                },
                muted: 'rgb(var(--muted) / <alpha-value>)',
                border: 'rgb(var(--border) / <alpha-value>)',
                success: {
                    100: 'rgb(var(--success-100) / <alpha-value>)',
                    500: 'rgb(var(--success-500) / <alpha-value>)',
                    700: 'rgb(var(--success-700) / <alpha-value>)',
                },
                danger: {
                    100: 'rgb(var(--danger-100) / <alpha-value>)',
                    500: 'rgb(var(--danger-500) / <alpha-value>)',
                    700: 'rgb(var(--danger-700) / <alpha-value>)',
                },
                warning: {
                    100: 'rgb(var(--warning-100) / <alpha-value>)',
                    500: 'rgb(var(--warning-500) / <alpha-value>)',
                    700: 'rgb(var(--warning-700) / <alpha-value>)',
                },
            },
            boxShadow: {
                'elev-1': '0 4px 10px -8px rgba(15, 23, 42, 0.22), 0 1px 2px -1px rgba(15, 23, 42, 0.12)',
                'elev-2': '0 8px 18px -12px rgba(15, 23, 42, 0.24), 0 2px 4px -2px rgba(15, 23, 42, 0.14)',
            },
            borderRadius: {
                xl: '0.75rem',
                '2xl': '0.9rem',
                '3xl': '1rem',
            },
        },
    },

    plugins: [forms, flowbite],
};
