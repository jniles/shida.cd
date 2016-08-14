# jquery
window.jQuery  = window.$ = require 'jquery'
global.koopa = {}


# vendors
require './../bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js'
require './../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'
require './select2/select2.js'

# modules
koopa.sidebar = require './modules/sidebar.coffee'

$(document).ready ->
    koopa.sidebar.init()
    $window = $(window)

    $('.admin-select2').select2
        containerCssClass: 'tpx-select2-container'
        dropdownCssClass: 'tpx-select2-drop'

    $window.on 'load', ->
        $alert = $('#fab-alert')
        window.setTimeout ->
            $alert.fadeOut()
        , 4500
