// eslint-disable-next-line @typescript-eslint/no-var-requires
const colors = require('tailwindcss/colors');

module.exports = {
  purge: {
    content: ['./src/**/*.vue'],
    options: { safelist: ['ml-12', 'ml-24', 'ml-36', 'ml-48'] },
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
      black: colors.black,
      white: colors.white,
      yellow: colors.amber,
      blue: {
        medium: '#009EE2',
        light: '#33B1E8',
        dark: '#186387',
        bright: '#4eb8e7',
      },
      indigo: colors.indigo,
      purple: colors.violet,
      pink: colors.pink,
      green: {
        800: '#4c6f59',
        500: '#304f40',
        200: '#71bc95',
      },
      grey: {
        verylight: '#F3F4F6',
        light: '#f6eedf',
        medium: '#d1d5db',
        mediumdark: '#565654',
        dark: '#3C3C3B',
      },
      red: '#d6294f',
      parchment: '#eeece7',
    },
    extend: {
      cursor: { none: 'none' },
      backgroundImage: (theme) => ({ 'coran-manuscript': "url('~@/assets/CC-Background.png')" }),
      transitionProperty: { maxHeight: 'max-height' },
      height: { 800: '800px' },
      maxHeight: { large: '96rem' },
      minHeight: (theme) => ({ ...theme('spacing') }),
    },
  },
  variants: { extend: {} },
  plugins: [],
};
