module.exports = {
    parser: '@typescript-eslint/parser',
    parserOptions: {
        project: 'tsconfig.eslint.json',
        sourceType: 'module',
    },
    plugins: [
      '@typescript-eslint/eslint-plugin',
      'prettier'
    ],
    extends: [
        'plugin:@typescript-eslint/recommended',
        'plugin:prettier/recommended',
    ],
    root: true,
    env: {
        node: true,
        jest: true,
    },
    ignorePatterns: ['.eslintrc.js', './test/**/*'],
};
