const tailwindcss = require('@tailwindcss/postcss');
const forms = require('@tailwindcss/forms');

module.exports ={
    Plugins: [
        tailwindcss(),
        forms,
        require('autoprefixer'),
    ]
};