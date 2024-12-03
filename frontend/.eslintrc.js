module.exports = {
  root: true,
  env: { node: true },
  extends: ['plugin:vue/vue3-essential', '@vue/airbnb', '@vue/typescript/recommended'],
  parserOptions: { ecmaVersion: 2020 },
  rules: {
    camelcase: 'off',
    'no-shadow': 'off',
    '@typescript-eslint/no-explicit-any': 'off',
    '@typescript-eslint/no-shadow': ['error'],
    '@typescript-eslint/ban-ts-comment': 'off',
    'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'object-curly-newline': [
      'warn',
      {
        ObjectExpression: { consistent: true },
        ObjectPattern: { consistent: true },
        ImportDeclaration: 'never',
        ExportDeclaration: { multiline: true },
      },
    ],
    'no-param-reassign': 'off',
  },
};
