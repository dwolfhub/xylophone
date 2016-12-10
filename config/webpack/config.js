'use strict';
var webpack = require('webpack'),
    path = require('path'),
    autoprefixer = require('autoprefixer'),
    ExtractTextPlugin = require('extract-text-webpack-plugin'),
    AssetsPlugin = require('assets-webpack-plugin');

module.exports = {
    entry: {
        main: [path.resolve(__dirname, '../../app/assets/js/main.js')]
    },
    output: {
        path: path.resolve(__dirname, '../../public_html/'),
        publicPath: '/',
        filename: 'dist/js/[name].js'
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
                query: {
                    presets: ['es2015']
                }
            },
            {
                test: /\.(jpg|png)$/,
                loader: "file-loader",
                query: {
                    name: "dist/img/[name].[ext]"
                }
            },
            {
                test: /\.svg$/,
                loader: 'url-loader',
                query: {
                    limit: 10000
                }
            },
            {
                test: /\.woff$/,
                loader: 'url-loader',
                query: {
                    limit: 10000,
                    mimetype: 'application/font-woff',
                    name: "dist/fonts/[name].[ext]"
                }
            },
            {
                test: /\.woff2$/,
                loader: 'url-loader',
                query: {
                    'limit': 10000,
                    'mimetype': 'application/font-woff2',
                    'name': "dist/fonts/[name].[ext]"
                }
            },
            {
                test: /\.(eot|ttf)$/,
                loader: "file-loader",
                query: {
                    'limit': 10000,
                    'name': "dist/fonts/[name].[ext]"
                }
            }
        ]
    },
    resolve: {
        extensions: ['.js', '.scss'],
        alias: {
            'style': path.resolve(__dirname, '../../app/assets/scss/main'),
        }
    },
    plugins: [
        new webpack.LoaderOptionsPlugin({
            options: {
                postcss: function () {
                    return [autoprefixer({browsers: ['last 3 versions', 'iOS 8']})];
                }
            }
        }),
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            "window.jQuery": "jquery"
        }),
        new webpack.NoErrorsPlugin(),
        new AssetsPlugin({filename: 'public_html/dist/assets.json'})
    ]
};
