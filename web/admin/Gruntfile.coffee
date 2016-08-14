module.exports = (grunt) ->
    require('load-grunt-tasks')(grunt)

    grunt.initConfig
        postcss:
            options:
                map: true,
                browsers: ['last 2 versions', 'ie 8', 'ie 9']
            dist:
                src: 'css/*.css'


        browserify:
            dist:
                files:
                    'js/app.js': ['js/app.js']
                options:
                    transform: ['coffeeify']
                    browserifyOptions:
                        debug: true

        coffee:
            compile:
                options:
                    bare: true
                    sourceMap: true
                    sourceMapDir: 'js/maps/'
                files:
                    'js/app.js': 'js/app.coffee'

        copy:
            normalize:
                expand: true
                cwb   : 'bower_components/normalize.css'
                src   : ['**/normalize.css']
                dest  : 'bower_components/normalize.css'
                filter: 'isFile'
                ext   : '.scss'
                flatten: true

        cssmin:
            dist:
                files:
                    'css/app.min.css': 'css/app.css'

        imagemin:
            forHTML:
                expand: true
                cwd: 'img/'
                src: ['**/*.{png,jpg,gif}']
                dest: 'img/min/'
            forCSS:
                expand: true
                cwd: 'css/img/'
                src: ['**/*.{png,jpg,gif}']
                dest: 'css/img/min/'

        replace:
            dist:
                src: ['*.html', 'css/app.css']
                overwrite: true
                replacements:[{from: "img/", to: "img/min/"}]

        sass:
            options:
                sourceMap: true
            dist:
                files:
                    'css/app.css': 'css/app.scss'

        uglify:
            dist:
                options:
                    mangle: false
                    sourceMap: true
                    sourceMapName: 'js/maps/uglify.app.min.map'
                files:
                    'js/app.min.js': ['js/app.js']

        watch:
            options:
                spawn: false
            css:
                files: ['css/*.scss', 'css/**/*.scss']
                tasks: ['sass', 'postcss']
            scripts:
                files: ['js/*.coffee', 'js/**/*.coffee']
                tasks: ['coffee', 'browserify']

    grunt.registerTask 'default', ['watch']
    grunt.registerTask(
        'build',
        [
            'sass'
            'postcss'
            'cssmin'
            'coffee'
            'browserify'
            'uglify'
        ]
    )
    grunt.registerTask(
        'buildcss',
        [
            'sass'
            'postcss'
        ]
    )