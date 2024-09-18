import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    // theme: {
    //     extend: {
    //         fontFamily: {
    //             sans: ['Figtree', ...defaultTheme.fontFamily.sans],
    //         },
    //     },
    // },

    plugins: [forms],
    
  darkMode: 'selector',
  theme: {
    extend: {
      colors: {
        page: {
          // light: '#D9D5CA',
          // dark: '#1B1B1A',
          light: '#aec064',
          dark: '#242911',
        },
        'spring-wood': {
          '50': '#F9F9F5',
          '100': '#EFEFE5',
          '200': '#DEDECA',
          '300': '#CAC9A7',
          '400': '#B3AE84',
          '500': '#A49B6B',
          '600': '#978B5F',
          '700': '#7E7250',
          '800': '#675D45',
          '900': '#544D3A',
          '950': '#2C271E',
        },
        timberwolf: {
          '50': '#F8F7F4',
          '100': '#EEEDE6',
          '150': '#E1DFD8',
          '200': '#D9D5CA',
          '300': '#C4BEAD',
          '400': '#ACA18B',
          '500': '#9B8C74',
          '600': '#8E7D68',
          '700': '#766758',
          '800': '#61544B',
          '900': '#50473E',
          '950': '#2A2420',
        },
        'deep-koamaru': {
          '50': '#F1F5FF',
          '100': '#E6EDFF',
          '200': '#D0DEFF',
          '300': '#ABC1FF',
          '400': '#7C99FF',
          '500': '#4764FF',
          '600': '#2139FF',
          '700': '#1025F1',
          '800': '#0C1FCB',
          '900': '#0C1BA6',
          '950': '#051685',
        },
        biscay: {
          '50': '#F1F5FD',
          '100': '#DFE9FA',
          '200': '#C7D8F6',
          '300': '#A1BFEF',
          '400': '#749CE6',
          '500': '#537BDE',
          '600': '#3E5ED2',
          '700': '#354CC0',
          '800': '#31409C',
          '900': '#242F66',
          '950': '#1F254C',
        },
        woodsmoke: {
          '50': '#F6F5F5',
          '100': '#E7E6E6',
          '200': '#D2CFCF',
          '300': '#B2AEAE',
          '400': '#8B8586',
          '500': '#706A6B',
          '600': '#5F5B5B',
          '700': '#514D4D',
          '800': '#464445',
          '900': '#3D3C3C',
          '950': '#1A1919',
          '1000': '#100F0F',
        },
        'shark': {
          '50': '#F7F7F8',
          '100': '#EDEDF1',
          '200': '#D8D9DF',
          '300': '#B5B6C4',
          '400': '#8D8FA3',
          '500': '#6F7188',
          '600': '#595A70',
          '700': '#494A5B',
          '800': '#3F404D',
          '900': '#373743',
          '950': '#1E1E24',
        },
        'white-lilac': {
          '50': '#FBFBFF',
          '100': '#DBDBFE',
          '200': '#BFBFFE',
          '300': '#9397FD',
          '400': '#6062FA',
          '500': '#463BF6',
          '600': '#3E25EB',
          '700': '#3E1DD8',
          '800': '#3B1EAF',
          '900': '#311E8A',
          '950': '#241754',
        },
        'saffron-mango': {
          '50': '#FEF9EC',
          '100': '#FCEEC9',
          '200': '#F9DB8E',
          '300': '#F6C151',
          '400': '#F4AB2B',
          '500': '#ED8913',
          '600': '#D2650D',
          '700': '#AE460F',
          '800': '#8E3612',
          '900': '#742E13',
          '950': '#431605',
        },
        'supernova': {
          '50': '#FEFCE8',
          '100': '#FEF8C3',
          '200': '#FEEE8A',
          '300': '#FDDD47',
          '400': '#FAC60D',
          '500': '#EAAF08',
          '600': '#CA8604',
          '700': '#A15F07',
          '800': '#854B0E',
          '900': '#713D12',
          '950': '#421F06',
        },
        'sun': {
          '50': '#fffceb',
          '100': '#fff6c6',
          '200': '#ffeb88',
          '300': '#ffda49',
          '400': '#ffc820',
          '500': '#faa90d',
          '600': '#dd7e02',
          '700': '#b85805',
          '800': '#95430b',
          '900': '#7a370d',
          '950': '#461c02',
        },
        'selective-yellow': {
          '50': '#FFFDEA',
          '100': '#FFF9C5',
          '200': '#FFF486',
          '300': '#FFE846',
          '400': '#FFD81C',
          '500': '#FEBB0D',
          '600': '#E18D00',
          '700': '#BB6302',
          '800': '#974C09',
          '900': '#7C3F0B',
          '950': '#482000',
        },
        'fern': {
          '50': '#F3FAF3',
          '100': '#E5F4E4',
          '200': '#C9E9C9',
          '300': '#9FD6A0',
          '400': '#6DBB6F',
          '500': '#54B056',
          '600': '#38813A',
          '700': '#2F6630',
          '800': '#29522B',
          '900': '#234425',
          '950': '#0F2411',
        },
        'sorbus': {
          '50': '#FFF9EC',
          '100': '#FFF3D3',
          '200': '#FFE3A5',
          '300': '#FFCD6D',
          '400': '#FFAB32',
          '500': '#FF900A',
          '600': '#FF7800',
          '700': '#CC5702',
          '800': '#A1430B',
          '900': '#82390C',
          '950': '#461A04',
        },
        'alizarin-crimson': {
          '50': '#FFF1F2',
          '100': '#FFE1E2',
          '200': '#FFC8CB',
          '300': '#FFA1A5',
          '400': '#FE6B72',
          '500': '#F63D45',
          '600': '#E01B24',
          '700': '#C0151D',
          '800': '#9E161C',
          '900': '#83191E',
          '950': '#48070A',
        },
        'chestnut': {
          '50': '#FDF4F3',
          '100': '#FAECE9',
          '200': '#F5D9D6',
          '300': '#EDBAB4',
          '400': '#E39089',
          '500': '#D4655F',
          '600': '#BF4040',
          '700': '#A03033',
          '800': '#862B30',
          '900': '#73282F',
          '950': '#3F1214',
        },
        'cornflower-blue': {
          '50': '#F0F6FE',
          '100': '#DEEAFB',
          '200': '#C5DCF8',
          '300': '#9DC7F3',
          '400': '#62A0EA',
          '500': '#4C87E5',
          '600': '#376BD9',
          '700': '#2E57C7',
          '800': '#2C48A1',
          '900': '#284080',
          '950': '#1D284E',
        },
    
      },
      screens: {
        'xs': '400px',
        'lg': '1024px',
        'xl': '1280px',
        '2xl': '1536px',
        '3xl': '2561px',
      },
      backgroundImage: {
        'content-texture': "url('@/assets/images/content-texture.png')",
        'leather-texture': "url('@/assets/images/leather-texture.png')",
        'background-texture': "url('@/assets/images/background-texture.svg')",
        'navigation-leather-tab': "url('@/assets/images/leather-tab.svg')",
        'header-sky': "url('@/assets/images/header-sky.png')",
        'theme-toggle': "url('@/assets/images/theme-selector-icon-2.svg')",
        'sky-light': "url('@/assets/images/sky-light.png')",
        'sky-dark': "url('@/assets/images/sky-dark.png')",
        'background-horizon': "url('@/assets/images/background-horizon.svg')",
        'horizon-light': "url('@/assets/images/background/light/full.svg')",
        'horizon-dark': "url('@/assets/images/background/dark/full.svg')",
      },
      backgroundSize: {
        'auto': 'auto',
        'cover': 'cover',
        'contain': 'contain',
        '2561': 'auto 160rem',
        '2560': 'auto 140rem', // 160rem',
        '1440': 'auto 90rem', // 90rem',
        '1280': 'auto 64rem', // 80rem',
        '1024': 'auto 50rem', // 64rem',
        '800': 'auto 35rem', // 50rem',
        '440': 'auto 27.5rem', // 27.5rem',
        '360': 'auto 22.5rem', // 22.5rem',
        '100': '10rem',
        '50': '50rem',
      },
      maxWidth: {
        page: '120rem',
        'slim-content': '40rem',
      },
      skew: {
        '45': '45deg',
      },
      dropShadow: {
        'home-heading': '0 0 5px rgba(0, 0, 0, 0.5)',
        'home-logo': '0 5px 10px rgba(0, 0, 0, 0.4)',
      },
      boxShadow: {
        'toolbar': '0 -2px 6px 2px rgba(0, 0, 0, 0.2)',
      },
      spacing: {
        'default': '0.75rem',
        'default-sm': '0.75rem',
        'default-md': '1.5rem',
      }
    },
    fontFamily: {
      'poppins': ["Poppins", "sans-serif", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"],
      'inter': ["Inter", "sans-serif", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"],
      'sans': ["Open Sans", "sans-serif", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"],
      'nunito': ["Nunito", "sans-serif", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"],
    },
}
};