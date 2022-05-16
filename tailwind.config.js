const colors = require('tailwindcss/colors');
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
      './resources/**/*.blade.php',
      './storage/framework/views/*.php',
      './vendor/filament/**/*.blade.php',
      './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  safelist: [
      'bg-green-500',
      'bg-gray-500',
  ],
  theme: {
    extend: {
        colors: {
            danger: colors.rose,
            primary: colors.blue,
            success: colors.green,
            warning: colors.yellow,
        },
        fontSize: {
          '3xs': '.40rem',
          '2xs': '.50rem',
        },
        fontFamily: {
            sans: ['Nunito', ...defaultTheme.fontFamily.sans],
        },
    },
  },
  plugins: [
      require('@tailwindcss/forms')
  ],
}
