import defaultTheme from 'tailwindcss/defaultTheme';
// eslint-disable-next-line import/no-extraneous-dependencies
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/layouts/ignite/app.blade.php',
    './resources/views/layouts/ignite/*/**.blade.php'
  ],
  theme: {
    extend: {
      colors: {
        phpvms: '#067ec1',
      },
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [forms],
};
