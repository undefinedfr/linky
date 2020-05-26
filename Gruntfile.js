/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */
module.exports = function(grunt) {

    // Import des modules
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.initConfig({
        // Get params from package.json
        pkg: grunt.file.readJSON('package.json'),
        paths: {
            sassDir : "assets/sass/",
            cssDir : "assets/css/",
            jsDir : "assets/js/",
            distDir : "assets/dist/"
        },

        // Compilation du sass
        sass: {
            dev: {
                options: {
                    style: 'expanded',
                    lineNumbers: true
                },
                files: [{
                    "expand": true,
                    "cwd": "<%= paths.sassDir %>",
                    "src": ["**/*.scss"],
                    "dest": "<%= paths.cssDir %>",
                    "ext": ".css"
                }]
            }
        },

        // Compression des fichiers JavaScript
        uglify: {
            options: {
                separator: ';'
            },
            scripts: {
                files: [{
                    "expand": true,
                    "cwd": "<%= paths.distDir %>",
                    "src": ['**/*.js'],
                    "dest": "<%= paths.distDir %>"
                }]
            }
        },

        // Concatene les fichiers entre eux
        concat: {
            options: {
                separator: ';'
            },
            front: {
                src: ['<%= paths.jsDir %>front/**/*.js'],
                dest: '<%= paths.distDir %>linky.js'
            },
            scripts: {
                src: ['<%= paths.jsDir %>**/*.js','!<%= paths.jsDir %>front/**/*.js'],
                dest: '<%= paths.distDir %>wp-linky.js'
            }
        },

        // Watch les fichiers JS + Sass
        watch: {
            scripts: {
                files: ['<%= paths.jsDir %>**/*.js'],
                tasks: ['concat', 'uglify']
            },
            styles: {
                files: '<%= paths.sassDir %>**/*.scss',
                tasks: ['sass:dev']
            },

        }
    });

    // Tâche pour watch + concatenation JS Lib
    grunt.registerTask('default', ['watch']);

    grunt.loadNpmTasks('grunt-simple-watch');

};
