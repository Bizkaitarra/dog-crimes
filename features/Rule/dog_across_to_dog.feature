Feature:
  In order to prove dog across to dog rule

  Scenario: Cider and Ace should be across but no dogs are placed
    Given a new game with crime "Cake" is created
    And the rule is that "Cider" is across to "Ace"
    When the rule is checked
    Then the result is that the rule has been meet not meet nor violated