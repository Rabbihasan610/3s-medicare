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
                ink: '#0B0620',
                violet: '#6D47FF',
                violetDeep: '#4E2DCA',
                gold: '#FDBA2D',
                mist: '#EEF3F9',
                textMain: '#253042',
                textSoft: '#6B7280'
            },
            boxShadow: {
                soft: '0 10px 30px rgba(17, 24, 39, 0.08)',
                glow: '0 16px 40px rgba(109, 71, 255, 0.25)'
            },
            borderRadius: {
                '4xl': '2rem'
            },
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif']
            }
        },
    },
    plugins: [],
};