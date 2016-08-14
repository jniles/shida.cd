import os
from selenium import webdriver
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
from pyvirtualdisplay import Display
from shell import Shell
from dotenv import load_dotenv


def before_all(context):
    # load environment variables
    filepath = os.path.join(os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__)))), '.env')
    load_dotenv(filepath)

    # create a new shell instance
    context.sh = Shell()

    # run symfony commands
    symfony_console = os.environ.get('SYMFONY_CONSOLE')
    context.sh.run('%s cache:clear' % symfony_console)
    context.sh.run('%s doctrine:fixtures:load -n' % symfony_console)


def after_all(context):
    pass


def before_scenario(context, scenario):
    # setup selenium for scenario which require @browser
    if 'browser' in scenario.tags:
        firefox_capabilities = DesiredCapabilities.FIREFOX
        firefox_capabilities['marionette'] = True
        firefox_capabilities['binary'] = '/usr/bin/firefox'

        context.display = Display(visible=0, size=(1024, 768))
        context.display.start()
        context.driver = webdriver.Firefox(capabilities=firefox_capabilities)


def after_scenario(context, scenario):
    # close selenium for scenario which require @browser
    if 'browser' in scenario.tags:
        context.driver.close()
        context.display.stop()
