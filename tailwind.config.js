import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './Modules/**/resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                display: ['Syne', ...defaultTheme.fontFamily.sans],
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                koro: {
                    ink: '#070b14',
                    slate: '#0f1629',
                    panel: '#141c32',
                    border: 'rgba(255,255,255,0.08)',
                    copper: '#e8a54b',
                    'copper-dark': '#c47d2a',
                    teal: '#2dd4bf',
                    mist: '#94a3b8',
                    snow: '#f1f5f9',
                },
            },
            backgroundImage: {
                'koro-mesh': 'radial-gradient(ellipse 80% 60% at 50% -10%, rgba(232,165,75,0.12), transparent), radial-gradient(ellipse 50% 40% at 100% 50%, rgba(45,212,191,0.06), transparent)',
                'koro-grid': 'linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px)',
            },
            backgroundSize: {
                grid: '48px 48px',
            },
            animation: {
                'fade-up': 'fadeUp 0.6s ease-out both',
                'fade-in': 'fadeIn 0.5s ease-out both',
            },
            keyframes: {
                fadeUp: {
                    '0%': { opacity: '0', transform: 'translateY(16px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
            },
        },
    },
    plugins: [],
};
