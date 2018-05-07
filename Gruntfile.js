module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    browserSync: {
      bsFiles: {
        src: [
          'css/style.css',
          '*.php',
          '*.html',
          'js/*.js',
        ]
      },
      options: {
        notify: false,
        watchTask: true,
        debugInfo: true,
        logConnections: true,
        proxy: 'rwmwop.local',
        ghostMode: {
          scroll: true,
          forms: true,
          links: true,
          clicks: true
        },
      }
    },
    concat: {
      options: {
        separator: ';',
      },
      dist: {
        src: ['js/main.js','js/skip-link-focus-fix.js'],
        dest: 'js/min.js'
      }
    },
    csslint: {
      options: {
        csslintrc: '.csslintrc'
      },
      src: 'css/style.css'
    },
    jshint: {
      gruntfile: {
        options: {
          jshintrc: '.jshintrc'
        },
        src: 'Gruntfile.js'
      },
      all: {
        options: {
          jshintrc: '.jshintrc'
        },
        src: 'js/main.js'
      },
    },
    stylus: {
      compile: {
        options: {
          linenos: false
        },
        files: {
          'css/style.css': 'css/style.styl'
        }
      }
    },
    uglify: {
      options: {
        mangle: false
      },
      my_target: {
        files: {
          'js/min.js': 'js/min.js'
        }
      }
    },
    watch: {
      stylus: {
        files: 'css/style.styl',
        tasks: 'stylus'
      },
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: 'jshint'
      },
      all: {
        files: '<%= jshint.all.src %>',
        tasks: 'jshint'
      },
      js: {
        files: 'js/main.js',
        tasks: ['concat', 'uglify']
      },
    }
  });
  grunt.loadNpmTasks('grunt-browser-sync');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-csslint');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-stylus');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.registerTask('default', [
    'browserSync',
    'concat',
    'csslint',
    'jshint',
    'stylus',
    'uglify',
    'watch'
    ]);
};
