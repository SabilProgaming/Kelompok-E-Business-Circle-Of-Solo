import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", ...defaultTheme.fontFamily.sans],
                serif: ["Playfair Display", ...defaultTheme.fontFamily.serif],
            },
            colors: {
                "luxury-nude": "rgb(var(--color-nude) / <alpha-value>)",
                "luxury-gold": "rgb(var(--color-gold) / <alpha-value>)",
                "luxury-charcoal": "rgb(var(--color-charcoal) / <alpha-value>)",
                "luxury-cream": "rgb(var(--color-cream) / <alpha-value>)",
                "luxury-clay": "rgb(var(--color-clay) / <alpha-value>)",
            },
        },
    },

    plugins: [forms],
};
