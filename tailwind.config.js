/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
  ],
  theme: {
    container: {
      center: true,
      screens: {
        "2xl": "1400px",
      }
    },
    extend: {
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
      colors: {
        background: "#f6f6f6",
        primary: "#3b82f6",
        foreground: "#09090b",
        muted: {
          DEFAULT: "#d7d7d7",
          foreground: "#71717a",
        },
        card: "#ffffff"
      },
      borderRadius: {
        "card": "15px",
      },
      boxShadow: {
        'card': '0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08)',
      },
    },
  },
  plugins: [],
}