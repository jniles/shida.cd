Feature: The homepage
    In order to ensure a good working of our system
    we will implement the acceptances tests.

    @browser
    Scenario: The homepage
        Given I'm on the homepage
        Then the page title should contains "page d'acceuil | shida.cd"
