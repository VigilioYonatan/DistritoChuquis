const { series, src, dest, watch, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const imagenmin = require('gulp-imagemin');
const notify = require('gulp-notify');
const webp = require('gulp-webp');
//utilidades css
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');
const sourcemaps = require('gulp-sourcemaps');

sass.compiler = require('dart-sass');

//utilidades js
const concat = require('gulp-concat');
const terser =require('gulp-terser-js');
const rename = require('gulp-rename');




//path
const paths = {
    imagenes: "./src/img/**/*",
    scss: './src/scss/**/*.scss',
    js: './src/js/**/*.js',
    ico: './node_modules/@fortawesome/fontawesome-free/webfonts/*',
    fonts: './src/fonts/**/*',
    video: './src/video/**/*',
    html: './user/includes/header.php'
};


// css sass
function css(){
    return src(paths.scss)
        .pipe( sourcemaps.init() )
        .pipe( sass() )
        .pipe( postcss( [autoprefixer(), cssnano() ]))
        .pipe( sourcemaps.write('.') )
        .pipe( dest("./build/css") );
}

function iconsFontawesome(){
    return src(paths.ico)
        .pipe( dest("./build/webfonts"));
}

function fuentesPoppins(){
    return src(paths.fonts)
        .pipe( dest('./build/fonts'));
}
function video(){
    return src(paths.video)
        .pipe( dest('./build/video'));
}


//js
function javascript(){
    return src(paths.js)
        .pipe( sourcemaps.init())
        .pipe( concat('bundle.js'))
        .pipe( terser() )
        .pipe( sourcemaps.write('.'))
        .pipe( rename( {suffix: '.min' }))
        .pipe( dest("./build/js"));
        
}

//minificar imagen
function imagenes(){
    return src(paths.imagenes)
        .pipe( imagenmin() )
        .pipe( dest("./build/img"));
}

//jpg to webp
function versionWebp(){
    return src(paths.imagenes)
        .pipe( webp() )
        .pipe( dest("./build/img"))
        .pipe ( notify( { message: 'Completado'} ))
}


// watch css
function watchArchivos(){
    watch( paths.scss, css );  // * = la carpeta actual - ** = Todos los archivos con esa extension
    watch( paths.js, javascript);
}


exports.css = css;
exports.iconsFontawesome = iconsFontawesome;
exports.fuentesPoppins = fuentesPoppins;
exports.video = video;
exports.imagenes = imagenes;
exports.watchArchivos = watchArchivos;
exports.versionWebp = versionWebp;
exports.default = series( css, iconsFontawesome,fuentesPoppins, video, javascript, imagenes, versionWebp, watchArchivos);  // lo que desees ejecutar y no uno por uno