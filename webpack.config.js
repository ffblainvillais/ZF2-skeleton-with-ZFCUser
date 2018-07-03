const path      = require('path')
const webpack   = require('webpack')

let config = {
    entry: './public/js/main.js',
    output: {
        path: path.resolve(__dirname, 'dist'),
        publicPath: '/dist',
        filename: 'main.js',
    },
    resolve: {
        extensions: ['.js', '.vue'],
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
        ],
    }

}

module.exports = config
