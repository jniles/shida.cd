module.exports =
    fullsize: (el) ->
        el.height $(window).height()

        $(window).on 'resize', ->
            el.height $(window).height()

    isCrolledIntoView: (el) ->
        $window = $(window)

        docViewTop = $window.scrollTop()
        docViewBottom = docViewTop + $window.height()

        elementTop = el.offset().top
        elementBottom = elementTop + el.height()

        return ((elementBottom <= docViewBottom) and (elementTop >= docViewTop))

