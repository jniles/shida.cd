'use strict'

window.jQuery = window.$ = require './../bower_components/jquery/dist/jquery.min.js'

require './../bower_components/imgLiquid/js/imgLiquid-min.js'
require './select2/select2.js'

# uitils functions
utils = require './utils.coffee'

# modules

application = {}
application.alert = require './modules/alert.coffee'

$(document).ready ->

    application.alert.init()

    $sideMenuContainer = $('#side-menu__container')
    $baseHeader = $('#base-header')
    $baseMenu = $('#base-menu')
    $window = $(window)
    $sm1 = $('#start-side-menu-1')
    $sm2 = $('#user__container')
    $submenuStart = $('#submenu__container__button')
    $submenu = $('#submenu')
    $submenuContainerItems = $('#submenu__container__items')

    $sm1.on 'click', (e) ->
        e.preventDefault()
        e.stopPropagation()
        $sideMenuContainer.addClass('is-visible')

    $sm2.on 'click', (e) ->
        e.preventDefault()
        e.stopPropagation()
        $sideMenuContainer.addClass('is-visible')

    $('.side-menu__bottom, .side-menu').on 'click', (e) ->
        e.stopPropagation()

    $('.side-menu__container a.close').on 'click', (e) ->
        e.preventDefault()

    $submenu.on 'click', (e) ->
        e.stopPropagation()

    $('body').on 'click', ->
        $sideMenuContainer.removeClass 'is-visible'
        $submenu.removeClass 'show-items'

    $submenuStart.on 'click', (e) ->
        e.preventDefault()
        $submenu.toggleClass 'show-items'

    utils.fullsize $('#base-header')


    $window.on 'scroll', ->
        if $baseHeader.length isnt 0
            windowScrollTop = $window.scrollTop()

            if windowScrollTop >= $baseHeader.height()
                # console.log "window #{windowScrollTop} -> header #{$baseHeader.height()}"
                $baseMenu.addClass 'menu--colored'
            else
                # console.log "initial value"
                $baseMenu.removeClass 'menu--colored'

    $('.fab-select2').select2
        containerCssClass: 'tpx-select2-container select2-container-lg'
        dropdownCssClass: 'tpx-select2-drop'

    $('.site-select2').select2
        containerCssClass: 'tpx-select2-container'
        dropdownCssClass: 'tpx-select2-drop'

    # resizing images
    $('.data-index__item .picture-container, \
        .data-detail .picture-container, \
        .site__header .picture-container, \
        .user__info .picture-container, \
        .user__container, \
        .timeline__section__item .picture-container').imgLiquid
        onItemFinish: (index, container, img) ->
            container.animate
                'opacity': 1
            , 750
