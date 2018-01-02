var gulp = require('gulp'),
    configLocal = require('./gulp-config.json'),
    merge = require('merge'),
    sass = require('gulp-sass'),
    rename = require('gulp-rename'),
    scsslint = require('gulp-scss-lint'),
    isFixed = require('gulp-eslint-if-fixed'),
    autoprefixer = require('gulp-autoprefixer'),
    cleanCSS = require('gulp-clean-css'),
    include = require('gulp-include'),
    eslint = require('gulp-eslint'),
    babel = require('gulp-babel'),
    uglify = require('gulp-uglify'),
    runSequence = require('run-sequence'),
    readme = require('gulp-readme-to-markdown'),
    browserSync = require('browser-sync').create();

var configDefault = {
    src: {
      scssPath: './src/scss',
      js: './src/js'
    },
    dist: {
      cssPath: './static/css',
      js: './static/js'
    }
  },
  config = merge(configDefault, configLocal);


//
// CSS
//

// Lint all scss files
gulp.task('scss-lint', function() {
  return gulp.src(config.src.scssPath + '/*.scss')
    .pipe(scsslint());
});

// Compile + bless primary scss files
gulp.task('css-main', function() {
  return gulp.src(config.src.scssPath + '/ucf-social.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(cleanCSS())
    .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: false
    }))
    .pipe(rename('ucf-social.min.css'))
    .pipe(gulp.dest(config.dist.cssPath))
    .pipe(browserSync.stream());
});

// All css-related tasks
gulp.task('css', ['scss-lint', 'css-main']);


//
// JS
//

gulp.task('es-lint', function() {
  return gulp.src(config.src.js + '/*.js')
    .pipe(eslint({fix: true}))
    .pipe(eslint.format())
    .pipe(isFixed(config.src.js));
});

gulp.task('js-build', function() {
  return gulp.src(config.src.js + '/ucf-social.js')
    .pipe(include({
      includePaths: [config.src.js]
    }))
    .on('error', console.log)
    .pipe(babel())
    .pipe(uglify())
    .pipe(rename('ucf-social.min.js'))
    .pipe(gulp.dest(config.dist.js));
});

gulp.task('js', function() {
  runSequence('es-lint', 'js-build');
});

//
// Readme
//

// Create a Github-flavored markdown file from the plugin readme.txt
gulp.task('readme', function() {
  return gulp.src(['readme.txt'])
    .pipe(readme({
      details: false,
      screenshot_ext: [],
    }))
    .pipe(gulp.dest('.'));
});


// Rerun tasks when files change
gulp.task('watch', function() {
  if (config.sync) {
    browserSync.init({
        proxy: {
          target: config.target
        }
    });
  }

  gulp.watch(config.src.scssPath + '/**/*.scss', ['css']);
  gulp.watch(config.src.js + '/**/*.js', ['js']).on('change', browserSync.reload);
  gulp.watch('./**/*.php').on('change', browserSync.reload);
  gulp.watch('readme.txt', ['readme']);
});

// Default task
gulp.task('default', ['css', 'js', 'readme']);
