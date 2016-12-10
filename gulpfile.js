"use strict";

const gulp = require('gulp');
const webpack = require('webpack-stream');
const sass = require('gulp-sass');
const outputFolder = 'public_html/dist';
const path = require('path');
const rev = require('gulp-rev');
const autoPrefixer = require('gulp-autoprefixer');
const imageMin = require('gulp-imagemin');
const watch = require('gulp-watch');

let webpackConfig = {
    cache: true,
    entry: './app/assets/js/main.js',
    output: {
        filename: '[name].js',
        sourceMapFilename: '[name].map'
    },
    devtool: '#inline-source-map',
    module: {
        loaders: [
            {
                loader: 'babel',
                test: /\.js$/,
                exclude: /node_modules/,
                query: {
                    presets: ['es2015']
                }
            }
        ]
    }
};

gulp.task('default', ['sass', 'js', 'img']);

gulp.task('clean', function (cb) {
    let fs = require('fs');
    let deleteFolderRecursive = function (path) {
        if (fs.existsSync(path)) {
            fs.readdirSync(path).forEach(function (file, index) {
                let curPath = path + "/" + file;
                if (fs.lstatSync(curPath).isDirectory()) { // recurse
                    deleteFolderRecursive(curPath);
                } else { // delete file
                    fs.unlinkSync(curPath);
                }
            });
            fs.rmdirSync(path);
        }
    };

    deleteFolderRecursive(outputFolder);

    return cb();
});

gulp.task('img', ['clean'], function () {
    return gulp.src('app/assets/img/*')
        .pipe(imageMin({
            optimizationLevel: 7,
            progressive: true,
            interlaced: true,
            multipass: true
        }))
        .pipe(gulp.dest('public_html/dist'))
});

gulp.task('sass', ['clean'], function () {
    return gulp.src('app/assets/scss/main.scss')
        .pipe(
            sass({
                outputStyle: 'compressed',
                sourceMapEmbed: true
            })
        )
        .pipe(autoPrefixer({
            browsers: ['last 2 versions']
        }))
        .pipe(rev())
        .pipe(gulp.dest(outputFolder))
        .pipe(rev.manifest('public_html/dist/assets.json', {
            base: process.cwd() + '/public_html/dist',
            merge: true
        }))
        .pipe(gulp.dest(outputFolder))
});

gulp.task('js', ['clean'], function () {
    return gulp.src('app/assets/js/main.js')
        .pipe(webpack(webpackConfig))
        .pipe(rev())
        .pipe(gulp.dest(outputFolder))
        .pipe(rev.manifest('public_html/dist/assets.json', {
            base: process.cwd() + '/public_html/dist',
            merge: true
        }))
        .pipe(gulp.dest(outputFolder))
});

gulp.task('watch', function () {
    gulp.watch(['app/assets/**/*.js', 'app/assets/**/*.scss'], ['js', 'sass']);
});