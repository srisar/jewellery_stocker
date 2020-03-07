'use strict';

const {src, dest, parallel, watch} = require('gulp');
const concat = require('gulp-concat');
const sass = require('gulp-sass');
const minify = require('gulp-minify');
sass.compiler = require('node-sass');


function viewsJs() {
    return src('js/views/**/*.js', {sourcemaps: true})
        .pipe(minify({noSource: true}))
        .pipe(dest('public/assets/js/views', {sourcemaps: true}));
}

function commonJs() {
    return src('js/*.js', {sourcemaps: true})
        .pipe(concat('app.js'))
        .pipe(minify({noSource: true}))
        .pipe(dest('public/assets/js'));
}

function scss() {
    return src('scss/**/*.scss', {sourcemaps: true})
        .pipe(sass().on('error', sass.logError))
        .pipe(dest('public/assets/styles', {sourcemaps: true}));
}


exports.commonJs = commonJs;
exports.viewsJs = viewsJs;
exports.scss = scss;

exports.default = function () {
    watch('js/*.js', commonJs);
    watch('js/views/**/*.js', viewsJs);
    watch('scss/**/*.scss', scss);
};