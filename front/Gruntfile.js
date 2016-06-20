// Generated on 2015-07-27 using generator-angular 0.12.1
'use strict';

module.exports = function (grunt) {

    // Time how long tasks take. Can help when optimizing build times
    require('time-grunt')(grunt);

    // Automatically load required Grunt tasks
    require('jit-grunt')(grunt, {
        useminPrepare: 'grunt-usemin'
    });

    // Configurable paths for the application
    var appConfig = {
        app: 'public',
        dist: 'target/classes/web'
    };

    var fs = require('fs');

    // Define the configuration for all the tasks
    grunt.initConfig({

        // Project settings
        stratio: appConfig,

        // Watches files for changes and runs tasks based on the changed files
        watch: {
            js: {
                files: ['<%= stratio.app %>/**/{,*/}*.js'],
                options: {
                    livereload: '<%= connect.options.livereload %>'
                }
            },
            sass: {
                files: ['<%= stratio.app %>/sass/{,*/}*.{scss,sass}'
                ],
                tasks: ['sass', 'autoprefixer']
            },
            gruntfile: {
                files: ['Gruntfile.js']
            },
            livereload: {
                options: {
                    livereload: '<%= connect.options.livereload %>'
                },
                files: [
                    '<%= stratio.app %>/**/{,*/}*.html',
                    '.tmp/styles/{,*/}*.css',
                    '<%= stratio.app %>/img/{,*/}*.{png,jpg,jpeg,gif,webp,svg}',
                    '<%= stratio.app %>/font/{,*/}*.{css,ttf,woof,woff2,eot,svg}',
                    '<%= stratio.app %>/audio/{,*/}*.{mp3,ogg,xmp}'
                ]
            }
        },

        // The actual grunt server settings
        connect: {
            options: {
                port: 9000,
                // Change this to '0.0.0.0' to access the server from outside.
                hostname: '172.19.1.67',
                livereload: 35729
            },
            livereload: {
                options: {
                    open: true,
                    middleware: function (connect) {
                        return [
                            connect.static('.tmp'),
                            connect().use(
                                '/node_modules',
                                connect.static('./node_modules')
                            ),
                            connect().use(
                                '/bower_components',
                                connect.static('./bower_components')
                            ),
                            connect().use(
                                '/public/styles',
                                connect.static('./public/styles')
                            ),
                            connect().use(
                                '/public/img',
                                connect.static('./public/img')
                            ),
                            connect().use(
                                '/public/audio',
                                connect.static('./public/audio')
                            ),
                            connect().use(
                                '/public/font',
                                connect.static('./public/font')
                            ),
                            connect.static(appConfig.app),
                            require('grunt-connect-proxy/lib/utils').proxyRequest
                        ];
                    }
                }
            },
            test: {
                options: {
                    port: 9001,
                    middleware: function (connect) {
                        return [
                            connect.static('.tmp'),
                            connect.static('test'),
                            connect().use(
                                '/node_modules',
                                connect.static('./node_modules')
                            ),
                            connect.static(appConfig.app)
                        ];
                    }
                }
            },
            dist: {
                options: {
                    open: true,
                    base: '<%= stratio.dist %>'
                }
            }
        },

        // Empties folders to start fresh
        clean: {
            dist: {
                files: [{
                    dot: true,
                    src: [
                        '.tmp',
                        '<%= stratio.dist %>/{,*/}*',
                        '!<%= stratio.dist %>/.git{,*/}*'
                    ]
                }]
            },
            server: ['.tmp', '<%= stratio.dist %>']
        },

        // Add vendor prefixed styles
        autoprefixer: {
            options: {
                browsers: ['last 1 version']
            },
            server: {
                options: {
                    map: true
                },
                files: [{
                    expand: true,
                    cwd: '.tmp/styles/',
                    src: '{,*/}*.css',
                    dest: '.tmp/styles/'
                }]
            },
            dist: {
                files: [{
                    expand: true,
                    cwd: '.tmp/styles/',
                    src: '{,*/}*.css',
                    dest: '.tmp/styles/'
                }]
            }
        },
        sass: {
            options: {
                sourceMap: true
            },
            dist: {
                files: {
                    'temp/styles/main.css': 'public/sass/main.scss'
                }
            },
            server: {
                options: {
                    debugInfo: true
                },
                files: {
                    'temp/styles/main.css': 'public/sass/main.scss'
                }
            }
        },

        // Reads HTML for usemin blocks to enable smart builds that automatically
        // concat, minify and revision files. Creates configurations in memory so
        // additional tasks can operate on them
        useminPrepare: {
            html: 'index.html',
            options: {
                dest: '<%= stratio.dist %>',
                flow: {
                    html: {
                        steps: {
                            js: ['concat', 'uglifyjs']//,
                            //css: ['cssmin']
                        },
                        post: {}
                    }
                }
            }
        },

        // Performs rewrites based on filerev and the useminPrepare configuration
        usemin: {
            html: ['<%= stratio.dist %>/{,*/}*.html'],
            css: ['<%= stratio.dist %>/styles/{,*/}*.css'],
            js: ['<%= stratio.dist %>/{,*/}*.js'],
            options: {
                assetsDirs: [
                    '<%= stratio.dist %>',
                    '<%= stratio.dist %>/images',
                    '<%= stratio.dist %>/styles'
                ],
                patterns: {
                    js: [[/(images\/[^''""]*\.(png|jpg|jpeg|gif|webp|svg))/g, 'Replacing references to images']]
                }
            }
        },

        concat: {
            options: {
                sourceMap: true
            },
            dist: {}
        },

        htmlmin: {
            dist: {
                options: {
                    collapseWhitespace: true,
                    conservativeCollapse: true,
                    collapseBooleanAttributes: true,
                    removeCommentsFromCDATA: true
                },
                files: [{
                    expand: true,
                    cwd: '<%= stratio.dist %>',
                    src: ['*.html', '/public/components/**/*.html', '/public/behaviors/**/*.html'],
                    dest: '<%= stratio.dist %>'
                }]
            }
        },

        // ng-annotate tries to make the code safe for minification automatically
        // by using the Angular long form for dependency injection.
        ngAnnotate: {
            dist: {
                files: [{
                    expand: true,
                    cwd: '.tmp/concat/scripts',
                    src: '*.js',
                    dest: '.tmp/concat/scripts'
                }]
            }
        },

        // Copies remaining files to places other tasks can use
        copy: {
            dist: {
                files: [{
                    expand: true,
                    dot: true,
                    cwd: '<%= stratio.app %>',
                    dest: '<%= stratio.dist %>',
                    src: [
                        '*.{ico,png,txt}',
                        '.htaccess',
                        '*.html',
                        'img/**/**.*',
                        'font/**.*',
                        'audio/**.*',
                        'config/**.*'
                    ]
                },
                    {
                        expand: true,
                        dot: true,
                        cwd: 'temp',
                        dest: '<%= stratio.dist %>',
                        src: ['**/{,*/}*.*']
                    },
                    {
                        expand: true,
                        cwd: '.tmp/images',
                        dest: '<%= stratio.dist %>/images',
                        src: ['generated/*']
                    }, {
                        expand: true,
                        cwd: '.tmp/styles',
                        dest: '<%= stratio.dist %>/styles',
                        src: ['**/{,*/}*.css']
                    }, {
                        expand: true,
                        cwd: '.tmp/concat/scripts',
                        dest: '<%= stratio.dist %>/scripts',
                        src: ['**/{,*/}*.js', '**/{,*/}*.js.map']
                    },
                    {
                        expand: true,
                        cwd: '<%= stratio.app %>/templates',
                        dest: '<%= stratio.dist %>/templates',
                        src: ['**/{,*/}*.html']
                    }]
            },
            styles: {
                expand: true,
                cwd: '<%= stratio.app %>/styles',
                dest: '.tmp/styles/',
                src: '{,*/}*.css'
            },
            scripts: {
                expand: true,
                cwd: '.tmp/concat/scripts',
                dest: '<%= stratio.dist %>/scripts',
                src: '{,*/}*.js'
            }
        },

        // Run some tasks in parallel to speed up the build process
        concurrent: {
            server: [
                'sass:server'
            ],
            test: [
                'sass'
            ],
            dist: [
                'sass:dist'
            ]
        },
        vulcanize: {
            dist: {
                options: {
                    abspath: '',
                    targetUrl: 'public/index.html'
                },
                files: {
                    'temp/index.html': 'target/classes/web/index.html'
                }
            }
        },
        minifyPolymer: {
            default: {
                files: [
                    {
                        expand: true,
                        cwd: '<%= stratio.app %>/components/',
                        src: ['**/*.html'],
                        dest: '<%= stratio.dist %>/components'
                    },
                    {
                        expand: true,
                        cwd: '<%= stratio.app %>/behaviors/',
                        src: ['**/*.html'],
                        dest: '<%= stratio.dist %>/behaviors'
                    },
                    {
                        expand: true,
                        cwd: '<%= stratio.app %>/bower_components/',
                        src: ['**/*.*'],
                        dest: '<%= stratio.dist %>/bower_components/'
                    }
                ]
            }
        },
        minifyPolymerCSS: {
            default: {
                files: [
                    {
                        expand: true,
                        cwd: '<%= stratio.app %>/components/',
                        src: ['**/*.css'],
                        dest: '<%= stratio.dist %>/components'
                    },
                    {
                        expand: true,
                        cwd: '<%= stratio.app %>/bower_components/',
                        src: ['**/*.css'],
                        dest: '<%= stratio.dist %>/bower_components/'
                    }
                ]
            }
        }
    });


    grunt.loadNpmTasks('grunt-vulcanize');
    grunt.loadNpmTasks('grunt-minify-polymer');
    grunt.registerTask('serve', 'Compile then start a connect web server', function (target) {
        grunt.loadNpmTasks('grunt-connect-proxy');
        if (target === 'dist') {
            return grunt.task.run(['build', 'connect:dist:keepalive']);
        }

        grunt.task.run([
            'clean:server',
            'concurrent:server',
            'configureProxies:server',
            'autoprefixer:server',
            'connect:livereload',
            'watch'
        ]);
    });

    grunt.registerTask('server', 'DEPRECATED TASK. Use the "serve" task instead', function (target) {
        grunt.log.warn('The `server` task has been deprecated. Use `grunt serve` to start a server.');
        grunt.task.run(['serve:' + target]);
    });

    grunt.registerTask('test', [
        'concurrent:test',
        'autoprefixer',
        'connect:test'
    ]);

    grunt.registerTask('build', 'Build if target is empty', function () {
        if (fs.existsSync(appConfig.dist + '/index.html')) {
            grunt.log.warn('Target already exists. If you want to force build run task `clean:dist` first');
            return true;
        }

        grunt.task.run([
            'clean:server',
            // 'vulcanize',
            'useminPrepare',
            'concurrent:dist',
            'autoprefixer',
            'concat',
            'ngAnnotate',
            'copy:dist',
            // 'usemin',
            'minifyPolymer',
            'minifyPolymerCSS'
            // 'htmlmin'
        ]);
    });

    grunt.registerTask('default', [
        'test',
        'build'
    ]);
};
