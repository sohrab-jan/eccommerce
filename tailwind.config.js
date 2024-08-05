import colors from "tailwindcss/colors.js";

/** @type {import('tailwindcss').Config} */
export default {
  content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
      'node_modules/preline/dist/*.js',
  ],
  theme: {
    extend: {
        colors:{
            'pink':colors.pink
        }
    },
  },
  plugins: [
      require('preline/plugin'),
  ],
}

