module.exports =
    init: ->
        $alertControl = $('#alert__control')
        $alert = $alertControl.parents '.alert'
        $window = $(window)

        hideAlert = ->
            $alert.fadeOut
                complete: ->
                    $alert.remove()


        $alertControl.on 'click', (e) ->
            e.preventDefault()
            hideAlert()

        $window.on 'load', ->
            window.setTimeout hideAlert
            , 4000
