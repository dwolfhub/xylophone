var webpack = require('webpack'),
    path = require('path'),
    config = require('./config'),
    webpath = 'webpack-dev-server';

config.entry.main.unshift('webpack/hot/only-dev-server');
config.entry.main.unshift('webpack-dev-server/client?http://127.0.0.1:8081/');

config.module.loaders.push({
    test: /\.scss$/,
    loader: ['style-loader', 'css-loader', 'postcss-loader', 'sass-loader']
});

config.plugins.push(
    new webpack.NamedModulesPlugin(),
    new webpack.HotModuleReplacementPlugin(),
    new webpack.DefinePlugin({
        'APPLICATION_ENV' : '"local"',
        'GOOGLE_ANALYTICS_ID' : '"XX-XXXXXXXX-X"',
        'process.env.NODE_ENV': '"dev"'
    })
);

module.exports = Object.assign(config, {
    devtool: 'source-map',
    devServer: {
        hot: true,
        watchOptions: {
            aggregateTimeout: 300,
            poll: 1000
        }
    }
});