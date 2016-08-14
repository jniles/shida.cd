import os
from behave import *
from robber import expect


@given(u'I\'m on the homepage')
def the_homepage(context):
    context.driver.get(os.environ.get('APP_URL'))


@then(u'the page title should contains "{page_title}"')
def the_homepage_should_contains(context, page_title):
    expect(context.driver.title).to.contain(page_title)
