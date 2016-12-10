var webpack = require('webpack'),
    ExtractTextPlugin = require('extract-text-webpack-plugin'),
    config = require('./config');

config.output.filename = 'dist/js/[name].[hash].js';

config.module.loaders.push({
    test: /\.scss$/,
    loader: ExtractTextPlugin.extract([{
        loader: 'css-loader',
        query: {
            autoprefixer: false,
            minimize: true
        }
    },'postcss-loader', 'sass-loader'])
});

config.plugins.push(
    new ExtractTextPlugin({ filename: 'dist/css/[name].[hash].css', allChunks: true}),
    new webpack.optimize.UglifyJsPlugin({
        compress: {
            warnings: false
        },
        output: {
            comments: false
        }
    }),
    new webpack.DefinePlugin({
        'APPLICATION_ENV' : '"master"',
        'GOOGLE_ANALYTICS_ID' : '"XX-XXXXXXXX-X"',
        'process.env.NODE_ENV': '"production"'
    })
);

module.exports = config;
