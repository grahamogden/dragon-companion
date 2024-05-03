/** @type {import('tailwindcss').Config} */
export default {
  content: [],
  darkMode: 'media',
  theme: {
    extend: {
      colors: {
        // 'leather-brown': '#604633',
        'leather-brown': '#4E3C32',
        // 'parchment-pale': '#ece8d5'
        // 'parchment-pale': '#F2E6C9',
        // 'parchment-dark': '#201D18',
        parchment: {
          // 50: '#FCF9F0',
          // 100: '#F7F0DD',
          // DEFAULT: '#F2E6C9',
          // pale: '#F2E6C9',
          // 200: '#F2E6C9',
          // 300: '#E3C88E',
          // 400: '#D7AA60',
          // 500: '#CF9440',
          // 600: '#C17D35',
          // 700: '#A0632E',
          // 800: '#81502B',
          // 900: '#684226',
          // 950: '#382112',

          // 50: '#FAF7F2',
          // 100: '#F4EEE0',
          // DEFAULT: '#EEE4CE',
          // pale: '#EEE4CE',
          // 200: '#EEE4CE',
          // 300: '#DBC396',
          // 400: '#CBA56C',
          // 500: '#C08E4F',
          // 600: '#B27B44',
          // 700: '#94623A',
          // 800: '#784F34',
          // 900: '#61422D',
          // 950: '#342216',

          50: '#F8F6F4',
          100: '#EFECE5',
          DEFAULT: '#D9D0BF',
          pale: '#D9D0BF',
          200: '#D9D0BF',
          300: '#CABDA7',
          400: '#B49F83',
          500: '#A5896A',
          600: '#98795E',
          700: '#7F634F',
          800: '#685144',
          900: '#554339',
          950: '#2D231D',
        },
        'parchment-dark': {
          DEFAULT: '#201D18',
          50: '#F4F5F1',
          100: '#E5E6DB',
          200: '#CCCEBA',
          300: '#B1B292',
          400: '#9B9A74',
          500: '#8C8A66',
          600: '#787456',
          700: '#615B47',
          800: '#544E3F',
          900: '#4A4439',
          950: '#201D18',
        },
        'dark-brown': '#1A1918',
        'bright-blue': '#194AED',
        'light-blue': '#7EC5F6',
        'light-yellow': '#E5DED9',
      },
      backgroundImage: {
        'content-texture': "url('/src/assets/images/content-texture.png')",
        'leather-texture': "url('/src/assets/images/leather-texture.png')",
        'background-texture': "url('/src/assets/images/background-texture.svg')",
        'navigation-leather-tab': "url('/src/assets/images/leather-tab.svg')",
      },
      backgroundSize: {
        'auto': 'auto',
        'cover': 'cover',
        'contain': 'contain',
        '400': '40rem',
        '300': '30rem',
        '200': '20rem',
      },
      maxWidth: {
        page: '120rem',
      }
    },
  },
  variants: {
    extend: {}
  },
  plugins: [],
  purge: [
    './index.html',
    './src/**/*.{vue,js,ts}',
  ]
}

