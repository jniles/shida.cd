module.exports =
    $menuTitle: $('.c-sidebar__menu__title')
    $itemContainer: $('.c-sidebar__menu__title + .c-sidebar__menu__item-container')
    init: ->
        this.$menuTitle
            .each ->
                $self = $(this)
                $itemContainer = $('.c-sidebar__menu__item-container', $self.parent())
                $self.on 'click', ->
                    $self.toggleClass 'extends'
                    $itemContainer.slideToggle 250

        $a = $('.c-sidebar__menu__item-container a.is-active')
        $itemContainer = $a.parents '.c-sidebar__menu__item-container'
        $menuTitle = $itemContainer.siblings '.c-sidebar__menu__title'

        $itemContainer.css 'display', 'block'
        $menuTitle.addClass 'extends'