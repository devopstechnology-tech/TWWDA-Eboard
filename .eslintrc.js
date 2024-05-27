module.exports = {
    'env': {
        'browser': true,
        'es2021': true,
    },
    'extends': [
        'eslint:recommended',
        'plugin:vue/vue3-essential',
        'plugin:@typescript-eslint/recommended',
        'prettier', // Add this line
    ],
    'ignorePatterns': ['/.eslintrc.js', '/*.config.js'],
    'overrides': [],
    'parser': 'vue-eslint-parser',
    'parserOptions': {
        'ecmaVersion': 'latest',
        'sourceType': 'module',
        'parser': '@typescript-eslint/parser',
    },
    'plugins': [
        'vue',
        '@typescript-eslint',
        'simple-import-sort'
    ],
    'rules': {
        'array-bracket-spacing': ['error', 'never'],
        'comma-dangle': ['error', 'always-multiline'],
        'eqeqeq': 'error',
        'indent': ['error', 4, {'SwitchCase': 1}],
        'max-len': ['error', 120, {'ignorePattern': '^import'}],
        'no-console': ['error', {'allow': ['warn', 'error']}],
        'object-curly-spacing': ['error', 'never'],
        'prefer-const': 'warn',
        'quotes': [
            'error',
            'single',
            {
                'avoidEscape': true,
            },
        ],
        'semi': ['error'],
        'simple-import-sort/imports': [
            'error',
            {
                'groups': [["^\\u0000", "^node:", "^@?\\w", "^", "^\\."]],
            }
        ],
        'vue/multi-word-component-names': ['off'],
        'vue/html-indent': [
            'error',
            4,
            {
                attribute: 1,
                baseIndent: 1,
                closeBracket: 0,
                alignAttributesVertically: true,
                ignores: [],
            },
        ],
        'vue/script-indent': [
            'error',
            4,
            {
                baseIndent: 0,
                switchCase: 1,
                ignores: [],
            },
        ],
        // 'prettier/prettier': ['error'], // Add Prettier rules
    },
};
